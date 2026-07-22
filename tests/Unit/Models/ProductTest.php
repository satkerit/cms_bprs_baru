<?php

namespace Tests\Unit\Models;

use App\Models\Product;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ProductTest extends TestCase
{
    #[Test]
    public function features_is_cast_as_array(): void
    {
        $product = Product::factory()->create([
            'features' => ['Feature 1', 'Feature 2', 'Feature 3'],
        ]);

        $this->assertIsArray($product->features);
        $this->assertCount(3, $product->features);
        $this->assertEquals(['Feature 1', 'Feature 2', 'Feature 3'], $product->features);
    }

    #[Test]
    public function requirements_is_cast_as_array(): void
    {
        $product = Product::factory()->create([
            'requirements' => ['Requirement 1', 'Requirement 2'],
        ]);

        $this->assertIsArray($product->requirements);
        $this->assertCount(2, $product->requirements);
        $this->assertEquals(['Requirement 1', 'Requirement 2'], $product->requirements);
    }

    #[Test]
    public function benefits_is_cast_as_array(): void
    {
        $product = Product::factory()->create([
            'benefits' => ['Benefit 1', 'Benefit 2', 'Benefit 3'],
        ]);

        $this->assertIsArray($product->benefits);
        $this->assertCount(3, $product->benefits);
        $this->assertEquals(['Benefit 1', 'Benefit 2', 'Benefit 3'], $product->benefits);
    }

    #[Test]
    public function slug_is_generated_from_name(): void
    {
        $product = Product::factory()->create([
            'name' => 'Simpanan Wadiah Berhadiah',
        ]);

        $this->assertEquals('simpanan-wadiah-berhadiah', $product->slug);
    }

    #[Test]
    public function slug_handles_special_characters(): void
    {
        $product = Product::factory()->create([
            'name' => 'Produk & Layanan Syariah',
        ]);

        $this->assertMatchesRegularExpression('/^[a-z0-9-]+$/', $product->slug);
    }

    #[Test]
    public function scope_active_filters_correctly(): void
    {
        Product::factory()->count(3)->create(['is_active' => true]);
        Product::factory()->count(2)->create(['is_active' => false]);

        $activeProducts = Product::active()->get();

        $this->assertCount(3, $activeProducts);
        $activeProducts->each(fn($product) => $this->assertTrue($product->is_active));
    }

    #[Test]
    public function scope_simpanan_syariah_filters_correctly(): void
    {
        Product::factory()->count(2)->create(['type' => 'simpanan_syariah']);
        Product::factory()->count(3)->create(['type' => 'pembiayaan_syariah']);
        Product::factory()->count(1)->create(['type' => 'deposito']);

        $simpananProducts = Product::simpananSyariah()->get();

        $this->assertCount(2, $simpananProducts);
        $simpananProducts->each(fn($product) => $this->assertEquals('simpanan_syariah', $product->type));
    }

    #[Test]
    public function scope_pembiayaan_syariah_filters_correctly(): void
    {
        Product::factory()->count(2)->create(['type' => 'simpanan_syariah']);
        Product::factory()->count(3)->create(['type' => 'pembiayaan_syariah']);
        Product::factory()->count(1)->create(['type' => 'deposito']);

        $pembiayaanProducts = Product::pembiayaanSyariah()->get();

        $this->assertCount(3, $pembiayaanProducts);
        $pembiayaanProducts->each(fn($product) => $this->assertEquals('pembiayaan_syariah', $product->type));
    }

    #[Test]
    public function scope_deposito_filters_correctly(): void
    {
        Product::factory()->count(2)->create(['type' => 'simpanan_syariah']);
        Product::factory()->count(3)->create(['type' => 'pembiayaan_syariah']);
        Product::factory()->count(4)->create(['type' => 'deposito']);

        $depositoProducts = Product::deposito()->get();

        $this->assertCount(4, $depositoProducts);
        $depositoProducts->each(fn($product) => $this->assertEquals('deposito', $product->type));
    }

    #[Test]
    public function get_image_url_returns_default_when_no_image(): void
    {
        $product = Product::factory()->create(['image' => null]);

        $this->assertEquals(asset('images/default-product.png'), $product->getImageUrl());
    }

    #[Test]
    public function get_image_url_returns_storage_url_when_image_exists(): void
    {
        $product = Product::factory()->create(['image' => 'products/test-image.jpg']);

        $this->assertEquals(asset('storage/products/test-image.jpg'), $product->getImageUrl());
    }

    #[Test]
    public function description_is_sanitized_when_set(): void
    {
        $product = new Product();
        $product->description = '<b>Safe</b><script>alert(1)</script>';

        $this->assertStringContainsString('<b>Safe</b>', $product->description);
        $this->assertStringNotContainsString('<script>', $product->description);
    }

    #[Test]
    public function short_description_is_sanitized_when_set(): void
    {
        $product = new Product();
        $product->short_description = '<a href="javascript:alert(1)">Click</a>';

        $this->assertStringNotContainsString('javascript:', $product->short_description);
    }

    #[Test]
    public function cache_is_cleared_on_save(): void
    {
        Product::factory()->create();

        $cached = \Illuminate\Support\Facades\Cache::get('products_home_6');
        $this->assertNull($cached);
    }

    #[Test]
    public function route_key_is_slug(): void
    {
        $product = Product::factory()->create(['name' => 'Test Product Route']);

        $this->assertEquals('test-product-route', $product->getRouteKey());
    }

    #[Test]
    public function inactive_products_are_excluded_from_active_scope(): void
    {
        Product::factory()->active()->count(3)->create();
        Product::factory()->inactive()->count(2)->create();

        $active = Product::active()->get();
        $this->assertCount(3, $active);
    }
}
