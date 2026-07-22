<?php

namespace Tests\Feature\Security;

use App\Models\BlockedIp;
use App\Models\SecurityLog;
use App\Models\SecuritySetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BlockSuspiciousRequestsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        SecuritySetting::create([
            'enable_suspicious_blocking' => true,
            'block_threshold' => 3,
            'block_duration_hours' => 24,
            'log_security_events' => true,
        ]);
    }

    #[Test]
    public function blocks_suspicious_url_containing_wp_admin(): void
    {
        $response = $this->get('/wp-admin');

        $response->assertStatus(403);
    }

    #[Test]
    public function blocks_suspicious_url_containing_phpmyadmin(): void
    {
        $response = $this->get('/phpmyadmin');

        $response->assertStatus(403);
    }

    #[Test]
    public function blocks_suspicious_url_with_env_access(): void
    {
        $response = $this->get('/.env');

        $response->assertStatus(403);
    }

    #[Test]
    public function blocks_git_folder_access(): void
    {
        $response = $this->get('/.git/config');

        $response->assertStatus(403);
    }

    #[Test]
    public function blocks_htaccess_access(): void
    {
        $response = $this->get('/.htaccess');

        $response->assertStatus(403);
    }

    #[Test]
    public function blocks_xmlrpc_access(): void
    {
        $response = $this->get('/xmlrpc.php');

        $response->assertStatus(403);
    }

    #[Test]
    public function blocked_ip_is_rejected(): void
    {
        BlockedIp::create([
            'ip_address' => '127.0.0.1',
            'reason' => 'Test block',
            'is_permanent' => true,
        ]);

        $response = $this->get('/');
        $response->assertStatus(403);
    }

    #[Test]
    public function temporarily_blocked_ip_is_rejected(): void
    {
        BlockedIp::create([
            'ip_address' => '127.0.0.1',
            'reason' => 'Temp block',
            'blocked_until' => now()->addDay(),
            'is_permanent' => false,
        ]);

        $response = $this->get('/');
        $response->assertStatus(403);
    }

    #[Test]
    public function unblocked_ip_can_access(): void
    {
        BlockedIp::create([
            'ip_address' => '127.0.0.1',
            'reason' => 'Test block',
            'is_permanent' => true,
        ]);

        BlockedIp::unblockIp('127.0.0.1');

        $response = $this->get('/');
        $response->assertStatus(200);
    }

    #[Test]
    public function legitimate_request_does_not_create_security_log(): void
    {
        $this->get('/');

        $this->assertDatabaseCount('security_logs', 0);
    }

    #[Test]
    public function excluded_admin_routes_are_not_blocked(): void
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
    }
}
