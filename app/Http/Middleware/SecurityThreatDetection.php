<?php

namespace App\Http\Middleware;

use App\Models\BlockedIp;
use App\Models\SecurityLog;
use App\Models\SecuritySetting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SecurityThreatDetection
{
    protected array $excludedRoutes = [
        // Non-admin routes yang aman di-skip sepenuhnya
        'storage/*',
        'logout',
        'sanctum/*',
        '_ignition/*',
        'telescope/*',
        '__clockwork/*',
    ];

    // Route admin yang benar-benar perlu di-exclude (file upload & rich text editor)
    // — kontennya sengaja mengandung HTML/script, sehingga XSS/SQLi detection tidak relevan
    protected array $adminUploadRoutes = [
        'admin/storage/*',
        'admin/storage/upload-editor-image',
        'admin/*/upload*',
        'admin/storage*',
    ];

    protected array $suspiciousPatterns;
    protected array $scannerAgents;
    protected array $sqlInjectionPatterns;
    protected array $xssPatterns;
    protected array $pathTraversalPatterns;
    protected array $commandInjectionPatterns;
    protected array $fileInclusionPatterns;

    protected int $blockThreshold = 5;
    protected int $blockDurationHours = 24;

    public function __construct()
    {
        $config = config('security-patterns');
        $this->suspiciousPatterns = $config['url_attack_patterns'] ?? [];
        $this->scannerAgents = $config['scanner_agents'] ?? [];
        $this->sqlInjectionPatterns = $config['sql_injection'] ?? [];
        $this->xssPatterns = $config['xss'] ?? [];
        $this->pathTraversalPatterns = $config['path_traversal'] ?? [];
        $this->commandInjectionPatterns = $config['command_injection'] ?? [];
        $this->fileInclusionPatterns = $config['file_inclusion'] ?? [];
    }

    public function handle(Request $request, Closure $next): Response
    {
        try {
            if ($this->isExcludedRoute($request)) {
                return $next($request);
            }

            $settings = $this->loadSettings();
            if (!$settings?->enable_suspicious_blocking) {
                return $next($request);
            }

            $ip = $request->ip() ?? '0.0.0.0';

            if ($this->isWhitelisted($ip, $settings)) {
                return $next($request);
            }

            if ($this->isBlacklisted($ip, $settings)) {
                SecurityLog::logThreat($ip, 'blocked_ip', $request->fullUrl(), null, null, 'high', true);
                return $this->blockResponse($request);
            }

            if ($this->isIpBlocked($ip)) {
                SecurityLog::logThreat($ip, 'blocked_ip', $request->fullUrl(), null, null, 'high', true);
                return $this->blockResponse($request);
            }

            // Route admin (non-upload) dijalankan dalam mode log-only: deteksi tetap berjalan
            // untuk audit trail insider threat / session hijacking, tapi tidak memblokir request.
            $adminLogOnly = $this->isAdminRoute($request) && !$this->isAdminUploadRoute($request);

            if ($this->hasSuspiciousUrl($request)) {
                $this->recordThreat($request, $ip, 'suspicious_url', $settings);
                if (!$adminLogOnly) {
                    return $this->blockResponse($request);
                }
            }

            if ($this->hasSuspiciousUserAgent($request)) {
                $this->recordThreat($request, $ip, 'suspicious_agent', $settings);
                if (!$adminLogOnly) {
                    return $this->blockResponse($request);
                }
            }

            $inputsToCheck = $this->collectInputs($request);
            $threat = $this->detectThreat($inputsToCheck, $request);

            if ($threat) {
                $this->recordThreat($request, $ip, $threat['type'], $settings, $threat['input'], $threat['pattern']);
                if (!$adminLogOnly) {
                    return $this->blockResponse($request);
                }
            }
        } catch (\Throwable $e) {
            Log::error('SecurityThreatDetection error: ' . $e->getMessage());
        }

        return $next($request);
    }

    protected function isExcludedRoute(Request $request): bool
    {
        foreach ($this->excludedRoutes as $route) {
            if ($request->is($route)) {
                return true;
            }
        }

        return false;
    }

    protected function isAdminRoute(Request $request): bool
    {
        return $request->is('admin/*') || $request->is('admin');
    }

    protected function isAdminUploadRoute(Request $request): bool
    {
        foreach ($this->adminUploadRoutes as $route) {
            if ($request->is($route)) {
                return true;
            }
        }

        return false;
    }

    protected function loadSettings(): ?SecuritySetting
    {
        try {
            $settings = Cache::remember('security_settings', 300, fn() => SecuritySetting::first());

            if ($settings) {
                $this->blockThreshold = $settings->block_threshold ?? 5;
                $this->blockDurationHours = $settings->block_duration_hours ?? 24;
            }

            return $settings;
        } catch (\Exception $e) {
            return null;
        }
    }

    protected function isWhitelisted(string $ip, SecuritySetting $settings): bool
    {
        return in_array($ip, $settings->getWhitelistArray());
    }

    protected function isBlacklisted(string $ip, SecuritySetting $settings): bool
    {
        return in_array($ip, $settings->getBlacklistArray());
    }

    protected function isIpBlocked(string $ip): bool
    {
        try {
            return BlockedIp::isBlocked($ip);
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function hasSuspiciousUrl(Request $request): bool
    {
        $checkStrings = array_filter([
            $request->path(),
            urldecode($request->getRequestUri()),
        ]);

        foreach ($checkStrings as $string) {
            foreach ($this->suspiciousPatterns as $pattern) {
                if (@preg_match($pattern, $string)) {
                    return true;
                }
            }
        }

        return false;
    }

    protected function hasSuspiciousUserAgent(Request $request): bool
    {
        $userAgent = strtolower($request->userAgent() ?? '');
        if (empty($userAgent)) {
            return false;
        }

        foreach ($this->scannerAgents as $agent) {
            if (str_contains($userAgent, strtolower($agent))) {
                return true;
            }
        }

        return false;
    }

    protected function collectInputs(Request $request): array
    {
        $inputs = ['url_path' => urldecode($request->path())];

        if ($queryString = $request->getQueryString()) {
            $inputs['query_string'] = urldecode($queryString);
        }

        foreach ($request->all() as $key => $value) {
            if (is_string($value)) {
                $inputs["input_{$key}"] = $value;
            } elseif (is_array($value)) {
                $inputs["input_{$key}"] = json_encode($value);
            }
        }

        return array_filter($inputs);
    }

    protected function detectThreat(array $inputs, Request $request): ?array
    {
        $categories = [
            'sql_injection' => $this->sqlInjectionPatterns,
            'xss' => $this->xssPatterns,
            'path_traversal' => $this->pathTraversalPatterns,
            'command_injection' => $this->commandInjectionPatterns,
            'file_inclusion' => $this->fileInclusionPatterns,
        ];

        foreach ($inputs as $source => $value) {
            if (empty($value) || !is_string($value)) {
                continue;
            }

            foreach ($categories as $type => $patterns) {
                foreach ($patterns as $pattern) {
                    try {
                        if (@preg_match($pattern, $value)) {
                            return [
                                'type' => $type,
                                'pattern' => $pattern,
                                'input' => $value,
                                'source' => $source,
                            ];
                        }
                    } catch (\Throwable $e) {
                        continue;
                    }
                }
            }
        }

        return null;
    }

    protected function recordThreat(
        Request $request,
        string $ip,
        string $type,
        SecuritySetting $settings,
        ?string $input = null,
        ?string $pattern = null
    ): void {
        try {
            $key = "threat_count:{$ip}";
            $count = Cache::increment($key);
            if ($count === 1) {
                Cache::put($key, 1, now()->addHour());
            }

            $todayKey = 'security_attacks_' . date('Y-m-d');
            Cache::increment($todayKey);
            Cache::put('security_attacks_today', Cache::get($todayKey, 0), now()->endOfDay());

            SecurityLog::logThreat(
                $ip,
                $type,
                $request->fullUrl(),
                $input,
                $pattern,
                $count >= 3 ? 'high' : 'medium',
                $count >= $this->blockThreshold
            );

            if ($settings->log_security_events) {
                Log::warning('Suspicious activity detected', [
                    'ip' => $ip,
                    'type' => $type,
                    'path' => $request->path(),
                    'user_agent' => $request->userAgent(),
                    'count' => $count,
                ]);
            }

            if ($count >= $this->blockThreshold) {
                BlockedIp::blockIp($ip, "Auto-blocked: {$type}", $this->blockDurationHours);
            }
        } catch (\Exception $e) {
            Log::error('Error recording suspicious activity: ' . $e->getMessage());
        }
    }

    protected function blockResponse(Request $request): Response
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Access Denied'], 403);
        }

        return response()->view('errors.403', [], 403);
    }
}
