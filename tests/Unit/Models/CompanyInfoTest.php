<?php

namespace Tests\Unit\Models;

use App\Models\CompanyInfo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class CompanyInfoTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function get_info_returns_cached_instance(): void
    {
        CompanyInfo::create([
            'name' => 'Test Bank',
            'address' => 'Test Address',
            'phone' => '123456',
            'email' => 'test@bank.com',
            'description' => 'Test description',
        ]);

        $info = CompanyInfo::getInfo();
        $this->assertNotNull($info);
        $this->assertEquals('Test Bank', $info->name);
    }

    #[Test]
    public function clear_cache_forgets_cached_instance(): void
    {
        CompanyInfo::create([
            'name' => 'Test Bank',
            'address' => 'Test Address',
            'phone' => '123456',
            'email' => 'test@bank.com',
            'description' => 'Test description',
        ]);

        $before = CompanyInfo::getInfo();
        $this->assertNotNull($before);

        CompanyInfo::clearCache();

        $after = CompanyInfo::getInfo();
        $this->assertNotNull($after);
    }

    #[Test]
    public function cache_is_cleared_on_save(): void
    {
        $info = CompanyInfo::create([
            'name' => 'Original Name',
            'address' => 'Address',
            'phone' => '123456',
            'email' => 'test@bank.com',
            'description' => 'Desc',
        ]);

        $info->update(['name' => 'Updated Name']);

        $this->assertEquals('Updated Name', CompanyInfo::getInfo()->name);
    }

    #[Test]
    public function social_media_links_returns_array_with_all_platforms(): void
    {
        $info = CompanyInfo::create([
            'name' => 'Test',
            'address' => 'Addr',
            'phone' => '123',
            'email' => 'a@b.com',
            'description' => 'Desc',
            'facebook' => 'https://facebook.com/test',
            'instagram' => 'https://instagram.com/test',
            'twitter' => 'https://twitter.com/test',
            'youtube' => null,
        ]);

        $links = $info->socialMediaLinks;
        $this->assertIsArray($links);
        $this->assertCount(6, $links);
        $this->assertEquals('https://facebook.com/test', $links['facebook']);
        $this->assertNull($links['youtube']);
    }

    #[Test]
    public function statistics_returns_array_of_stats(): void
    {
        $info = CompanyInfo::create([
            'name' => 'Test',
            'address' => 'Addr',
            'phone' => '123',
            'email' => 'a@b.com',
            'description' => 'Desc',
            'stat_years_experience' => 10,
            'stat_branch_offices' => 5,
        ]);

        $stats = $info->statistics;
        $this->assertIsArray($stats);
        $this->assertEquals(10, $stats['years_experience']);
        $this->assertEquals(5, $stats['branch_offices']);
    }

    #[Test]
    public function has_complete_profile_checks_required_fields(): void
    {
        $complete = CompanyInfo::create([
            'name' => 'Bank Syariah Babel',
            'address' => 'Jl. Sudirman No.1',
            'phone' => '0717-123456',
            'email' => 'info@bank.com',
            'description' => 'Full description',
        ]);

        $this->assertTrue($complete->hasCompleteProfile);

        $incomplete = CompanyInfo::create([
            'name' => '',
            'address' => '',
            'phone' => '',
            'email' => '',
            'description' => '',
        ]);

        $this->assertFalse($incomplete->hasCompleteProfile);
    }

    #[Test]
    public function operational_hours_is_cast_as_array(): void
    {
        $hours = [
            'senin' => '08:00-16:00',
            'selasa' => '08:00-16:00',
        ];

        $info = CompanyInfo::create([
            'name' => 'Test',
            'address' => 'Addr',
            'phone' => '123',
            'email' => 'a@b.com',
            'description' => 'Desc',
            'operational_hours' => $hours,
        ]);

        $this->assertIsArray($info->operational_hours);
        $this->assertEquals('08:00-16:00', $info->operational_hours['senin']);
    }
}
