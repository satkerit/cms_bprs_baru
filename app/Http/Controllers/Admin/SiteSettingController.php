<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Traits\AuthorizesAdminActions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SiteSettingController extends Controller
{
    use AuthorizesAdminActions;

    public function index()
    {
        $this->authorizeAny(['settings.site']);
        $settings = SiteSetting::getSettings();
        return view('admin.site-settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $this->authorizeAny(['settings.site']);

        try {
            $validated = $request->validate([
                'hero_slider_delay' => 'nullable|integer|min:1000|max:10000',
                'hero_slide_limit' => 'nullable|integer|min:1|max:20',
                'maintenance_mode' => 'nullable|boolean',
                'maintenance_message' => 'nullable|string|max:500',
                'maintenance_allowed_ips' => 'nullable|string',
                'maintenance_end_time' => 'nullable|date',
                'maintenance_pages' => 'nullable|array',
                'maintenance_pages.*' => 'string',
                'upload_max_filesize' => 'nullable|string|regex:/^\d+(K|M|G)?$/i',
                'post_max_size' => 'nullable|string|regex:/^\d+(K|M|G)?$/i',
                'max_execution_time' => 'nullable|integer|min:30|max:3600',
                'max_input_time' => 'nullable|integer|min:30|max:3600',
                'memory_limit' => 'nullable|string|regex:/^\d+(K|M|G)?$/i',
                'max_file_uploads' => 'nullable|integer|min:1|max:100',
                // ===== Feature-specific upload size limits =====
                'max_image_size_kb' => 'nullable|integer|min:512|max:102400',
                'max_product_image_size_kb' => 'nullable|integer|min:512|max:102400',
                'max_document_size_kb' => 'nullable|integer|min:1024|max:512000',
                'max_hero_image_size_kb' => 'nullable|integer|min:512|max:102400',
                'max_auction_image_size_kb' => 'nullable|integer|min:512|max:102400',
                // ===== SEO Settings =====
                'seo_site_name'            => 'nullable|string|max:100',
                'seo_default_description'  => 'nullable|string|max:300',
                'seo_default_keywords'     => 'nullable|string|max:500',
                'seo_og_image'             => 'nullable|string|max:500',
                'seo_twitter_handle'       => 'nullable|string|max:100',
                'seo_google_verification'  => 'nullable|string|max:200',
                'seo_bing_verification'    => 'nullable|string|max:200',
                'seo_robots_default'       => 'nullable|string|in:index,follow,noindex,nofollow,noindex\,nofollow',
                'seo_canonical_enabled'    => 'nullable|boolean',

            ], [
                'hero_slider_delay.min' => 'Delay slider minimal 1000ms',
                'hero_slider_delay.max' => 'Delay slider maksimal 10000ms',
                'hero_slide_limit.min' => 'Jumlah slide hero minimal 1',
                'hero_slide_limit.max' => 'Jumlah slide hero maksimal 20',
                'maintenance_message.max' => 'Pesan maintenance maksimal 500 karakter',
                'upload_max_filesize.regex' => 'Format ukuran file tidak valid (contoh: 100M, 2G)',
                'post_max_size.regex' => 'Format ukuran post tidak valid (contoh: 100M, 2G)',
                'max_execution_time.min' => 'Waktu eksekusi minimal 30 detik',
                'max_execution_time.max' => 'Waktu eksekusi maksimal 3600 detik',
                'max_input_time.min' => 'Waktu input minimal 30 detik',
                'max_input_time.max' => 'Waktu input maksimal 3600 detik',
                'memory_limit.regex' => 'Format batas memori tidak valid (contoh: 512M, 2G)',
                'max_file_uploads.min' => 'Jumlah file upload minimal 1',
                'max_file_uploads.max' => 'Jumlah file upload maksimal 100',
                // ===== Feature-specific upload size limit messages =====
                'max_image_size_kb.min' => 'Ukuran gambar umum minimal 512KB (0.5MB)',
                'max_image_size_kb.max' => 'Ukuran gambar umum maksimal 100MB',
                'max_product_image_size_kb.min' => 'Ukuran gambar produk minimal 512KB (0.5MB)',
                'max_product_image_size_kb.max' => 'Ukuran gambar produk maksimal 100MB',
                'max_document_size_kb.min' => 'Ukuran dokumen minimal 1MB',
                'max_document_size_kb.max' => 'Ukuran dokumen maksimal 500MB',
                'max_hero_image_size_kb.min' => 'Ukuran gambar hero slider minimal 512KB (0.5MB)',
                'max_hero_image_size_kb.max' => 'Ukuran gambar hero slider maksimal 100MB',
                'max_auction_image_size_kb.min' => 'Ukuran gambar lelang minimal 512KB (0.5MB)',
                'max_auction_image_size_kb.max' => 'Ukuran gambar lelang maksimal 100MB',
            ]);

            // Handle maintenance_mode checkbox
            $validated['maintenance_mode'] = $request->boolean('maintenance_mode', false);
            $validated['seo_canonical_enabled'] = $request->boolean('seo_canonical_enabled', true);

            // Handle maintenance_pages - if not present, set to empty array
            $validated['maintenance_pages'] = $request->input('maintenance_pages', []);

            $settings = SiteSetting::getSettings();

            // Use fill then save to ensure all attributes are set
            $settings->fill($validated);
            $settings->save();

            return redirect()->route('admin.site-settings.index')
                ->with('success', 'Pengaturan website berhasil diperbarui');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->route('admin.site-settings.index')
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Throwable $e) {
            return redirect()->route('admin.site-settings.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function updateHeroSlideLimit(Request $request)
    {
        $this->authorizeAny(['settings.site']);

        try {
            $validated = $request->validate([
                'hero_slide_limit' => 'required|integer|min:1|max:20',
            ], [
                'hero_slide_limit.required' => 'Jumlah slide hero wajib diisi',
                'hero_slide_limit.min' => 'Jumlah slide hero minimal 1',
                'hero_slide_limit.max' => 'Jumlah slide hero maksimal 20',
            ]);

            $settings = SiteSetting::getSettings();
            $settings->update($validated);

            // Clear hero slides cache
            for ($i = 1; $i <= 20; $i++) {
                Cache::forget("hero_slides_{$i}");
            }

            return response()->json([
                'success' => true,
                'message' => 'Jumlah slide hero berhasil diperbarui',
                'data' => ['hero_slide_limit' => $validated['hero_slide_limit']]
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->validator->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
