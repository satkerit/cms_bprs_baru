<?php

namespace App\Http\Controllers;

use App\Services\CacheService;
use App\Models\SiteSetting;
use App\Services\ImageService;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::getSettings();
        $heroSlides = app(CacheService::class)->getHeroSlidesDynamic();

        // Defensive check: jika tidak ada slider aktif, gunakan default empty collection
        if ($heroSlides->isEmpty()) {
            $heroSlides = collect();
        }

        // Pre-compute all hero slide image URLs — batch mode: 1 files() call per directory
        // instead of 7 exists() calls per slide
        $heroSlideImages = Cache::remember('hero_slide_images', 3600, function () use ($heroSlides) {
            $imagePaths = $heroSlides->pluck('image')->filter()->values()->toArray();
            $batch = ImageService::getExistingVariants($imagePaths);

            $images = [];
            foreach ($heroSlides as $slide) {
                if (!$slide->image) continue;
                $key = pathinfo($slide->image, PATHINFO_DIRNAME) . '/' . pathinfo($slide->image, PATHINFO_FILENAME);
                $found = $batch[$key] ?? null;
                $images[$slide->id] = $found ?: [
                    'compressed' => $slide->image,
                    'webp_responsive' => [],
                    'avif_responsive' => [],
                ];
            }
            return $images;
        });

        // Preload first hero image for better performance
        $firstHeroImage = $heroSlides->first()?->image;

        return view('frontend.home', [
            'companyInfo' => app(CacheService::class)->getCompanyInfo(),
            'heroSlides' => $heroSlides,
            'heroSlideImages' => $heroSlideImages,
            'heroSliderDelay' => $settings->hero_slider_delay ?? 5000,
            'firstHeroImage' => $firstHeroImage,
            'whyChooseUs' => app(CacheService::class)->getWhyChooseUs(),
            'whyChooseUsSettings' => app(CacheService::class)->getWhyChooseUsSettings(),
        ]);
    }
}
