<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RollupVisitorStats extends Command
{
    protected $signature = 'stats:rollup-visitors {--date= : Date to rollup (Y-m-d format, default: yesterday)}';
    protected $description = 'Rollup daily visitor statistics from visitor_logs to visitor_stats_daily (P-05)';

    public function handle()
    {
        $date = $this->option('date') 
            ? Carbon::createFromFormat('Y-m-d', $this->option('date'))
            : Carbon::yesterday();

        $this->info("Rolling up visitor stats for {$date->toDateString()}...");

        try {
            $stats = DB::table('visitor_logs')
                ->whereDate('created_at', $date->toDateString())
                ->select(
                    DB::raw('COUNT(DISTINCT ip) as total_unique_ips'),
                    DB::raw('COUNT(DISTINCT session_id) as total_sessions'),
                    DB::raw('COUNT(*) as total_pageviews'),
                    DB::raw('JSON_OBJECT_AGG(device_type, COUNT(*)) as device_types'),
                    DB::raw('JSON_OBJECT_AGG(browser, COUNT(*)) as browsers')
                )
                ->first();

            // Get top countries and pages
            $topCountries = DB::table('visitor_logs')
                ->whereDate('created_at', $date->toDateString())
                ->selectRaw('country, COUNT(*) as count')
                ->groupBy('country')
                ->orderByDesc('count')
                ->limit(10)
                ->pluck('count', 'country')
                ->toArray();

            $topPages = DB::table('visitor_logs')
                ->whereDate('created_at', $date->toDateString())
                ->selectRaw('page_url, COUNT(*) as count')
                ->groupBy('page_url')
                ->orderByDesc('count')
                ->limit(10)
                ->pluck('count', 'page_url')
                ->toArray();

            // Insert or update rollup
            DB::table('visitor_stats_daily')->updateOrInsert(
                ['stats_date' => $date->toDateString()],
                [
                    'total_unique_ips' => $stats->total_unique_ips ?? 0,
                    'total_sessions' => $stats->total_sessions ?? 0,
                    'total_pageviews' => $stats->total_pageviews ?? 0,
                    'device_types' => json_encode($stats->device_types ?? []),
                    'browsers' => json_encode($stats->browsers ?? []),
                    'top_countries' => json_encode($topCountries),
                    'top_pages' => json_encode($topPages),
                    'updated_at' => now(),
                ]
            );

            $this->info("✓ Rollup completed: {$stats->total_unique_ips} unique IPs, {$stats->total_pageviews} pageviews");
        } catch (\Exception $e) {
            report($e);
            $this->error("Rollup failed: Terjadi kesalahan saat mengagregasi data. Silakan periksa logs.");
        }
    }
}
