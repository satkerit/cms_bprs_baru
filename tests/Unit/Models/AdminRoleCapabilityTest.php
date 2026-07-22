<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdminRoleCapabilityTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function super_admin_has_full_permission_access(): void
    {
        $user = $this->createSuperAdmin();

        $this->assertTrue($user->hasPermission('users.view'));
        $this->assertTrue($user->hasPermission('settings.composer'));
        $this->assertTrue($user->hasAnyPermission(['roles.view', 'settings.security']));
    }

    #[Test]
    public function admin_can_access_operational_settings_but_not_user_management(): void
    {
        $user = $this->createAdmin();

        $this->assertTrue($user->hasPermission('settings.composer'));
        $this->assertTrue($user->hasPermission('settings.email'));
        $this->assertFalse($user->hasPermission('users.view'));
        $this->assertFalse($user->hasPermission('roles.view'));
    }

    #[Test]
    public function editor_can_access_content_but_not_system_settings(): void
    {
        $user = $this->createEditor();

        $this->assertTrue($user->canManageContent());
        $this->assertTrue($user->hasPermission('news.view'));
        $this->assertFalse($user->hasPermission('settings.composer'));
        $this->assertFalse($user->hasPermission('users.view'));
    }
}
