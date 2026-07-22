<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class HeroSliderSettings extends Model
{
    protected $fillable = [
        'min_width',
        'min_height',
        'max_width',
        'max_height',
        'max_file_size_mb',
        'aspect_ratio',
        'slider_delay_ms',
        'min_height_px',
        'max_height_px',
        'enable_autoplay',
        'enable_touch_swipe',
        'enable_navigation_arrows',
        'enable_dot_indicators',
    ];

    protected $casts = [
        'min_width' => 'integer',
        'min_height' => 'integer',
        'max_width' => 'integer',
        'max_height' => 'integer',
        'max_file_size_mb' => 'integer',
        'slider_delay_ms' => 'integer',
        'min_height_px' => 'integer',
        'max_height_px' => 'integer',
        'enable_autoplay' => 'boolean',
        'enable_touch_swipe' => 'boolean',
        'enable_navigation_arrows' => 'boolean',
        'enable_dot_indicators' => 'boolean',
    ];

    /**
     * Get the default or only settings record
     */
    public static function getSettings()
    {
        return Cache::remember('hero_slider_settings', 3600, function () {
            return            self::firstOrCreate([], [
                'min_width' => 1920,
                'min_height' => 600,
                'max_width' => 7680,
                'max_height' => 4320,
                'max_file_size_mb' => 5,
                'aspect_ratio' => '2.4:1',
                'slider_delay_ms' => 7000,
                'min_height_px' => 320,
                'max_height_px' => 800,
                'enable_autoplay' => true,
                'enable_touch_swipe' => true,
                'enable_navigation_arrows' => true,
                'enable_dot_indicators' => true,
            ]);
        });
    }

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        // Clear cache when settings are updated
        static::saved(function () {
            Cache::forget('hero_slider_settings');
        });
    }

    /**
     * Parse aspect ratio string (e.g., "16:9") and return as array
     */
    public function getAspectRatioArray()
    {
        $parts = explode(':', $this->aspect_ratio);
        return [
            'width' => (int)$parts[0],
            'height' => (int)$parts[1] ?? 9,
        ];
    }

    /**
     * Get max file size in bytes
     */
    public function getMaxFileSizeBytes()
    {
        return $this->max_file_size_mb * 1024 * 1024;
    }
}

