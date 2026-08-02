@extends('layouts.admin')

@section('title', 'Pengaturan Website')

@section('content')
<x-admin.page-header title="Pengaturan Website" subtitle="Kelola pengaturan umum website">
 <x-slot:actions>
 <x-admin.button type="submit" form="siteSettingsForm" icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>'>
 Simpan Perubahan
 </x-admin.button>
 </x-slot:actions>
</x-admin.page-header>

<x-admin.card>
 <form id="siteSettingsForm" method="POST" action="{{ route('admin.site-settings.update') }}" class="space-y-6">
 @csrf
 @method('PUT')

 {{-- Hero Slider Settings --}}
 <div class="border-b border-zinc-200 pb-6">
 <h3 class="text-3xl font-semibold dark:text-slate-100 text-zinc-900 mb-4">Pengaturan Hero Slider</h3>

 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 <div>
 <label for="hero_slider_delay" class="block text-[11px] font-medium dark:text-slate-300 text-zinc-700 mb-2">
 Delay Slider (milidetik)
 </label>
 <input type="number"
 name="hero_slider_delay"
 id="hero_slider_delay"
 value="{{ old('hero_slider_delay', $settings->hero_slider_delay ?? 5000) }}"
 class="w-full rounded-xl border-zinc-300"
 min="1000"
 max="20000"
 step="500"
 required>
 <p class="mt-1 text-[11px] dark:text-slate-400 text-zinc-500">Durasi tampil setiap slide (1000-20000ms)</p>
 </div>

 <div>
 <label for="hero_slide_limit" class="block text-[11px] font-medium dark:text-slate-300 text-zinc-700 mb-2">
 Jumlah Maksimal Slide
 </label>
 <input type="number"
 name="hero_slide_limit"
 id="hero_slide_limit"
 value="{{ old('hero_slide_limit', $settings->hero_slide_limit ?? 5) }}"
 class="w-full rounded-xl border-zinc-300"
 min="1"
 max="20"
 required>
 <p class="mt-1 text-[11px] dark:text-slate-400 text-zinc-500">Jumlah maksimal slide yang ditampilkan di halaman utama (1-20)</p>
 </div>
 </div>
 </div>

 {{-- Upload Settings --}}
 <div class="border-b border-zinc-200 pb-6">
 <h3 class="text-3xl font-semibold dark:text-slate-100 text-zinc-900 mb-4">Pengaturan Upload File</h3>

 {{-- PHP-level Settings --}}
 <div class="mb-6">
 <h4 class="text-sm font-medium dark:text-slate-300 text-zinc-700 mb-3">PHP-Level Settings</h4>
 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 <div>
 <label for="upload_max_filesize" class="block text-[11px] font-medium dark:text-slate-300 text-zinc-700 mb-2">
 Ukuran Maksimal File Upload
 </label>
 <input type="text"
 name="upload_max_filesize"
 id="upload_max_filesize"
 value="{{ old('upload_max_filesize', $settings->upload_max_filesize ?? '100M') }}"
 class="w-full rounded-xl border-zinc-300"
 placeholder="100M">
 <p class="mt-1 text-[11px] dark:text-slate-400 text-zinc-500">Ukuran maksimal file yang diupload (contoh: 100M, 2G)</p>
 </div>

 <div>
 <label for="post_max_size" class="block text-[11px] font-medium dark:text-slate-300 text-zinc-700 mb-2">
 Ukuran Maksimal Post Data
 </label>
 <input type="text"
 name="post_max_size"
 id="post_max_size"
 value="{{ old('post_max_size', $settings->post_max_size ?? '100M') }}"
 class="w-full rounded-xl border-zinc-300"
 placeholder="100M">
 <p class="mt-1 text-[11px] dark:text-slate-400 text-zinc-500">Ukuran maksimal data POST (contoh: 100M, 2G)</p>
 </div>

 <div>
 <label for="max_execution_time" class="block text-[11px] font-medium dark:text-slate-300 text-zinc-700 mb-2">
 Waktu Eksekusi Maksimal (detik)
 </label>
 <input type="number"
 name="max_execution_time"
 id="max_execution_time"
 value="{{ old('max_execution_time', $settings->max_execution_time ?? 300) }}"
 class="w-full rounded-xl border-zinc-300"
 min="30"
 max="3600">
 <p class="mt-1 text-[11px] dark:text-slate-400 text-zinc-500">Waktu maksimal eksekusi script (30-3600 detik)</p>
 </div>

 <div>
 <label for="max_input_time" class="block text-[11px] font-medium dark:text-slate-300 text-zinc-700 mb-2">
 Waktu Input Maksimal (detik)
 </label>
 <input type="number"
 name="max_input_time"
 id="max_input_time"
 value="{{ old('max_input_time', $settings->max_input_time ?? 300) }}"
 class="w-full rounded-xl border-zinc-300"
 min="30"
 max="3600">
 <p class="mt-1 text-[11px] dark:text-slate-400 text-zinc-500">Waktu maksimal menerima input (30-3600 detik)</p>
 </div>

 <div>
 <label for="memory_limit" class="block text-[11px] font-medium dark:text-slate-300 text-zinc-700 mb-2">
 Batas Memori
 </label>
 <input type="text"
 name="memory_limit"
 id="memory_limit"
 value="{{ old('memory_limit', $settings->memory_limit ?? '512M') }}"
 class="w-full rounded-xl border-zinc-300"
 placeholder="512M">
 <p class="mt-1 text-[11px] dark:text-slate-400 text-zinc-500">Batas memori script (contoh: 512M, 2G)</p>
 </div>

 <div>
 <label for="max_file_uploads" class="block text-[11px] font-medium dark:text-slate-300 text-zinc-700 mb-2">
 Jumlah File Upload Maksimal
 </label>
 <input type="number"
 name="max_file_uploads"
 id="max_file_uploads"
 value="{{ old('max_file_uploads', $settings->max_file_uploads ?? 20) }}"
 class="w-full rounded-xl border-zinc-300"
 min="1"
 max="100">
 <p class="mt-1 text-[11px] dark:text-slate-400 text-zinc-500">Jumlah file yang bisa diupload sekaligus (1-100)</p>
 </div>
 </div>
 </div>

 {{-- Feature-specific Upload Limits --}}
 <div>
 <h4 class="text-sm font-medium dark:text-slate-300 text-zinc-700 mb-3">Batas Ukuran Per Fitur (KB)</h4>
 <p class="text-[11px] dark:text-slate-400 text-zinc-500 mb-4">Atur batas ukuran upload untuk setiap jenis file. 1MB = 1024KB.</p>
 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 <div>
 <label for="max_image_size_kb" class="block text-[11px] font-medium dark:text-slate-300 text-zinc-700 mb-2">
 Gambar Umum (KB)
 </label>
 <input type="number"
 name="max_image_size_kb"
 id="max_image_size_kb"
 value="{{ old('max_image_size_kb', $settings->max_image_size_kb ?? 2048) }}"
 class="w-full rounded-xl border-zinc-300"
 min="512"
 max="102400">
 <p class="mt-1 text-[11px] dark:text-slate-400 text-zinc-500">Berita, Board Member, Office, Logo, WhyChooseUs (512-102400 KB)</p>
 </div>

 <div>
 <label for="max_product_image_size_kb" class="block text-[11px] font-medium dark:text-slate-300 text-zinc-700 mb-2">
 Gambar Produk (KB)
 </label>
 <input type="number"
 name="max_product_image_size_kb"
 id="max_product_image_size_kb"
 value="{{ old('max_product_image_size_kb', $settings->max_product_image_size_kb ?? 5120) }}"
 class="w-full rounded-xl border-zinc-300"
 min="512"
 max="102400">
 <p class="mt-1 text-[11px] dark:text-slate-400 text-zinc-500">Gambar produk & layanan (512-102400 KB)</p>
 </div>

 <div>
 <label for="max_document_size_kb" class="block text-[11px] font-medium dark:text-slate-300 text-zinc-700 mb-2">
 Dokumen PDF (KB)
 </label>
 <input type="number"
 name="max_document_size_kb"
 id="max_document_size_kb"
 value="{{ old('max_document_size_kb', $settings->max_document_size_kb ?? 15360) }}"
 class="w-full rounded-xl border-zinc-300"
 min="1024"
 max="512000">
 <p class="mt-1 text-[11px] dark:text-slate-400 text-zinc-500">Laporan & Brosur PDF (1024-512000 KB)</p>
 </div>

 <div>
 <label for="max_hero_image_size_kb" class="block text-[11px] font-medium dark:text-slate-300 text-zinc-700 mb-2">
 Gambar Hero Slider (KB)
 </label>
 <input type="number"
 name="max_hero_image_size_kb"
 id="max_hero_image_size_kb"
 value="{{ old('max_hero_image_size_kb', $settings->max_hero_image_size_kb ?? 5120) }}"
 class="w-full rounded-xl border-zinc-300"
 min="512"
 max="102400">
 <p class="mt-1 text-[11px] dark:text-slate-400 text-zinc-500">Slide hero slider utama (512-102400 KB)</p>
 </div>

 <div>
 <label for="max_auction_image_size_kb" class="block text-[11px] font-medium dark:text-slate-300 text-zinc-700 mb-2">
 Gambar Lelang (KB)
 </label>
 <input type="number"
 name="max_auction_image_size_kb"
 id="max_auction_image_size_kb"
 value="{{ old('max_auction_image_size_kb', $settings->max_auction_image_size_kb ?? 5120) }}"
 class="w-full rounded-xl border-zinc-300"
 min="512"
 max="102400">
 <p class="mt-1 text-[11px] dark:text-slate-400 text-zinc-500">Gambar aset lelang (512-102400 KB)</p>
 </div>
 </div>
 </div>
 </div>

 {{-- Report Page Settings --}}
 <div class="border-b border-zinc-200 pb-6">
 <h3 class="text-3xl font-semibold dark:text-slate-100 text-zinc-900 mb-4">Pengaturan Halaman Laporan</h3>
 <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-6">
                <div class="flex items-start gap-4">
                    <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="text-[11px] font-medium text-emerald-800">Pengaturan laporan telah dipindahkan</p>
                        <p class="text-[11px] text-emerald-700 mt-1">Judul, subjudul, dan deskripsi setiap halaman laporan kini dikelola di halaman khusus dengan tampilan card.</p>
 <a href="{{ route('admin.report-categories.index') }}" class="inline-flex items-center mt-3 px-4 py-2 text-[11px] font-medium text-white bg-teal-600 rounded-xl">
 <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
 </svg>
 Kelola Kategori Laporan
 </a>
 </div>
 </div>
 </div>
 </div>

 {{-- Maintenance Mode Settings --}}
 <div class="border-b border-zinc-200 pb-6">
 <h3 class="text-3xl font-semibold dark:text-slate-100 text-zinc-900 mb-4">Pengaturan Maintenance Mode</h3>

 <div class="space-y-4">
 <div class="flex items-center">
 <input type="checkbox"
 name="maintenance_mode"
 id="maintenance_mode"
 value="1"
 {{ old('maintenance_mode', $settings->maintenance_mode ?? false) ? 'checked' : '' }}
 class="rounded border-zinc-300 text-sky-600">
 <label for="maintenance_mode" class="ml-2 text-[11px] font-medium dark:text-slate-300 text-zinc-700">
 Aktifkan Mode Pemeliharaan
 </label>
 </div>

 <div id="maintenance_fields" class="grid grid-cols-1 md:grid-cols-2 gap-6 {{ !old('maintenance_mode', $settings->maintenance_mode ?? false) ? 'hidden' : '' }}">
 <div class="md:lg:col-span-2 col-span-1">
 <label for="maintenance_message" class="block text-[11px] font-medium dark:text-slate-300 text-zinc-700 mb-2">
 Pesan Maintenance
 </label>
 <textarea name="maintenance_message"
 id="maintenance_message"
 rows="3"
 class="w-full rounded-xl border-zinc-300">{{ old('maintenance_message', $settings->maintenance_message ?? '') }}</textarea>
 </div>

 <div>
 <label for="maintenance_end_time" class="block text-[11px] font-medium dark:text-slate-300 text-zinc-700 mb-2">
 Waktu Selesai Maintenance
 </label>
 <input type="datetime-local"
 name="maintenance_end_time"
 id="maintenance_end_time"
 value="{{ old('maintenance_end_time', $settings->maintenance_end_time ? $settings->maintenance_end_time->format('Y-m-d\\TH:i') : '') }}"
 class="w-full rounded-xl border-zinc-300">
 </div>

 <div class="md:lg:col-span-2 col-span-1">
 <label for="maintenance_allowed_ips" class="block text-[11px] font-medium dark:text-slate-300 text-zinc-700 mb-2">
 IP Address yang Diizinkan (satu per baris)
 </label>
 <textarea name="maintenance_allowed_ips"
 id="maintenance_allowed_ips"
 rows="3"
 placeholder="192.168.1.1&#10;10.0.0.1&#10;contoh.com"
 class="w-full rounded-xl border-zinc-300">{{ old('maintenance_allowed_ips', $settings->maintenance_allowed_ips ?? '') }}</textarea>
 <p class="mt-1 text-[11px] dark:text-slate-400 text-zinc-500">Kosongkan untuk memblokir semua IP</p>
 </div>

 <div class="md:lg:col-span-2 col-span-1">
 <label class="block text-[11px] font-medium dark:text-slate-300 text-zinc-700 mb-2">
 Halaman yang Di-maintenance
 </label>
 <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:grid-cols-2 gap-2 max-h-48 border border-zinc-200 rounded-xl p-3">
 @foreach(\App\Models\SiteSetting::getAvailablePages() as $key => $page)
 <div class="flex items-center">
 <input type="checkbox"
 name="maintenance_pages[]"
 value="{{ $key }}"
 {{ in_array($key, old('maintenance_pages', $settings->maintenance_pages ?? [])) ? 'checked' : '' }}
 class="rounded border-zinc-300 text-sky-600">
 <label class="ml-2 text-[11px] dark:text-slate-300 text-zinc-700">{{ $page['name'] }}</label>
 </div>
 @endforeach
 </div>
 </div>
 </div>
 </div>
 </div>

 {{-- SEO Settings --}}
 <div class="border-b border-zinc-200 pb-6">
 <h3 class="text-3xl font-semibold dark:text-slate-100 text-zinc-900 mb-4">Pengaturan SEO</h3>

 <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
 <div>
 <label for="seo_site_name" class="block text-[11px] font-medium dark:text-slate-300 text-zinc-700 mb-2">
 Nama Website (Site Name)
 </label>
 <input type="text"
 name="seo_site_name"
 id="seo_site_name"
 value="{{ old('seo_site_name', $settings->seo_site_name ?? '') }}"
 class="w-full rounded-xl border-zinc-300"
 maxlength="100">
 </div>

 <div>
 <label for="seo_og_image" class="block text-[11px] font-medium dark:text-slate-300 text-zinc-700 mb-2">
 URL Gambar Open Graph Default
 </label>
 <input type="text"
 name="seo_og_image"
 id="seo_og_image"
 value="{{ old('seo_og_image', $settings->seo_og_image ?? '') }}"
 class="w-full rounded-xl border-zinc-300"
 maxlength="500">
 <p class="mt-1 text-[11px] dark:text-slate-400 text-zinc-500">Dipakai saat share ke media sosial jika tidak ada gambar spesifik</p>
 </div>

 <div>
 <label for="seo_default_description" class="block text-[11px] font-medium dark:text-slate-300 text-zinc-700 mb-2">
 Deskripsi Default (Meta Description)
 </label>
 <textarea name="seo_default_description"
 id="seo_default_description"
 rows="3"
 maxlength="300"
 class="w-full rounded-xl border-zinc-300">{{ old('seo_default_description', $settings->seo_default_description ?? '') }}</textarea>
 <p class="mt-1 text-[11px] dark:text-slate-400 text-zinc-500">Maks 160 karakter. Dipakai jika halaman tidak punya deskripsi khusus.</p>
 </div>

 <div>
 <label for="seo_default_keywords" class="block text-[11px] font-medium dark:text-slate-300 text-zinc-700 mb-2">
 Kata Kunci Default
 </label>
 <textarea name="seo_default_keywords"
 id="seo_default_keywords"
 rows="2"
 maxlength="500"
 class="w-full rounded-xl border-zinc-300">{{ old('seo_default_keywords', $settings->seo_default_keywords ?? '') }}</textarea>
 <p class="mt-1 text-[11px] dark:text-slate-400 text-zinc-500">Pisahkan dengan koma</p>
 </div>

 <div>
 <label for="seo_twitter_handle" class="block text-[11px] font-medium dark:text-slate-300 text-zinc-700 mb-2">
 Twitter/X Handle
 </label>
 <input type="text"
 name="seo_twitter_handle"
 id="seo_twitter_handle"
 value="{{ old('seo_twitter_handle', $settings->seo_twitter_handle ?? '') }}"
 class="w-full rounded-xl border-zinc-300"
 placeholder="@username"
 maxlength="100">
 <p class="mt-1 text-[11px] dark:text-slate-400 text-zinc-500">Contoh: @BPRSBabelID</p>
 </div>

 <div>
 <label for="seo_robots_default" class="block text-[11px] font-medium dark:text-slate-300 text-zinc-700 mb-2">
 Robots Default
 </label>
 <select name="seo_robots_default"
 id="seo_robots_default"
 class="w-full rounded-xl border-zinc-300">
 <option value="index, follow" {{ old('seo_robots_default', $settings->seo_robots_default ?? 'index, follow') === 'index, follow' ? 'selected' : '' }}>index, follow (default)</option>
 <option value="noindex, nofollow" {{ old('seo_robots_default', $settings->seo_robots_default ?? '') === 'noindex, nofollow' ? 'selected' : '' }}>noindex, nofollow</option>
 <option value="noindex, follow" {{ old('seo_robots_default', $settings->seo_robots_default ?? '') === 'noindex, follow' ? 'selected' : '' }}>noindex, follow</option>
 <option value="index, nofollow" {{ old('seo_robots_default', $settings->seo_robots_default ?? '') === 'index, nofollow' ? 'selected' : '' }}>index, nofollow</option>
 </select>
 </div>

 <div>
 <label for="seo_google_verification" class="block text-[11px] font-medium dark:text-slate-300 text-zinc-700 mb-2">
 Google Search Console Verification Code
 </label>
 <input type="text"
 name="seo_google_verification"
 id="seo_google_verification"
 value="{{ old('seo_google_verification', $settings->seo_google_verification ?? '') }}"
 class="w-full rounded-xl border-zinc-300"
 maxlength="200">
 </div>

 <div>
 <label for="seo_bing_verification" class="block text-[11px] font-medium dark:text-slate-300 text-zinc-700 mb-2">
 Bing Webmaster Verification Code
 </label>
 <input type="text"
 name="seo_bing_verification"
 id="seo_bing_verification"
 value="{{ old('seo_bing_verification', $settings->seo_bing_verification ?? '') }}"
 class="w-full rounded-xl border-zinc-300"
 maxlength="200">
 </div>

 <div class="md:col-span-2">
 <div class="flex items-center gap-3">
 <input type="hidden" name="seo_canonical_enabled" value="0">
 <input type="checkbox"
 name="seo_canonical_enabled"
 id="seo_canonical_enabled"
 value="1"
 {{ old('seo_canonical_enabled', $settings->seo_canonical_enabled ?? true) ? 'checked' : '' }}
 class="rounded border-zinc-300 text-sky-600">
 <label for="seo_canonical_enabled" class="text-[11px] font-medium dark:text-slate-300 text-zinc-700">
 Aktifkan Canonical URL otomatis
 </label>
 </div>
 </div>
 </div>
 </div>

 {{-- Submit Button --}}
 <div class="flex justify-end pt-4">
 <x-admin.button type="submit" icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>'>
 Simpan Perubahan
 </x-admin.button>
 </div>
 </form>
</x-admin.card>

@push('scripts')
<script nonce="{{ $nonce }}">
document.addEventListener('DOMContentLoaded', function() {
 const maintenanceModeCheckbox = document.getElementById('maintenance_mode');
 const maintenanceFields = document.getElementById('maintenance_fields');

 function toggleMaintenanceFields() {
 if (maintenanceModeCheckbox.checked) {
 maintenanceFields.classList.remove('hidden');
 } else {
 maintenanceFields.classList.add('hidden');
 }
 }

 maintenanceModeCheckbox.addEventListener('change', toggleMaintenanceFields);
 toggleMaintenanceFields(); // Initial state
});
</script>
@endpush
@endsection
