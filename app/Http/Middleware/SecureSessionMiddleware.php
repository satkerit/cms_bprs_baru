<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SecureSessionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Implements additional session security measures:
     * - Session fixation protection
     * - IP address validation
     * - User agent validation
     * - Session hijacking detection
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return $next($request);
        }

        // Cache user role in session to avoid DB query on every request
        $this->cacheUserRoleInSession();

        if (!Session::has('security_fingerprint')) {
            $this->initializeSessionSecurity($request);
        }

        // Validate session security
        if (!$this->validateSessionSecurity($request)) {
            $this->handleSessionViolation($request);
            return redirect()->route($this->resolveLoginRoute($request))
                ->with('error', 'Sesi Anda telah berakhir karena alasan keamanan. Silakan login kembali.');
        }

        // Regenerate session ID periodically (every 30 minutes)
        if ($this->shouldRegenerateSession()) {
            $request->session()->regenerate();
            Session::put('last_regeneration', now()->timestamp);
        }

        return $next($request);
    }

    /**
     * Initialize session security fingerprint
     */
    protected function initializeSessionSecurity(Request $request): void
    {
        $clientIp = $request->ip() ?? '0.0.0.0';
        Session::put('security_fingerprint', [
            'ip' => $clientIp,
            'user_agent' => $request->userAgent(),
            'device_fp' => $request->cookie('bprs_device_fp', ''),
            'created_at' => now()->timestamp,
            'last_activity' => now()->timestamp,
            'last_regeneration' => now()->timestamp,
        ]);
    }

    /**
     * Validate session security.
     *
     * Returns true if session is valid, false if session should be terminated.
     *
     * Strategy: IP and UA changes are common (dynamic ISP, NAT, browser updates)
     * and should NOT trigger forced logout. We silently update the fingerprint.
     * The ONLY case where we terminate the session is when:
     * 1. The device_fp cookie was initially set (stored_fp is non-empty), AND
     * 2. The current device_fp cookie does NOT match the stored one.
     *
     * This is a true indicator of session hijacking (different device).
     */
    protected function validateSessionSecurity(Request $request): bool
    {
        $fingerprint = Session::get('security_fingerprint');

        if (!$fingerprint) {
            \Log::warning('Security fingerprint missing from session', [
                'user_id' => auth()->id(),
                'ip' => $request->ip(),
            ]);
            return false;
        }

        $issues = [];

        // ─── IP Address Validation ───
        // Silently update IP on change — dynamic IPs are normal and should
        // NOT trigger session termination. We only track this for audit purposes.
        if (config('session.strict_ip_check', app()->environment('production'))) {
            $originalIp = $fingerprint['ip'] ?? '0.0.0.0';
            $currentIp = $request->ip() ?? '0.0.0.0';

            $normalizedOriginal = $this->normalizeIp($originalIp);
            $normalizedCurrent = $this->normalizeIp($currentIp);

            if ($normalizedOriginal !== $normalizedCurrent) {
                $fingerprint['ip'] = $currentIp;
                Session::put('security_fingerprint', $fingerprint);

                $transitionType = $this->isDualStackTransition($normalizedOriginal, $normalizedCurrent)
                    ? 'dual-stack transition'
                    : 'IP change';

                \Log::info('Session IP updated automatically', [
                    'user_id' => auth()->id(),
                    'type' => $transitionType,
                    'original_ip' => $originalIp,
                    'current_ip' => $currentIp,
                ]);
            }
        }

        // ─── User Agent Validation ───
        // Silently update UA on change — browser auto-updates are common.
        $originalUaHash = $this->getUaHash($fingerprint['user_agent']);
        $currentUaHash = $this->getUaHash($request->userAgent());
        if ($originalUaHash !== $currentUaHash) {
            \Log::info('User Agent changed (browser update or privacy extension)', [
                'user_id' => auth()->id(),
                'original_ua' => substr($fingerprint['user_agent'] ?? '', 0, 150),
                'current_ua' => substr($request->userAgent() ?? '', 0, 150),
            ]);
            // Update stored UA
            $fingerprint['user_agent'] = $request->userAgent();
            Session::put('security_fingerprint', $fingerprint);
        }

        // ─── Device Fingerprint Validation (TRUE hijacking detection) ───
        // Only kill session if the device fingerprint cookie was stored
        // and the current one differs — this means a different device/cloned cookie.
        $storedFp = $fingerprint['device_fp'] ?? '';
        $currentFp = $request->cookie('bprs_device_fp', '');

        if ($storedFp !== '' && $currentFp !== '' && $storedFp !== $currentFp) {
            \Log::critical('Session terminated: device fingerprint mismatch (possible hijacking)', [
                'user_id' => auth()->id(),
                'ip' => $request->ip(),
                'url' => $request->fullUrl(),
                'stored_fp_hash' => substr(md5($storedFp), 0, 8),
                'current_fp_hash' => substr(md5($currentFp), 0, 8),
            ]);
            return false;
        }

        // Update stored device fingerprint if we received one but didn't store one
        if ($currentFp !== '' && $storedFp === '') {
            $fingerprint['device_fp'] = $currentFp;
            Session::put('security_fingerprint', $fingerprint);
        }

        // Log minor anomalies for debugging
        if (!empty($issues)) {
            \Log::info('Session security checked (minor anomalies tolerated)', [
                'user_id' => auth()->id(),
                'issues' => $issues,
            ]);
        }

        // Update last activity
        Session::put('security_fingerprint.last_activity', now()->timestamp);

        return true;
    }

    /**
     * Check if session should be regenerated
     */
    protected function shouldRegenerateSession(): bool
    {
        $fingerprint = Session::get('security_fingerprint');

        if (!$fingerprint || !isset($fingerprint['last_regeneration'])) {
            return true;
        }

        // Regenerate every 120 minutes (reduced from 30 min to prevent race conditions)
        // Config key from config/security.php: 'security.session.regenerate_interval'
        $regenerationInterval = (config('security.session.regenerate_interval', 120)) * 60;
        return (now()->timestamp - $fingerprint['last_regeneration']) > $regenerationInterval;
    }

    /**
     * Handle session security violation
     */
    protected function handleSessionViolation(Request $request): void
    {
        // Log the violation with full context for debugging
        $violationContext = [
            'user_id' => auth()->id(),
            'ip' => $request->ip() ?? '0.0.0.0',
            'user_agent' => $request->userAgent(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'referer' => $request->header('referer'),
        ];

        // Add fingerprint details if available
        $fingerprint = Session::get('security_fingerprint');
        if ($fingerprint) {
            $violationContext['fingerprint_ip'] = $fingerprint['ip'] ?? null;
            $violationContext['fingerprint_ua'] = substr($fingerprint['user_agent'] ?? '', 0, 150);
            $violationContext['fingerprint_age'] = (now()->timestamp - ($fingerprint['created_at'] ?? now()->timestamp));
        }

        \Log::alert('Session security violation — user logged out', $violationContext);

        // Logout the user
        auth()->logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Regenerate CSRF token
        $request->session()->regenerateToken();
    }

    /**
     * Check if IP change is due to IPv4/IPv6 dual-stack transition
     */
    private function isDualStackTransition(string $original, string $current): bool
    {
        $isOriginalV4 = (bool) filter_var($original, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
        $isCurrentV4 = (bool) filter_var($current, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
        return $isOriginalV4 !== $isCurrentV4;
    }

    private function resolveLoginRoute(Request $request): string
    {
        return 'admin.login';
    }

    /**
     * Cache user role in session to avoid repeated DB queries.
     * The session cache is invalidated inside RoleController when role changes.
     */
    private function cacheUserRoleInSession(): void
    {
        if (!Session::has('cached_role')) {
            $user = auth()->user()->load('roleModel.permissions');

            Session::put('cached_role', [
                'name' => $user->roleModel?->name,
                'display_name' => $user->roleModel?->display_name,
                'permissions' => $user->roleModel?->permissions?->pluck('name')->toArray() ?? [],
            ]);
        }
    }

    /**
     * Public helper — called by RoleController after role assignment changes.
     */
    public static function clearCachedRole(): void
    {
        Session::forget('cached_role');
    }

    private function getUaHash(?string $userAgent): string
    {
        if ($userAgent === null || $userAgent === '') {
            return 'unknown';
        }

        // Extract browser family and platform (more robust approach)
        // Focus on stable identifiers: Browser family, Platform, Device type

        // Normalize whitespace
        $ua = preg_replace('/\s+/', ' ', trim($userAgent));

        // Extract key components:
        // 1. Browser engine (AppleWebKit, Gecko, Trident)
        // 2. Platform (Windows, Mac, Linux, Android, iOS)
        // 3. Mobile indicator
        $components = [];

        // Detect platform
        if (preg_match('/(Windows NT \d+\.\d+|Mac OS X|Linux|Android|iPhone|iPad)/i', $ua, $match)) {
            // Normalize Windows versions
            if (str_starts_with($match[1], 'Windows NT')) {
                $components[] = 'Windows';
            } else {
                $components[] = $match[1];
            }
        }

        // Detect browser engine (major version only for stability)
        if (preg_match('/(Chrome|Firefox|Safari|Edge|Opera)\/(\d+)/i', $ua, $match)) {
            $components[] = $match[1]; // Browser name only, ignore minor version
        } elseif (preg_match('/(AppleWebKit|Gecko)/i', $ua, $match)) {
            $components[] = $match[1];
        }

        // Detect mobile vs desktop
        if (stripos($ua, 'Mobile') !== false || stripos($ua, 'Android') !== false) {
            $components[] = 'Mobile';
        } else {
            $components[] = 'Desktop';
        }

        // If no components extracted, use first 80 chars as fallback
        if (empty($components)) {
            $components[] = substr($ua, 0, 80);
        }

        $fingerprint = implode('|', $components);
        return md5($fingerprint);
    }

    /**
     * Normalize IP for comparison — handle localhost & IPv4-mapped-IPv6
     */
    private function normalizeIp(string $ip): string
    {
        if (in_array($ip, ['127.0.0.1', '::1', 'localhost'])) {
            return '127.0.0.1';
        }
        // Strip IPv4-mapped IPv6 prefix
        if (str_starts_with($ip, '::ffff:')) {
            return substr($ip, 7);
        }
        return $ip;
    }
}
