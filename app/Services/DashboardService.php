<?php

namespace App\Services;

use App\Models\Auction;
use App\Models\Complaint;
use App\Models\News;
use App\Models\Product;
use App\Models\VisitorLog;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    private const CACHE_TTL = 300; // 5 minutes

    /**
     * Get all dashboard data in one call.
     *
     * @return array<string, mixed>
     */
    public function getDashboardData(): array
    {
        $visitorStats = $this->getVisitorStats();

        $stats = Cache::remember('admin_dashboard_stats', self::CACHE_TTL, function () {
            return [
                'newsCount' => News::count(),
                'productCount' => Product::count(),
                'upcomingAuctions' => Auction::whereIn('status', ['published','registration_open','registration_closed'])->count(),
                'pendingComplaints' => Complaint::where('status', 'pending')->count(),
                'recentNews' => News::latest()->take(5)->get(),
                'recentComplaints' => Complaint::latest()->take(5)->get(),
            ];
        });

        return array_merge(compact('visitorStats'), $stats);
    }

    /**
     * Get visitor statistics for the last 7 days.
     *
     * @return array<string, mixed>
     */
    private function getVisitorStats(): array
    {
        $startDate = now()->subDays(6)->startOfDay();
        $endDate = now()->endOfDay();

        // Daily visits for chart — single query
        $dailyVisits = VisitorLog::whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total'),
                DB::raw('COUNT(DISTINCT ip_address) as unique_visitors')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $labels = [];
        $totalVisits = [];
        $uniqueVisitors = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->locale('id')->isoFormat('ddd');
            $totalVisits[] = $dailyVisits->get($date)?->total ?? 0;
            $uniqueVisitors[] = $dailyVisits->get($date)?->unique_visitors ?? 0;
        }

        // Summary stats — single query for today
        $todayVisits = VisitorLog::whereDate('created_at', today())->count();
        $todayUnique = VisitorLog::whereDate('created_at', today())->distinct('ip_address')->count('ip_address');
        $weekTotal = array_sum($totalVisits);
        $weekUnique = VisitorLog::whereBetween('created_at', [$startDate, $endDate])
            ->distinct('ip_address')
            ->count('ip_address');

        return compact('labels', 'totalVisits', 'uniqueVisitors', 'todayVisits', 'todayUnique', 'weekTotal', 'weekUnique');
    }
}
