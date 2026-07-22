<?php

namespace Database\Seeders;

use App\Models\HeroSliderSettings;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeroSliderSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HeroSliderSettings::firstOrCreate([], [
            'min_width' => 320,
            'min_height' => 240,
            'max_width' => 3840,
            'max_height' => 2160,
            'max_file_size_mb' => 5,
            'aspect_ratio' => '16:9',
            'slider_delay_ms' => 7000,
            'min_height_px' => 320,
            'max_height_px' => 600,
            'enable_autoplay' => true,
            'enable_touch_swipe' => true,
            'enable_navigation_arrows' => true,
            'enable_dot_indicators' => true,
        ]);
    }
}

