<?php

namespace Tests\Feature\Admin;

use App\Jobs\LogVisitorVisit;
use App\Models\VisitorLog;
use App\Services\DashboardService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DashboardStatisticsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function visitor_log_job_writes_log_without_queue_worker(): void
    {
        // Simulasi job yang di-dispatch via LogVisitor middleware (afterResponse).
        // Tanpa worker, job harus tetap menulis data — ini akar masalah "statistik kosong".
        $job = new LogVisitorVisit(
            ip: '127.0.0.1',
            userAgent: 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) Chrome/120.0',
            url: 'http://localhost/',
            referrer: null,
            sessionId: 'test-session-1',
        );

        $job->handle();

        $this->assertDatabaseCount('visitor_logs', 1);
        $this->assertDatabaseHas('visitor_logs', [
            'ip_address' => '127.0.0.1',
            'url' => 'http://localhost/',
            'device_type' => 'desktop',
            'browser' => 'Chrome',
            'platform' => 'Windows',
        ]);
    }

    #[Test]
    public function duplicate_visit_within_5_minutes_is_deduplicated(): void
    {
        $job = new LogVisitorVisit(
            ip: '127.0.0.1',
            userAgent: 'Mozilla/5.0 Chrome/120.0',
            url: 'http://localhost/berita',
            referrer: null,
            sessionId: 'test-session-2',
        );

        $job->handle();
        $job->handle();

        $this->assertDatabaseCount('visitor_logs', 1);
    }

    #[Test]
    public function dashboard_service_aggregates_visitor_stats(): void
    {
        // Data hari ini
        VisitorLog::create([
            'ip_address' => '127.0.0.1',
            'url' => 'http://localhost/',
            'session_id' => 's1',
            'device_type' => 'desktop',
        ]);

        // Data 3 hari lalu (timestamp di-set setelah create karena bukan fillable)
        $old = VisitorLog::create([
            'ip_address' => '127.0.0.2',
            'url' => 'http://localhost/berita',
            'session_id' => 's2',
            'device_type' => 'mobile',
        ]);
        $old->forceFill([
            'created_at' => now()->subDays(3),
            'updated_at' => now()->subDays(3),
        ])->save();

        $data = app(DashboardService::class)->getDashboardData();

        $this->assertSame(1, $data['visitorStats']['todayVisits']);
        $this->assertSame(2, $data['visitorStats']['weekTotal']);
        $this->assertSame(2, $data['visitorStats']['weekUnique']);
        $this->assertCount(7, $data['visitorStats']['labels']);
        $this->assertCount(7, $data['visitorStats']['totalVisits']);
    }

    #[Test]
    public function dashboard_page_renders_visitor_statistics_section(): void
    {
        $admin = $this->createAdmin();

        VisitorLog::create([
            'ip_address' => '127.0.0.1',
            'url' => 'http://localhost/',
            'session_id' => 's3',
        ]);

        $response = $this->actingAs($admin)
            ->withoutSecurityMiddleware()
            ->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertViewIs('admin.dashboard');
        $response->assertSee('Statistik Pengunjung');
        $response->assertSee('visitorChart');
    }

    #[Test]
    public function dashboard_shows_empty_state_when_no_visitor_data(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)
            ->withoutSecurityMiddleware()
            ->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('Belum ada data kunjungan');
    }
}
