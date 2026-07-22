<?php

namespace Tests\Unit\Services;

use App\Models\CompanyInfo;
use App\Models\HeroSlide;
use App\Models\News;
use App\Models\Product;
use App\Services\CacheService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CacheServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        CompanyInfo::create([
            'name' => 'Bank Syariah Babel',
            'address' => 'Jl. Sudirman No.1',
            'phone' => '0717-123456',
            'email' => 'info@bank.com',
            'description' => 'Test Description',
        ]);
    }

    #[Test]
    public function get_company_info_returns_company_info(): void
    {
        $info = app(CacheService::class)->getCompanyInfo();

        $this->assertNotNull($info);
        $this->assertEquals('Bank Syariah Babel', $info->name);
    }

    #[Test]
    public function get_company_info_is_cached(): void
    {
        $first = app(CacheService::class)->getCompanyInfo();

        CompanyInfo::first()->update(['name' => 'Changed Name']);
        CompanyInfo::clearCache();

        $second = app(CacheService::class)->getCompanyInfo();
        $this->assertNotNull($second);
    }

    #[Test]
    public function get_hero_slides_returns_limited_active_slides(): void
    {
        HeroSlide::factory()->count(5)->create(['is_active' => true]);
        HeroSlide::factory()->count(2)->create(['is_active' => false]);

        $slides = app(CacheService::class)->getHeroSlides(3);

        $this->assertCount(3, $slides);
    }

    #[Test]
    public function get_home_news_returns_limited_published_news(): void
    {
        News::factory()->count(5)->create([
            'is_published' => true,
            'published_at' => now(),
        ]);
        News::factory()->count(2)->create(['is_published' => false]);

        $news = app(CacheService::class)->getHomeNews(3);

        $this->assertCount(3, $news);
    }

    #[Test]
    public function get_home_products_returns_limited_active_products(): void
    {
        Product::factory()->count(4)->create(['is_active' => true]);
        Product::factory()->count(2)->create(['is_active' => false]);

        $products = app(CacheService::class)->getHomeProducts(3);

        $this->assertCount(3, $products);
    }

    #[Test]
    public function get_products_by_type_filters_correctly(): void
    {
        Product::factory()->count(3)->simpananSyariah()->active()->create();
        Product::factory()->count(2)->pembiayaanSyariah()->active()->create();

        $simpanan = app(CacheService::class)->getProductsByType('simpanan_syariah');
        $pembiayaan = app(CacheService::class)->getProductsByType('pembiayaan_syariah');

        $this->assertCount(3, $simpanan);
        $this->assertCount(2, $pembiayaan);
    }

    #[Test]
    public function clear_all_flushes_multiple_cache_keys(): void
    {
        app(CacheService::class)->getCompanyInfo();
        app(CacheService::class)->getHomeNews(3);

        app(CacheService::class)->clearAll();

        $this->assertNotNull(app(CacheService::class)->getCompanyInfo());
    }

    #[Test]
    public function clear_news_cache_forgets_news_home_key(): void
    {
        app(CacheService::class)->getHomeNews(3);
        app(CacheService::class)->clearNewsCache();

        $this->assertNotNull(app(CacheService::class)->getHomeNews(3));
    }
}
