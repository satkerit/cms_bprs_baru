<?php

namespace Tests\Unit\Models;

use App\Enums\AuctionStatus;
use App\Models\Auction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AuctionTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function slug_is_generated_from_title(): void
    {
        $auction = Auction::factory()->create([
            'title' => 'Lelang Tanah Strategis Pangkalpinang',
        ]);

        $this->assertEquals('lelang-tanah-strategis-pangkalpinang', $auction->slug);
    }

    #[Test]
    public function status_label_returns_correct_mapping(): void
    {
        $auction = Auction::factory()->create(['status' => 'published']);
        $this->assertEquals(AuctionStatus::Published->label(), $auction->status_label);
    }

    #[Test]
    public function asset_type_label_returns_correct_mapping(): void
    {
        $auction = Auction::factory()->create(['asset_type' => 'tanah']);
        $this->assertEquals('Tanah', $auction->asset_type_label);
    }

    #[Test]
    public function formatted_limit_price_formats_correctly(): void
    {
        $auction = Auction::factory()->create(['limit_price' => 500000000]);
        $this->assertEquals('Rp 500.000.000', $auction->formatted_limit_price);
    }

    #[Test]
    public function formatted_limit_price_returns_contact_us_when_null(): void
    {
        $auction = Auction::factory()->create(['limit_price' => null]);
        $this->assertEquals('Hubungi Kami', $auction->formatted_limit_price);
    }

    #[Test]
    public function scope_published_filters_correctly(): void
    {
        Auction::factory()->count(3)->create(['status' => 'published', 'published_at' => now()]);
        Auction::factory()->count(2)->create(['status' => 'draft']);

        $published = Auction::published()->get();
        $this->assertCount(3, $published);
    }

    #[Test]
    public function scope_active_filters_all_active_statuses(): void
    {
        Auction::factory()->count(1)->create(['status' => 'published']);
        Auction::factory()->count(1)->create(['status' => 'registration_open']);
        Auction::factory()->count(1)->create(['status' => 'auction_scheduled']);
        Auction::factory()->count(2)->create(['status' => 'draft']);
        Auction::factory()->count(1)->create(['status' => 'sold']);

        $active = Auction::active()->get();
        $this->assertCount(3, $active);
    }

    #[Test]
    public function scope_featured_filters_featured_not_expired(): void
    {
        Auction::factory()->create(['is_featured' => true, 'featured_until' => now()->addDays(10)]);
        Auction::factory()->create(['is_featured' => true, 'featured_until' => now()->subDays(1)]);
        Auction::factory()->create(['is_featured' => false]);

        $featured = Auction::featured()->get();
        $this->assertCount(1, $featured);
    }

    #[Test]
    public function mark_as_sold_updates_status_and_records_winning_bid(): void
    {
        $auction = Auction::factory()->create(['status' => 'published']);
        $winningBid = 600000000;

        $auction->markAsSold($winningBid, 'John Doe');

        $auction->refresh();
        $this->assertEquals('sold', $auction->status);
        $this->assertEquals($winningBid, $auction->winning_bid);
        $this->assertEquals('John Doe', $auction->winner_name);
        $this->assertNotNull($auction->sold_at);
    }

    #[Test]
    public function mark_as_unsold_updates_status(): void
    {
        $auction = Auction::factory()->create(['status' => 'published']);

        $auction->markAsUnsold('No qualified bidders');

        $auction->refresh();
        $this->assertEquals('unsold', $auction->status);
    }

    #[Test]
    public function cancel_updates_status_with_reason(): void
    {
        $auction = Auction::factory()->create(['status' => 'published']);

        $auction->cancel('Legal issues');

        $auction->refresh();
        $this->assertEquals('cancelled', $auction->status);
    }

    #[Test]
    public function postpone_changes_date_and_status(): void
    {
        $auction = Auction::factory()->create([
            'status' => 'auction_scheduled',
            'auction_date' => now()->addDays(5),
        ]);
        $newDate = now()->addDays(30);

        $auction->postpone($newDate, 'Schedule conflict');

        $auction->refresh();
        $this->assertEquals('postponed', $auction->status);
        $this->assertEquals($newDate->toDateTimeString(), $auction->auction_date->toDateTimeString());
    }

    #[Test]
    public function increment_view_count_increases_counter(): void
    {
        $auction = Auction::factory()->create(['view_count' => 10]);

        $auction->incrementViewCount();

        $this->assertEquals(11, $auction->fresh()->view_count);
    }

    #[Test]
    public function is_registration_open_returns_true_within_window(): void
    {
        $auction = Auction::factory()->create([
            'registration_start' => now()->subDay(),
            'registration_end' => now()->addDay(),
        ]);

        $this->assertTrue($auction->is_registration_open);
    }

    #[Test]
    public function is_registration_open_returns_false_outside_window(): void
    {
        $auction = Auction::factory()->create([
            'registration_start' => now()->subDays(10),
            'registration_end' => now()->subDays(5),
        ]);

        $this->assertFalse($auction->is_registration_open);
    }

    #[Test]
    public function full_address_concatenates_correctly(): void
    {
        $auction = Auction::factory()->create([
            'address' => 'Jl. Merdeka No. 10',
            'village' => 'Gabek',
            'district' => 'Pangkalpinang Barat',
            'city' => 'Pangkalpinang',
            'province' => 'Kepulauan Bangka Belitung',
        ]);

        $this->assertStringContainsString('Jl. Merdeka', $auction->full_address);
        $this->assertStringContainsString('Pangkalpinang', $auction->full_address);
    }

    #[Test]
    #[DataProvider('statusColorProvider')]
    public function status_color_returns_correct_styles(string $status): void
    {
        $auction = Auction::factory()->create(['status' => $status]);
        $color = $auction->status_color;

        $this->assertArrayHasKey('bg', $color);
        $this->assertArrayHasKey('text', $color);
        $this->assertArrayHasKey('dot', $color);
    }

    public static function statusColorProvider(): array
    {
        return array_map(fn($case) => [$case->value], AuctionStatus::cases());
    }

    #[Test]
    public function calculated_deposit_returns_deposit_amount_when_set(): void
    {
        $auction = Auction::factory()->create([
            'deposit_amount' => 50000000,
            'deposit_percentage' => 10,
        ]);

        $this->assertEquals(50000000, $auction->calculated_deposit);
    }

    #[Test]
    public function calculated_deposit_falls_back_to_percentage(): void
    {
        $auction = Auction::factory()->create([
            'deposit_amount' => null,
            'deposit_percentage' => 10,
            'limit_price' => 500000000,
        ]);

        $expected = 500000000 * 0.1;
        $this->assertEquals($expected, $auction->calculated_deposit);
    }

    #[Test]
    public function set_description_attribute_sanitizes_html(): void
    {
        $auction = new Auction();
        $auction->description = '<p>Safe content</p><script>alert(1)</script>';

        $this->assertStringContainsString('<p>Safe content</p>', $auction->description);
        $this->assertStringNotContainsString('<script>', $auction->description);
    }

    #[Test]
    public function set_terms_conditions_attribute_sanitizes_html(): void
    {
        $auction = new Auction();
        $auction->terms_conditions = '<b>Valid</b><img onerror=alert(1) src=x>';

        $this->assertStringContainsString('<b>Valid</b>', $auction->terms_conditions);
        $this->assertStringNotContainsString('onerror', $auction->terms_conditions);
    }
}
