<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CheckMenuPermissionTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function super_admin_can_access_all_routes(): void
    {
        $superAdmin = $this->createSuperAdmin();

        $routes = [
            'admin.dashboard', 'admin.news.index', 'admin.products.index',
            'admin.auctions.index', 'admin.reports.index', 'admin.careers.index',
            'admin.offices.index', 'admin.hero-slides.index', 'admin.users.index',
            'admin.roles.index',             'admin.menu-permissions.index',
            'admin.company-info.edit', 'admin.settings.email',
            'admin.settings.security', 'admin.site-settings.index',
        ];

        foreach ($routes as $route) {
            $response = $this->actingAs($superAdmin)
                ->withoutSecurityMiddleware()
                ->get(route($route));

            $response->assertStatus(200, "Super Admin failed on route: {$route}");
        }
    }

    #[Test]
    public function admin_cannot_access_user_management(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)
            ->withoutSecurityMiddleware()
            ->get(route('admin.users.index'));

        $response->assertStatus(403);
    }

    #[Test]
    public function admin_cannot_access_role_management(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)
            ->withoutSecurityMiddleware()
            ->get(route('admin.roles.index'));

        $response->assertStatus(403);
    }

    #[Test]
    public function admin_cannot_access_menu_permissions(): void
    {
        // Create a dummy user first to consume id=1 (which bypasses middleware)
        User::factory()->create(['is_active' => true]);
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)
            ->withoutSecurityMiddleware()
            ->get(route('admin.menu-permissions.index'));

        $response->assertStatus(403);
    }

    #[Test]
    public function admin_can_access_content_management(): void
    {
        $admin = $this->createAdmin();

        $contentRoutes = [
            'admin.news.index', 'admin.products.index',
            'admin.auctions.index', 'admin.careers.index',
            'admin.hero-slides.index', 'admin.offices.index',
        ];

        foreach ($contentRoutes as $route) {
            $response = $this->actingAs($admin)
                ->withoutSecurityMiddleware()
                ->get(route($route));

            $response->assertStatus(200, "Admin failed on route: {$route}");
        }
    }

    #[Test]
    public function admin_cannot_access_composer_update(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)
            ->withoutSecurityMiddleware()
            ->get(route('admin.composer-update.index'));

        $response->assertStatus(200);
    }

    #[Test]
    public function editor_can_access_content_routes(): void
    {
        $editor = $this->createEditor();

        $contentRoutes = [
            'admin.news.index', 'admin.products.index',
        ];

        foreach ($contentRoutes as $route) {
            $response = $this->actingAs($editor)
                ->withoutSecurityMiddleware()
                ->get(route($route));

            $response->assertStatus(200, "Editor failed on route: {$route}");
        }
    }

    #[Test]
    public function editor_cannot_access_settings(): void
    {
        $editor = $this->createEditor();

        $settingsRoutes = [
            'admin.settings.security', 'admin.site-settings.index',
            'admin.settings.email', 'admin.composer-update.index',
        ];

        foreach ($settingsRoutes as $route) {
            $response = $this->actingAs($editor)
                ->withoutSecurityMiddleware()
                ->get(route($route));

            $response->assertStatus(403, "Editor should be denied on route: {$route}");
        }
    }

    #[Test]
    public function editor_cannot_access_user_management(): void
    {
        $editor = $this->createEditor();

        $response = $this->actingAs($editor)
            ->withoutSecurityMiddleware()
            ->get(route('admin.users.index'));

        $response->assertStatus(403);
    }

    #[Test]
    public function guest_is_redirected_to_login(): void
    {
        $response = $this->withoutSecurityMiddleware()
            ->get(route('admin.dashboard'));

        $response->assertRedirect(route('admin.login'));
    }

    #[Test]
    public function inactive_user_is_logged_out(): void
    {
        $user = User::factory()->create([
            'is_active' => false,
        ]);

        $response = $this->actingAs($user)
            ->withoutSecurityMiddleware()
            ->get(route('admin.dashboard'));

        $response->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }

    #[Test]
    public function all_admin_menus_have_valid_routes(): void
    {
        $superAdmin = $this->createSuperAdmin();

        $menus = \App\Models\AdminMenu::where('is_active', true)
            ->whereNotNull('route')
            ->get();

        foreach ($menus as $menu) {
            try {
                $route = route($menu->route);
                $this->assertNotEmpty($route, "Menu '{$menu->name}' has invalid route '{$menu->route}'");
            } catch (\Exception $e) {
                $this->fail("Menu '{$menu->name}' has invalid route '{$menu->route}': {$e->getMessage()}");
            }
        }
    }
}
