<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSliderSettings;
use Illuminate\Http\Request;

class HeroSliderSettingsController extends Controller
{
    /**
     * Show the form for editing hero slider settings
     */
    public function edit()
    {
        $settings = HeroSliderSettings::getSettings();
        return view('admin.hero-slider-settings.edit', compact('settings'));
    }

    /**
     * Update hero slider settings
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'min_width' => 'required|integer|min:320|max:1920',
            'min_height' => 'required|integer|min:240|max:1440',
            'max_width' => 'required|integer|min:640|max:3840',
            'max_height' => 'required|integer|min:480|max:2160',
            'max_file_size_mb' => 'required|integer|min:1|max:20',
            'aspect_ratio' => 'required|string|regex:/^\d+:\d+$/',
            'slider_delay_ms' => 'required|integer|min:1000|max:30000',
            'min_height_px' => 'required|integer|min:200|max:500',
            'max_height_px' => 'required|integer|min:300|max:1000',
            'enable_autoplay' => 'boolean',
            'enable_touch_swipe' => 'boolean',
            'enable_navigation_arrows' => 'boolean',
            'enable_dot_indicators' => 'boolean',
        ]);

        // Ensure max is greater than min
        if ($validated['min_width'] > $validated['max_width']) {
            return back()->withErrors(['max_width' => 'Max width must be greater than min width']);
        }
        if ($validated['min_height'] > $validated['max_height']) {
            return back()->withErrors(['max_height' => 'Max height must be greater than min height']);
        }
        if ($validated['min_height_px'] > $validated['max_height_px']) {
            return back()->withErrors(['max_height_px' => 'Max height (px) must be greater than min height (px)']);
        }

        $settings = HeroSliderSettings::getSettings();
        $settings->update($validated);

        return back()->with('success', 'Hero Slider settings updated successfully');
    }
}

