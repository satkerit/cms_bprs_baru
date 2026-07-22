<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HeroSlide\StoreHeroSlideRequest;
use App\Http\Requests\Admin\HeroSlide\UpdateHeroSlideRequest;
use App\Models\HeroSlide;
use App\Models\SiteSetting;
use App\Traits\AuthorizesAdminActions;
use App\Traits\HandlesImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class HeroSlideController extends Controller
{
    use HandlesImageUpload, AuthorizesAdminActions;

    public function index()
    {
        $this->authorizeView('settings.hero');

        $slides = HeroSlide::orderBy('order_position')->get();
        return view('admin.hero-slides.index', compact('slides'));
    }

    public function settings()
    {
        $this->authorizeView('settings.hero');
        $settings = SiteSetting::getSettings();
        return view('admin.hero-slides.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $this->authorizeEdit('settings.hero');

        $validated = $request->validate([
            'hero_slider_delay' => 'required|integer|min:1000|max:20000',
            'hero_slide_limit' => 'required|integer|min:1|max:20',
        ]);

        $settings = SiteSetting::first();
        if ($settings) {
            $settings->update($validated);
        } else {
            // Create default settings if not exists
            SiteSetting::create(array_merge([
                'maintenance_mode' => false,
                'maintenance_message' => 'Website sedang dalam pemeliharaan untuk peningkatan layanan. Silakan kembali beberapa saat lagi.',
            ], $validated));
        }

        // Clear cache
        SiteSetting::clearCache();

        return redirect()->route('admin.hero-slides.index')->with('success', 'Pengaturan slider berhasil diperbarui.');
    }

    public function create()
    {
        $this->authorizeCreate('settings.hero');

        $transitionTypes = HeroSlide::getTransitionTypes();
        return view('admin.hero-slides.form', compact('transitionTypes'));
    }

    public function store(StoreHeroSlideRequest $request)
    {
        $this->authorizeCreate('settings.hero');
        $validated = $request->validated();

        try {
            $validated['image'] = $this->handleImageUpload($request, 'image', 'hero-slides');

            if (!$validated['image']) {
                return back()->withInput()->with('error', 'Gambar slide wajib diupload.');
            }

            HeroSlide::create($validated);

            return redirect()->route('admin.hero-slides.index')->with('success', 'Slide berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Error creating hero slide: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal menambahkan slide. Silakan coba lagi.');
        }
    }

    public function edit(HeroSlide $heroSlide)
    {
        $this->authorizeEdit('settings.hero');

        $transitionTypes = HeroSlide::getTransitionTypes();
        return view('admin.hero-slides.form', compact('heroSlide', 'transitionTypes'));
    }

    public function update(UpdateHeroSlideRequest $request, HeroSlide $heroSlide)
    {
        $this->authorizeEdit('settings.hero');
        $validated = $request->validated();

        try {
            $validated['image'] = $this->handleImageUpload($request, 'image', 'hero-slides', $heroSlide->image);

            $heroSlide->update($validated);

            return redirect()->route('admin.hero-slides.index')->with('success', 'Slide berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Error updating hero slide: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal memperbarui slide. Silakan coba lagi.');
        }
    }

    public function destroy(HeroSlide $heroSlide)
    {
        $this->authorizeDelete('settings.hero');

        try {
            if ($heroSlide->image) {
                Storage::disk('public')->delete($heroSlide->image);
            }

            $heroSlide->delete();

            return redirect()->route('admin.hero-slides.index')->with('success', 'Slide berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Error deleting hero slide: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus slide. Silakan coba lagi.');
        }
    }

    public function reorder(Request $request)
    {
        $this->authorizeEdit('settings.hero');

        $request->validate(['order' => 'required|array']);

        foreach ($request->order as $index => $id) {
            HeroSlide::where('id', $id)->update(['order_position' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
