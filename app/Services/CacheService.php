<?php

namespace App\Services;

use App\Models\CompanyInfo;
use App\Models\HeroSlide;
use App\Models\Product;
use App\Models\News;
use App\Models\Auction;
use App\Models\Office;
use App\Models\BoardMember;
use App\Models\Report;
use App\Models\KasKeliling;
use App\Models\WhyChooseUs;
use App\Models\WhyChooseUsSetting;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Spatie\ResponseCache\Facades\ResponseCache;

class CacheService
{
    // Cache durations in seconds
    const CACHE_SHORT = 1800;      // 30 minutes
    const CACHE_MEDIUM = 3600;     // 1 hour
    const CACHE_LONG = 86400;      // 24 hours

    /**
     * Get company info with caching
     */
    public function getCompanyInfo(): ?CompanyInfo
    {
        try {
            if (!class_exists('\App\Models\CompanyInfo')) return null;
            // Clear cache if it might be stale (doesn't have profile_image)
            $cached = Cache::get(Config::get('cache-keys.company_info'));
            if ($cached && $cached instanceof CompanyInfo && !array_key_exists('profile_image', $cached->getAttributes())) {
                Cache::forget(Config::get('cache-keys.company_info'));
            }

            return Cache::remember(Config::get('cache-keys.company_info'), self::CACHE_LONG, fn() => CompanyInfo::first());
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get hero slides for homepage with dynamic limit from settings
     */
    public function getHeroSlidesDynamic()
    {
        try {
            if (!class_exists('\App\Models\SiteSetting')) return $this->getHeroSlides(5);
            // Get limit from site settings, default to 5 if not set
            $limit = SiteSetting::getSettings()->hero_slide_limit ?? 5;

            // Ensure limit is within valid range (1-20)
            $limit = max(1, min(20, $limit));

            return $this->getHeroSlides($limit);
        } catch (\Exception $e) {
            return $this->getHeroSlides(5);
        }
    }

    /**
     * Get hero slides for homepage with specific limit
     */
    public function getHeroSlides(int $limit = 5)
    {
        try {
            return Cache::remember(
                Config::get('cache-keys.hero_slides') . "_{$limit}",
                self::CACHE_MEDIUM,
                function () use ($limit) {
                    if (!class_exists('\App\Models\HeroSlide')) return collect();
                    return HeroSlide::where('is_active', true)
                        ->orderBy('order_position')
                        ->limit($limit)
                        ->get([
                            'id',
                            'title',
                            'subtitle',
                            'image',
                            'link_url',
                            'link_text',
                            'transition_type',
                            'transition_duration',
                            'show_title',
                            'show_subtitle',
                            'show_button'
                        ]);
                }
            );
        } catch (\Exception $e) {
            return collect();
        }
    }

    /**
     * Get products for homepage
     */
    public function getHomeProducts(int $limit = 6)
    {
        try {
            return Cache::remember(
                Config::get('cache-keys.products_home') . "_{$limit}",
                self::CACHE_LONG,
                function () use ($limit) {
                    if (!class_exists('\App\Models\Product')) return collect();
                    return Product::where('is_active', true)
                        ->orderBy('order_position')
                        ->limit($limit)
                        ->get(['id', 'name', 'slug', 'short_description', 'image', 'type']);
                }
            );
        } catch (\Exception $e) {
            return collect();
        }
    }

    /**
     * Get products by type
     */
    public function getProductsByType(string $type)
    {
        return Cache::remember(
            Config::get('cache-keys.products') . "{$type}",
            self::CACHE_MEDIUM,
            fn() =>
            Product::where('type', $type)
                ->where('is_active', true)
                ->orderBy('order_position')
                ->get()
        );
    }

    /**
     * Get latest news for homepage
     */
    public function getHomeNews(int $limit = 3)
    {
        try {
            return Cache::remember(Config::get('cache-keys.news_home') . "_{$limit}", self::CACHE_MEDIUM, function () use ($limit) {
                if (!class_exists('\App\Models\News')) return collect();
                return News::where('is_published', true)
                    ->where('published_at', '<=', now())
                    ->orderBy('published_at', 'desc')
                    ->limit($limit)
                    ->get(['id', 'title', 'slug', 'excerpt', 'featured_image', 'published_at', 'category']);
            });
        } catch (\Exception $e) {
            return collect();
        }
    }

    /**
     * Get active auctions for homepage (only non-sold items)
     */
    public function getHomeAuctions(int $limit = 3)
    {
        try {
            return Cache::remember(
                Config::get('cache-keys.auctions_home') . "_{$limit}",
                self::CACHE_MEDIUM,
                function () use ($limit) {
                    if (!class_exists('\App\Models\Auction')) return collect();
                    try {
                        return Auction::published()
                            ->whereNotIn('status', ['sold', 'cancelled', 'unsold'])
                            ->orderBy('auction_date', 'asc')
                            ->limit($limit)
                            ->get(['id', 'title', 'slug', 'city', 'limit_price', 'auction_date', 'images', 'asset_type', 'status']);
                    } catch (\Exception $e) {
                        \Log::error('Error getting home auctions: ' . $e->getMessage());
                        return collect();
                    }
                }
            );
        } catch (\Exception $e) {
            return collect();
        }
    }

    /**
     * Get active offices
     */
    public function getOffices(?string $type = null)
    {
        $key = $type
            ? Config::get('cache-keys.offices') . "_{$type}"
            : Config::get('cache-keys.offices') . '_all';

        return Cache::remember($key, self::CACHE_MEDIUM, function () use ($type) {
            $query = Office::where('is_active', true);
            if ($type) {
                $query->where('type', $type);
            } else {
                $query->where('type', '!=', 'kas_keliling');
            }
            return $query->orderBy('type')->orderBy('name')->get();
        });
    }

    /**
     * Get board members by type
     */
    public function getBoardMembers(string $type)
    {
        return Cache::remember(
            Config::get('cache-keys.board_members') . "_{$type}",
            self::CACHE_LONG,
            fn() =>
            BoardMember::where('type', $type)
                ->orderBy('order_position')
                ->get()
        );
    }

    /**
     * Get news categories
     */
    public function getNewsCategories()
    {
        return Cache::remember(
            Config::get('cache-keys.news_categories'),
            self::CACHE_MEDIUM,
            fn() => News::where('is_published', true)
                ->whereNotNull('category')
                ->distinct()
                ->pluck('category')
        );
    }

    /**
     * Get report years by type
     */
    public function getReportYears(string $type)
    {
        return Cache::remember(
            Config::get('cache-keys.report_years') . "{$type}",
            self::CACHE_LONG,
            fn() => Report::where('type', $type)
                ->published()
                ->distinct()
                ->orderBy('year', 'desc')
                ->pluck('year')
        );
    }

    /**
     * Get kas keliling with schedules
     */
    public function getKasKeliling()
    {
        return Cache::remember(
            Config::get('cache-keys.kas_keliling'),
            self::CACHE_MEDIUM,
            fn() =>
            KasKeliling::where('is_active', true)
                ->with([
                    'schedules' => function ($query) {
                        $query->where('is_active', true)
                            ->where('schedule_date', '>=', now()->toDateString())
                            ->orderBy('schedule_date');
                    }
                ])
                ->get()
        );
    }

    /**
     * Get Why Choose Us items
     */
    public function getWhyChooseUs()
    {
        try {
            return Cache::remember(Config::get('cache-keys.why_choose_us'), self::CACHE_LONG, function () {
                if (!class_exists('\App\Models\WhyChooseUs')) return collect();
                return WhyChooseUs::where('is_active', true)
                    ->orderBy('sort_order')
                    ->get();
            });
        } catch (\Exception $e) {
            return collect();
        }
    }

    /**
     * Get Why Choose Us Settings
     */
    public function getWhyChooseUsSettings()
    {
        try {
            return Cache::remember(Config::get('cache-keys.why_choose_us_settings'), self::CACHE_LONG, function () {
                if (!class_exists('\App\Models\WhyChooseUsSetting')) {
                    return (object)[
                        'section_title' => 'Mengapa Memilih Kami?',
                        'section_subtitle' => 'Keunggulan layanan perbankan syariah kami untuk Anda.',
                        'section_image' => null
                    ];
                }
                return WhyChooseUsSetting::first() ?? new WhyChooseUsSetting([
                    'section_title' => 'Mengapa Memilih Kami?',
                    'section_subtitle' => 'Keunggulan layanan perbankan syariah kami untuk Anda.',
                ]);
            });
        } catch (\Exception $e) {
            return (object)[
                'section_title' => 'Mengapa Memilih Kami?',
                'section_subtitle' => 'Keunggulan layanan perbankan syariah kami untuk Anda.',
                'section_image' => null
            ];
        }
    }

    /**
     * Get active kas keliling schedules
     */
    public function getKasKelilingSchedules()
    {
        return Cache::remember(Config::get('cache-keys.kas_keliling_schedules'), self::CACHE_MEDIUM, function () {
            $today = now()->startOfDay();
            $endDate = now()->addDays(4)->endOfDay();

            return \App\Models\KasKelilingSchedule::query()
                ->active()
                ->whereBetween('schedule_date', [
                    $today->toDateString(),
                    $endDate->toDateString()
                ])
                ->orderBy('schedule_date', 'asc')
                ->orderBy('start_time', 'asc')
                ->get()
                ->groupBy(function ($schedule) {
                    return $schedule->schedule_date->format('Y-m-d');
                });
        });
    }

    /**
     * Clear news related caches
     */
    public function clearNewsCache(): void
    {
        Cache::forget(Config::get('cache-keys.news_home'));
        Cache::forget(Config::get('cache-keys.news_categories'));

        // Clear response cache from Spatie
        try {
            if (class_exists('\Spatie\ResponseCache\Facades\ResponseCache')) {
                ResponseCache::clear();
            }
        } catch (\Exception $e) {
        }
    }

    /**
     * Clear kas keliling related caches
     */
    public function clearKasKelilingCache(): void
    {
        Cache::forget(Config::get('cache-keys.kas_keliling'));
        Cache::forget(Config::get('cache-keys.kas_keliling_schedules'));

        // Clear response cache from Spatie
        try {
            if (class_exists('\Spatie\ResponseCache\Facades\ResponseCache')) {
                ResponseCache::clear();
            }
        } catch (\Exception $e) {
        }
    }

    /**
     * Clear report related caches
     */
    public function clearReportCache(?string $type = null): void
    {
        $types = $type ? [$type] : ['keuangan_publikasi', 'tata_kelola', 'tahunan', 'tahunan_berkelanjutan'];

        // Clear all report year cache keys
        foreach ($types as $t) {
            try {
                Cache::forget(Config::get('cache-keys.report_years') . "{$t}");
            } catch (\Exception $e) {
                // Ignore errors clearing individual keys
            }
        }

        // Since we can't pattern-match all report list cache keys for all drivers,
        // flush all application cache to ensure no stale report data is left
        try {
            Cache::flush();
        } catch (\Exception $e) {
            // Ignore errors flushing cache
        }

        // Clear response cache from Spatie (will help clear any cached pages)
        try {
            if (class_exists('\Spatie\ResponseCache\Facades\ResponseCache')) {
                \Spatie\ResponseCache\Facades\ResponseCache::clear();
            }
        } catch (\Exception $e) {
            // Ignore errors clearing response cache
        }
    }

    /**
     * Clear all frontend caches
     */
    public function clearAll(): void
    {
        $keys = [
            Config::get('cache-keys.company_info'),
            Config::get('cache-keys.products_home'),
            Config::get('cache-keys.products') . 'simpanan_syariah',
            Config::get('cache-keys.products') . 'pembiayaan_syariah',
            Config::get('cache-keys.products') . 'deposito_syariah',
            Config::get('cache-keys.news_home'),
            Config::get('cache-keys.auctions_home'),
            Config::get('cache-keys.offices') . '_all',
            Config::get('cache-keys.offices') . '_pusat',
            Config::get('cache-keys.offices') . '_cabang',
            Config::get('cache-keys.offices') . '_kas',
            Config::get('cache-keys.board_members') . '_komisaris',
            Config::get('cache-keys.board_members') . '_direksi',
            Config::get('cache-keys.board_members') . '_pengawas_syariah',
            Config::get('cache-keys.kas_keliling'),
            Config::get('cache-keys.why_choose_us'),
            Config::get('cache-keys.why_choose_us_settings'),
            Config::get('cache-keys.auctions_featured'),
            Config::get('cache-keys.auctions_upcoming'),
            Config::get('cache-keys.auctions_asset_types'),
            Config::get('cache-keys.auctions_cities'),
        ];

        foreach ($keys as $key) {
            Cache::forget($key);
        }

        // Clear hero slides cache for all possible limits (1-20)
        $heroBase = Config::get('cache-keys.hero_slides');
        for ($i = 1; $i <= 20; $i++) {
            Cache::forget("{$heroBase}_{$i}");
        }

        // Clear report years
        foreach (['keuangan_publikasi', 'tata_kelola', 'tahunan', 'tahunan_berkelanjutan'] as $type) {
            Cache::forget(Config::get('cache-keys.report_years') . "{$type}");
        }

        // Clear response cache from Spatie
        try {
            if (class_exists('\Spatie\ResponseCache\Facades\ResponseCache')) {
                ResponseCache::clear();
            }
        } catch (\Exception $e) {
        }
    }

    /**
     * Clear auction related caches
     */
    public function clearAuctionCache(): void
    {
        Cache::forget(Config::get('cache-keys.auctions_home'));
        Cache::forget(Config::get('cache-keys.auctions_featured'));
        Cache::forget(Config::get('cache-keys.auctions_upcoming'));
        Cache::forget(Config::get('cache-keys.auctions_asset_types'));
        Cache::forget(Config::get('cache-keys.auctions_cities'));

        // Clear response cache from Spatie
        try {
            if (class_exists('\Spatie\ResponseCache\Facades\ResponseCache')) {
                ResponseCache::clear();
            }
        } catch (\Exception $e) {
        }
    }

    /**
     * Clear specific cache key
     */
    public function clear(string $key): void
    {
        Cache::forget($key);
    }
}
