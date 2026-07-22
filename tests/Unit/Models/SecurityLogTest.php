<?php

namespace Tests\Unit\Models;

use App\Models\SecurityLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SecurityLogTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function log_threat_creates_entry_with_default_level(): void
    {
        $log = SecurityLog::logThreat(
            '192.168.1.1',
            'sql_injection',
            'http://example.com/?id=1',
            '/union.*select/i',
            "1' OR '1'='1",
        );

        $this->assertDatabaseHas('security_logs', [
            'ip_address' => '192.168.1.1',
            'threat_type' => 'sql_injection',
            'threat_level' => 'critical',
        ]);
        $this->assertEquals('/union.*select/i', $log->matched_pattern);
    }

    #[Test]
    public function log_threat_accepts_custom_level(): void
    {
        $log = SecurityLog::logThreat(
            '192.168.1.1',
            'suspicious_agent',
            'http://example.com/',
            null,
            null,
            'low',
        );

        $this->assertEquals('low', $log->threat_level);
    }

    #[Test]
    public function log_threat_records_was_blocked_flag(): void
    {
        $log = SecurityLog::logThreat(
            '192.168.1.1',
            'brute_force',
            'http://example.com/login',
            null,
            null,
            'medium',
            true,
        );

        $this->assertTrue($log->was_blocked);
    }

    #[Test]
    public function sanitize_payload_redacts_sensitive_keys(): void
    {
        $payload = [
            'email' => 'test@example.com',
            'password' => 'secret123',
            'password_confirmation' => 'secret123',
            '_token' => 'abc123',
            'name' => 'John Doe',
        ];

        $reflection = new \ReflectionMethod(SecurityLog::class, 'sanitizePayload');
        $reflection->setAccessible(true);

        $result = $reflection->invoke(null, $payload);

        $this->assertEquals('[REDACTED]', $result['password']);
        $this->assertEquals('[REDACTED]', $result['password_confirmation']);
        $this->assertEquals('[REDACTED]', $result['_token']);
        $this->assertEquals('test@example.com', $result['email']);
        $this->assertEquals('John Doe', $result['name']);
    }

    #[Test]
    public function get_threat_badge_class_returns_correct_css(): void
    {
        $log = new SecurityLog(['threat_level' => 'critical']);
        $this->assertStringContainsString('bg-red-100', $log->getThreatBadgeClass());

        $log = new SecurityLog(['threat_level' => 'high']);
        $this->assertStringContainsString('bg-orange-100', $log->getThreatBadgeClass());

        $log = new SecurityLog(['threat_level' => 'medium']);
        $this->assertStringContainsString('bg-yellow-100', $log->getThreatBadgeClass());

        $log = new SecurityLog(['threat_level' => 'low']);
        $this->assertStringContainsString('bg-blue-100', $log->getThreatBadgeClass());
    }

    #[Test]
    public function get_threat_info_returns_known_type(): void
    {
        $log = new SecurityLog(['threat_type' => 'xss']);
        $info = $log->getThreatInfo();

        $this->assertEquals('Cross-Site Scripting (XSS)', $info['label']);
        $this->assertEquals('high', $info['level']);
    }

    #[Test]
    public function get_threat_info_returns_unknown_for_unknown_type(): void
    {
        $log = new SecurityLog(['threat_type' => 'unknown_type']);
        $info = $log->getThreatInfo();

        $this->assertEquals('Unknown Threat', $info['label']);
    }

    #[Test]
    public function get_recent_threats_by_ip_returns_count(): void
    {
        SecurityLog::unguard();
        for ($i = 0; $i < 3; $i++) {
            SecurityLog::create([
                'ip_address' => '10.0.0.1',
                'threat_type' => 'sql_injection',
                'threat_level' => 'medium',
                'request_url' => 'http://test.com/',
                'request_method' => 'GET',
                'created_at' => now()->subMinutes(30),
            ]);
        }
        SecurityLog::reguard();

        $count = SecurityLog::getRecentThreatsByIp('10.0.0.1', 60);
        $this->assertEquals(3, $count);
    }

    #[Test]
    public function get_recent_threats_by_ip_excludes_older_entries(): void
    {
        SecurityLog::unguard();
        for ($i = 0; $i < 2; $i++) {
            SecurityLog::create([
                'ip_address' => '10.0.0.1',
                'threat_type' => 'sql_injection',
                'threat_level' => 'medium',
                'request_url' => 'http://test.com/',
                'request_method' => 'GET',
                'created_at' => now()->subHours(2),
            ]);
        }
        SecurityLog::reguard();

        $count = SecurityLog::getRecentThreatsByIp('10.0.0.1', 60);
        $this->assertEquals(0, $count);
    }

    #[Test]
    public function cleanup_deletes_old_logs(): void
    {
        SecurityLog::unguard();
        for ($i = 0; $i < 3; $i++) {
            SecurityLog::create([
                'ip_address' => '10.0.0.1',
                'threat_type' => 'scanner',
                'threat_level' => 'low',
                'request_url' => 'http://test.com/',
                'request_method' => 'GET',
                'created_at' => now()->subDays(60),
            ]);
        }
        for ($i = 0; $i < 2; $i++) {
            SecurityLog::create([
                'ip_address' => '10.0.0.2',
                'threat_type' => 'scanner',
                'threat_level' => 'low',
                'request_url' => 'http://test.com/',
                'request_method' => 'GET',
                'created_at' => now()->subDays(10),
            ]);
        }
        SecurityLog::reguard();

        $deleted = SecurityLog::cleanup(30);

        $this->assertEquals(3, $deleted);
        $this->assertEquals(2, SecurityLog::count());
    }
}
