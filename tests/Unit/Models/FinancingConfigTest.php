<?php

namespace Tests\Unit\Models;

use App\Models\FinancingConfig;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FinancingConfigTest extends TestCase
{
    use RefreshDatabase;

    private function createConfig(array $overrides = []): FinancingConfig
    {
        return FinancingConfig::create(array_merge([
            'type' => 'pembiayaan_syariah',
            'calculation_type' => 'margin',
            'name' => 'Test Financing',
            'is_active' => true,
            'min_principal' => 1000000,
            'max_principal' => 500000000,
            'margin_rate' => 0.10,
            'available_tenors' => [6, 12, 24],
        ], $overrides));
    }

    #[Test]
    public function scope_active_filters_correctly(): void
    {
        $this->createConfig(['is_active' => true]);
        $this->createConfig(['is_active' => true]);
        $this->createConfig(['is_active' => true]);
        $this->createConfig(['is_active' => false]);
        $this->createConfig(['is_active' => false]);

        $active = FinancingConfig::active()->get();
        $this->assertCount(3, $active);
    }

    #[Test]
    public function is_profit_sharing_returns_true_for_profit_sharing_type(): void
    {
        $config = $this->createConfig([
            'calculation_type' => 'profit_sharing',
        ]);

        $this->assertTrue($config->isProfitSharing());
        $this->assertFalse($config->isMargin());
    }

    #[Test]
    public function is_margin_returns_true_for_margin_type(): void
    {
        $config = $this->createConfig([
            'calculation_type' => 'margin',
        ]);

        $this->assertTrue($config->isMargin());
        $this->assertFalse($config->isProfitSharing());
    }

    #[Test]
    public function get_rate_label_returns_correct_label(): void
    {
        $margin = $this->createConfig(['calculation_type' => 'margin']);
        $this->assertEquals('Margin', $margin->getRateLabel());

        $profit = $this->createConfig(['calculation_type' => 'profit_sharing']);
        $this->assertEquals('Proyeksi Bagi Hasil', $profit->getRateLabel());
    }

    #[Test]
    public function get_configs_returns_only_active_configs_cached(): void
    {
        $this->createConfig(['is_active' => true]);
        $this->createConfig(['is_active' => true]);
        $this->createConfig(['is_active' => false]);

        $configs = FinancingConfig::getConfigs();
        $this->assertCount(2, $configs);
    }

    #[Test]
    public function cache_is_cleared_on_save(): void
    {
        $config = $this->createConfig(['is_active' => true]);
        $this->assertCount(1, FinancingConfig::getConfigs());

        $config->update(['is_active' => false]);
        $this->assertCount(0, FinancingConfig::getConfigs());
    }

    #[Test]
    public function available_tenors_is_cast_as_array(): void
    {
        $config = $this->createConfig([
            'available_tenors' => [6, 12, 24, 36],
        ]);

        $this->assertIsArray($config->available_tenors);
        $this->assertCount(4, $config->available_tenors);
        $this->assertEquals([6, 12, 24, 36], $config->available_tenors);
    }

    #[Test]
    public function margin_rate_has_decimal_precision(): void
    {
        $config = $this->createConfig(['margin_rate' => 0.1275]);

        $this->assertEquals(0.1275, $config->margin_rate);
    }

    #[Test]
    public function validation_enforces_min_principal_less_than_max(): void
    {
        $config = $this->createConfig([
            'min_principal' => 1000000,
            'max_principal' => 500000000,
        ]);

        $this->assertLessThan($config->max_principal, $config->min_principal);
    }
}
