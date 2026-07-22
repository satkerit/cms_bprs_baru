<?php

namespace Tests\Unit\Models;

use App\Models\BlockedIp;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BlockedIpTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function is_active_returns_true_for_permanent_block(): void
    {
        $blocked = BlockedIp::create([
            'ip_address' => '192.168.1.100',
            'reason' => 'Testing',
            'is_permanent' => true,
        ]);

        $this->assertTrue($blocked->isActive());
    }

    #[Test]
    public function is_active_returns_true_for_future_expiry(): void
    {
        $blocked = BlockedIp::create([
            'ip_address' => '192.168.1.100',
            'reason' => 'Testing',
            'blocked_until' => now()->addHours(24),
            'is_permanent' => false,
        ]);

        $this->assertTrue($blocked->isActive());
    }

    #[Test]
    public function is_active_returns_false_for_expired_block(): void
    {
        $blocked = BlockedIp::create([
            'ip_address' => '192.168.1.100',
            'reason' => 'Testing',
            'blocked_until' => now()->subHour(),
            'is_permanent' => false,
        ]);

        $this->assertFalse($blocked->isActive());
    }

    #[Test]
    public function is_expired_returns_false_for_permanent(): void
    {
        $blocked = BlockedIp::create([
            'ip_address' => '192.168.1.100',
            'is_permanent' => true,
        ]);

        $this->assertFalse($blocked->isExpired());
    }

    #[Test]
    public function is_expired_returns_true_for_past_date(): void
    {
        $blocked = BlockedIp::create([
            'ip_address' => '192.168.1.100',
            'blocked_until' => now()->subDay(),
            'is_permanent' => false,
        ]);

        $this->assertTrue($blocked->isExpired());
    }

    #[Test]
    public function scope_active_filters_correctly(): void
    {
        BlockedIp::create(['ip_address' => '1.1.1.1', 'is_permanent' => true]);
        BlockedIp::create(['ip_address' => '2.2.2.2', 'blocked_until' => now()->addDay(), 'is_permanent' => false]);
        BlockedIp::create(['ip_address' => '3.3.3.3', 'blocked_until' => now()->subDay(), 'is_permanent' => false]);

        $active = BlockedIp::active()->get();
        $this->assertCount(2, $active);
    }

    #[Test]
    public function scope_expired_filters_correctly(): void
    {
        BlockedIp::create(['ip_address' => '1.1.1.1', 'blocked_until' => now()->subDay(), 'is_permanent' => false]);
        BlockedIp::create(['ip_address' => '2.2.2.2', 'is_permanent' => true]);

        $expired = BlockedIp::expired()->get();
        $this->assertCount(1, $expired);
    }

    #[Test]
    public function is_blocked_returns_true_for_blocked_ip(): void
    {
        BlockedIp::create([
            'ip_address' => '192.168.1.50',
            'reason' => 'Test block',
            'blocked_until' => now()->addDay(),
            'is_permanent' => false,
        ]);

        $this->assertTrue(BlockedIp::isBlocked('192.168.1.50'));
    }

    #[Test]
    public function is_blocked_returns_false_for_unblocked_ip(): void
    {
        $this->assertFalse(BlockedIp::isBlocked('10.0.0.1'));
    }

    #[Test]
    public function block_ip_creates_or_updates_record(): void
    {
        $blocked = BlockedIp::create([
            'ip_address' => '10.0.0.1',
            'reason' => 'Multiple violations',
            'blocked_until' => now()->addHours(48),
            'is_permanent' => false,
        ]);

        $this->assertDatabaseHas('blocked_ips', [
            'ip_address' => '10.0.0.1',
            'reason' => 'Multiple violations',
        ]);
        $this->assertFalse($blocked->is_permanent);
        $this->assertTrue($blocked->blocked_until->gt(now()));
    }

    #[Test]
    public function block_ip_with_permanent_flag(): void
    {
        $blocked = BlockedIp::create([
            'ip_address' => '10.0.0.2',
            'reason' => 'Permanent ban',
            'is_permanent' => true,
        ]);

        $this->assertTrue($blocked->is_permanent);
        $this->assertNull($blocked->blocked_until);
    }

    #[Test]
    public function unblock_ip_removes_record_and_cache(): void
    {
        BlockedIp::create([
            'ip_address' => '10.0.0.3',
            'reason' => 'Test block',
            'blocked_until' => now()->addDay(),
            'is_permanent' => false,
        ]);

        $this->assertTrue(BlockedIp::isBlocked('10.0.0.3'));

        $result = BlockedIp::unblockIp('10.0.0.3');

        $this->assertTrue((bool) $result);
        $this->assertFalse(BlockedIp::isBlocked('10.0.0.3'));
    }

    #[Test]
    public function increment_attempts_increments_on_existing(): void
    {
        BlockedIp::create([
            'ip_address' => '10.0.0.5',
            'attempts' => 3,
        ]);

        $count = BlockedIp::incrementAttempts('10.0.0.5');
        $this->assertEquals(4, $count);
    }

    #[Test]
    public function increment_attempts_creates_if_not_exists(): void
    {
        $count = BlockedIp::incrementAttempts('10.0.0.6');
        $this->assertEquals(1, $count);
    }

    #[Test]
    public function is_blocked_uses_cache(): void
    {
        BlockedIp::create([
            'ip_address' => '10.0.0.7',
            'reason' => 'Cache test',
            'blocked_until' => now()->addDay(),
            'is_permanent' => false,
        ]);

        $this->assertTrue(BlockedIp::isBlocked('10.0.0.7'));

        BlockedIp::unblockIp('10.0.0.7');
        $this->assertFalse(BlockedIp::isBlocked('10.0.0.7'));
    }
}
