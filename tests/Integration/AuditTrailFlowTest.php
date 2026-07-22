<?php

namespace Tests\Integration;

use App\Models\AuditTrail;
use App\Models\News;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AuditTrailFlowTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = $this->createSuperAdmin();
        $this->actingAs($this->admin);
    }

    #[Test]
    public function news_creation_creates_audit_trail(): void
    {
        $this->withoutSecurityMiddleware()
            ->from(route('admin.news.index'))
            ->post(route('admin.news.store'), [
                'title' => 'Audit Test News',
                'content' => 'Testing audit trail',
                'category' => 'Berita',
                'is_published' => false,
            ]);

        $this->assertDatabaseHas('audit_trails', [
            'action' => 'create',
            'model_type' => News::class,
            'user_id' => $this->admin->id,
        ]);
    }

    #[Test]
    public function news_update_creates_audit_trail(): void
    {
        $news = News::factory()->create();

        $this->withoutSecurityMiddleware()
            ->from(route('admin.news.index'))
            ->put(route('admin.news.update', $news), [
                'title' => 'Updated Title',
                'content' => 'Updated content',
                'category' => 'Berita',
                'is_published' => true,
            ]);

        $this->assertDatabaseHas('audit_trails', [
            'action' => 'update',
            'model_type' => News::class,
            'model_id' => $news->id,
            'user_id' => $this->admin->id,
        ]);
    }

    #[Test]
    public function news_deletion_creates_audit_trail(): void
    {
        $news = News::factory()->create();

        $this->withoutSecurityMiddleware()
            ->from(route('admin.news.index'))
            ->delete(route('admin.news.destroy', $news));

        $this->assertDatabaseHas('audit_trails', [
            'action' => 'delete',
            'model_type' => News::class,
            'model_id' => $news->id,
            'user_id' => $this->admin->id,
        ]);
    }

    #[Test]
    public function product_creation_creates_audit_trail(): void
    {
        $this->withoutSecurityMiddleware()
            ->from(route('admin.products.index'))
            ->post(route('admin.products.store'), [
                'name' => 'Audit Test Product',
                'type' => 'simpanan_syariah',
                'is_active' => true,
            ]);

        $this->assertDatabaseHas('audit_trails', [
            'action' => 'create',
            'model_type' => Product::class,
            'user_id' => $this->admin->id,
        ]);
    }

    #[Test]
    public function audit_trail_contains_old_and_new_values_on_update(): void
    {
        $news = News::factory()->create(['title' => 'Original Title']);

        $this->withoutSecurityMiddleware()
            ->from(route('admin.news.index'))
            ->put(route('admin.news.update', $news), [
                'title' => 'Changed Title',
                'content' => $news->content,
                'category' => $news->category,
                'is_published' => true,
            ]);

        $trail = AuditTrail::where('model_type', News::class)
            ->where('model_id', $news->id)
            ->where('action', 'update')
            ->latest()
            ->first();

        $this->assertNotNull($trail);
        $this->assertNotNull($trail->old_values);
        $this->assertNotNull($trail->new_values);
    }

    #[Test]
    public function audit_trail_records_login_events(): void
    {
        $this->post(route('logout'));

        $this->assertDatabaseHas('audit_trails', [
            'action' => 'logout',
            'user_id' => $this->admin->id,
        ]);
    }

    #[Test]
    public function audit_trail_includes_request_metadata(): void
    {
        $news = News::factory()->create();

        $this->withoutSecurityMiddleware()
            ->from(route('admin.news.index'))
            ->delete(route('admin.news.destroy', $news));

        $trail = AuditTrail::where('model_type', News::class)
            ->where('model_id', $news->id)
            ->where('action', 'delete')
            ->latest()
            ->first();

        $this->assertNotNull($trail);
        $this->assertNotNull($trail->ip_address);
        $this->assertNotNull($trail->url);
        $this->assertEquals('DELETE', $trail->method);
    }

    #[Test]
    public function audit_trail_records_who_did_the_action(): void
    {
        $news = News::factory()->create();

        $this->withoutSecurityMiddleware()
            ->delete(route('admin.news.destroy', $news));

        $trail = AuditTrail::where('model_type', News::class)
            ->where('model_id', $news->id)
            ->latest()
            ->first();

        $this->assertEquals($this->admin->id, $trail->user_id);
        $this->assertEquals($this->admin->name, $trail->user_name);
    }
}
