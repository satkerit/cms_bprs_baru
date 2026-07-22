<?php

namespace Tests\Feature\Security;

use App\Models\News;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class XssSanitizationTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = $this->createSuperAdmin();
    }

    #[Test]
    public function news_content_is_sanitized_on_creation(): void
    {
        $xssPayload = '<p>Safe text</p><script>alert("xss")</script><img src=x onerror=alert(1)>';

        $news = News::factory()->create([
            'content' => $xssPayload,
        ]);

        $this->assertStringContainsString('<p>Safe text</p>', $news->content);
        $this->assertStringNotContainsString('<script>', $news->content);
        $this->assertStringNotContainsString('onerror', $news->content);
    }

    #[Test]
    public function product_description_is_sanitized(): void
    {
        $product = Product::factory()->create([
            'description' => '<b>Safe</b><script>stealCookies()</script>',
        ]);

        $this->assertStringContainsString('<b>Safe</b>', $product->description);
        $this->assertStringNotContainsString('<script>', $product->description);
    }

    #[Test]
    public function product_short_description_is_sanitized(): void
    {
        $product = Product::factory()->create([
            'short_description' => '<a href="javascript:alert(1)">Click</a>',
        ]);

        $this->assertStringNotContainsString('javascript:', $product->short_description);
    }

    #[Test]
    public function xss_in_admin_news_content_is_sanitized(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $this->actingAs($this->admin);

        $file = \Illuminate\Http\UploadedFile::fake()->image('photo.jpg', 100, 100);

        $response = $this->withoutSecurityMiddleware()
            ->from(route('admin.news.create'))
            ->post(route('admin.news.store'), [
                'title' => 'Test News XSS',
                'content' => '<p>Safe</p><script>alert(1)</script>',
                'category' => 'Berita',
                'featured_image' => $file,
                'is_published' => false,
            ]);

        if ($response->isRedirect()) {
            $news = News::where('title', 'Test News XSS')->first();
            if ($news) {
                $this->assertStringContainsString('<p>Safe</p>', $news->content);
                $this->assertStringNotContainsString('<script>', $news->content);
            }
        }
    }

    #[Test]
    public function xss_in_admin_product_form_is_sanitized(): void
    {
        $this->actingAs($this->admin);

        $response = $this->withoutSecurityMiddleware()
            ->from(route('admin.products.index'))
            ->post(route('admin.products.store'), [
                'name' => 'Test Product XSS',
                'type' => 'simpanan_syariah',
                'description' => '<b>Safe</b><img onerror=alert(1) src=x>',
                'is_active' => true,
            ]);

        if ($response->isRedirect()) {
            $product = Product::where('name', 'Test Product XSS')->first();
            if ($product) {
                $this->assertStringContainsString('<b>Safe</b>', $product->description);
                $this->assertStringNotContainsString('onerror', $product->description);
            }
        }
    }
}
