<?php

namespace Tests;

use App\Http\Middleware\AdminDdosProtection;
use App\Http\Middleware\BlockSuspiciousRequests;
use App\Http\Middleware\CacheStaticAssets;
use App\Http\Middleware\CheckMaintenanceMode;
use App\Http\Middleware\DdosProtection;
use App\Http\Middleware\DetectSuspiciousActivity;
use App\Http\Middleware\IdleTimeoutMiddleware;
use App\Http\Middleware\LogVisitor;
use App\Http\Middleware\OptimizeFileUpload;
use App\Http\Middleware\OptimizeResponse;
use App\Http\Middleware\SecureSessionMiddleware;
use App\Http\Middleware\SecurityHeaders;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\AdminMenuSeeder;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    protected function withoutSecurityMiddleware(): static
    {
        return $this->withoutMiddleware([
            OptimizeFileUpload::class,
            CacheStaticAssets::class,
            DdosProtection::class,
            SecurityThreatDetection::class,
            CheckMaintenanceMode::class,
            SecureSessionMiddleware::class,
            IdleTimeoutMiddleware::class,
            LogVisitor::class,
            OptimizeResponse::class,
            SecurityHeaders::class,
            AdminDdosProtection::class,
        ]);
    }

    protected function createSuperAdmin(array $attributes = []): User
    {
        return $this->createUserForRole(User::ROLE_SUPER_ADMIN, $attributes);
    }

    protected function createAdmin(array $attributes = []): User
    {
        return $this->createUserForRole(User::ROLE_ADMIN, $attributes);
    }

    protected function createEditor(array $attributes = []): User
    {
        return $this->createUserForRole(User::ROLE_EDITOR, $attributes);
    }

    protected function createUserForRole(string $roleName, array $attributes = []): User
    {
        $this->seedAuthorizationData();

        $role = Role::query()->where('name', $roleName)->firstOrFail();

        return User::factory()->create(array_merge([
            'role_id' => $role->id,
            'is_active' => true,
        ], $attributes));
    }

    protected function seedAuthorizationData(): void
    {
        if (!Role::query()->exists()) {
            $this->seed(RolePermissionSeeder::class);
        }

        if (!\App\Models\AdminMenu::query()->exists()) {
            $this->seed(AdminMenuSeeder::class);
        }
    }
}
