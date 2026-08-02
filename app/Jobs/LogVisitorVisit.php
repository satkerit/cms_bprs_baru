<?php

namespace App\Jobs;

use App\Models\VisitorLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class LogVisitorVisit implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public int $tries = 2;

    /**
     * The maximum number of unhandled exceptions to allow before failing.
     */
    public int $maxExceptions = 1;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $ip,
        public readonly string $userAgent,
        public readonly string $url,
        public readonly ?string $referrer,
        public readonly string $sessionId,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Deduplicate: skip if same session + URL logged within last 5 minutes
        $exists = VisitorLog::where('session_id', $this->sessionId)
            ->where('url', $this->url)
            ->where('created_at', '>=', now()->subMinutes(5))
            ->exists();

        if ($exists) {
            return;
        }

        $deviceInfo = VisitorLog::parseUserAgent($this->userAgent);
        $geoInfo = $this->getGeoInfo($this->ip);

        VisitorLog::create([
            'ip_address' => $this->ip,
            'country' => $geoInfo['country'] ?? null,
            'country_code' => $geoInfo['country_code'] ?? null,
            'city' => $geoInfo['city'] ?? null,
            'region' => $geoInfo['region'] ?? null,
            'timezone' => $geoInfo['timezone'] ?? null,
            'latitude' => $geoInfo['latitude'] ?? null,
            'longitude' => $geoInfo['longitude'] ?? null,
            'isp' => $geoInfo['isp'] ?? null,
            'device_type' => $deviceInfo['device_type'],
            'browser' => $deviceInfo['browser'],
            'browser_version' => $deviceInfo['browser_version'],
            'platform' => $deviceInfo['platform'],
            'platform_version' => $deviceInfo['platform_version'],
            'user_agent' => $this->userAgent,
            'url' => $this->url,
            'referrer' => $this->referrer,
            'session_id' => $this->sessionId,
        ]);
    }

    /**
     * Get geolocation information for an IP address.
     *
     * @return array<string, string|null>
     */
    private function getGeoInfo(string $ip): array
    {
        if (in_array($ip, ['127.0.0.1', '::1']) || str_starts_with($ip, '192.168.') || str_starts_with($ip, '10.')) {
            return ['country' => 'Local', 'country_code' => 'LO', 'city' => 'Local'];
        }

        try {
            // Timeout pendek agar job (yang kini dijalankan afterResponse) tidak memblokir proses.
            $context = stream_context_create(['http' => ['timeout' => 3]]);
            $response = @file_get_contents("http://ip-api.com/json/{$ip}?fields=status,country,countryCode,region,city,timezone,lat,lon,isp", false, $context);
            if ($response) {
                $data = json_decode($response, true);
                if ($data && ($data['status'] ?? null) === 'success') {
                    return [
                        'country' => $data['country'] ?? null,
                        'country_code' => $data['countryCode'] ?? null,
                        'city' => $data['city'] ?? null,
                        'region' => $data['region'] ?? null,
                        'timezone' => $data['timezone'] ?? null,
                        'latitude' => $data['lat'] ?? null,
                        'longitude' => $data['lon'] ?? null,
                        'isp' => $data['isp'] ?? null,
                    ];
                }
            }
        } catch (\Exception $e) {
            Log::warning('Geo IP lookup failed', ['ip' => $ip, 'error' => $e->getMessage()]);
        }

        return [];
    }

    /**
     * Get the backoff strategy for failed jobs.
     *
     * @return array<int, int>
     */
    public function backoff(): array
    {
        return [5, 30];
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $e): void
    {
        Log::error('LogVisitorVisit failed', [
            'url' => $this->url,
            'error' => $e->getMessage(),
        ]);
    }
}
