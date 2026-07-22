<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AdminRouteRegressionTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function guest_is_redirected_to_admin_login_for_admin_routes(): void
    {
        $response = $this->withoutSecurityMiddleware()
            ->get(route('admin.dashboard'));

        $response->assertRedirect(route('admin.login'));
    }

    #[Test]
    public function inactive_admin_is_redirected_to_admin_login_when_opening_admin_routes(): void
    {
        $admin = $this->createAdmin([
            'is_active' => false,
        ]);

        $response = $this->actingAs($admin)
            ->withoutSecurityMiddleware()
            ->get(route('admin.dashboard'));

        $response->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }

    #[Test]
    public function admin_can_open_composer_update_page(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)
            ->withoutSecurityMiddleware()
            ->get(route('admin.composer-update.index'));

        $response->assertOk();
        $response->assertViewIs('admin.composer-update.index');
        $response->assertSee('Composer Update');
    }

    #[Test]
    public function editor_cannot_open_composer_update_page(): void
    {
        $editor = $this->createEditor();

        $response = $this->actingAs($editor)
            ->withoutSecurityMiddleware()
            ->get(route('admin.composer-update.index'));

        $response->assertForbidden();
    }

    #[Test]
    public function composer_update_requires_explicit_confirmation(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin)
            ->withoutSecurityMiddleware()
            ->from(route('admin.composer-update.index'))
            ->post(route('admin.composer-update.run'), []);

        $response->assertRedirect(route('admin.composer-update.index'));
        $response->assertSessionHasErrors('confirm');
    }
}
