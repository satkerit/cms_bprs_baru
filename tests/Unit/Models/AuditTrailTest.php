<?php

namespace Tests\Unit\Models;

use App\Models\AuditTrail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AuditTrailTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function log_creates_audit_entry(): void
    {
        $user = User::factory()->create(['name' => 'Test Admin']);
        $this->actingAs($user);

        $trail = AuditTrail::log('create', 'Created news item', null, null, ['title' => 'Test']);

        $this->assertDatabaseHas('audit_trails', [
            'action' => 'create',
            'description' => 'Created news item',
            'user_id' => $user->id,
            'user_name' => 'Test Admin',
        ]);
        $this->assertEquals(['title' => 'Test'], $trail->new_values);
    }

    #[Test]
    public function log_records_old_and_new_values(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $oldValues = ['title' => 'Old Title'];
        $newValues = ['title' => 'New Title'];

        AuditTrail::log('update', 'Updated news', null, $oldValues, $newValues);

        $this->assertDatabaseHas('audit_trails', [
            'action' => 'update',
        ]);
    }

    #[Test]
    public function log_works_without_authenticated_user(): void
    {
        $trail = AuditTrail::log('system', 'System maintenance');

        $this->assertEquals('System', $trail->user_name);
        $this->assertNull($trail->user_id);
    }

    #[Test]
    public function get_action_badge_returns_correct_css(): void
    {
        $trail = new AuditTrail(['action' => 'create']);
        $this->assertStringContainsString('bg-green', $trail->action_badge);

        $trail = new AuditTrail(['action' => 'update']);
        $this->assertStringContainsString('bg-blue', $trail->action_badge);

        $trail = new AuditTrail(['action' => 'delete']);
        $this->assertStringContainsString('bg-red', $trail->action_badge);

        $trail = new AuditTrail(['action' => 'login']);
        $this->assertStringContainsString('bg-emerald', $trail->action_badge);

        $trail = new AuditTrail(['action' => 'logout']);
        $this->assertStringContainsString('bg-gray', $trail->action_badge);
    }

    #[Test]
    public function old_and_new_values_are_cast_as_array(): void
    {
        $trail = AuditTrail::create([
            'user_id' => null,
            'user_name' => 'System',
            'action' => 'test',
            'description' => 'Test entry',
            'old_values' => ['key' => 'old'],
            'new_values' => ['key' => 'new'],
            'ip_address' => '127.0.0.1',
            'user_agent' => 'PHPUnit',
            'url' => 'http://localhost',
            'method' => 'GET',
        ]);

        $this->assertIsArray($trail->old_values);
        $this->assertIsArray($trail->new_values);
        $this->assertEquals('old', $trail->old_values['key']);
    }

    #[Test]
    public function trail_belongs_to_user(): void
    {
        $user = User::factory()->create();
        $trail = AuditTrail::create([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'action' => 'test',
            'description' => 'Test',
            'ip_address' => '127.0.0.1',
            'user_agent' => 'PHPUnit',
            'url' => 'http://localhost',
            'method' => 'GET',
        ]);

        $this->assertTrue($trail->user()->exists());
        $this->assertEquals($user->id, $trail->user->id);
    }
}
