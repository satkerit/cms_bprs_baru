@extends('layouts.admin')

@section('title', 'Pengaturan Hero Slider')

@section('content')
<x-admin.page-header title="Pengaturan Hero Slider" subtitle="Konfigurasi dimensi gambar dan fitur slider">
    <x-slot:actions>
        <x-admin.button href="{{ route('admin.hero-slides.index') }}" variant="secondary">Kembali</x-admin.button>
    </x-slot:actions>
</x-admin.page-header>

@if(session('success'))
<div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl">
    {{ session('success') }}
</div>
@endif

<form action="{{ route('admin.hero-slider-settings.update') }}" method="POST">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="space-y-6">
            <x-admin.card title="Dimensi Gambar">
                <div class="space-y-4">
                    <x-admin.input type="number" name="min_width" label="Lebar Minimum (px)" :value="old('min_width', $settings->min_width ?? 320)" min="320" max="1920" required hint="Minimum: 320px"/>
                    <x-admin.input type="number" name="min_height" label="Tinggi Minimum (px)" :value="old('min_height', $settings->min_height ?? 240)" min="240" max="1440" required hint="Minimum: 240px"/>
                    <hr class="border-zinc-200">
                    <x-admin.input type="number" name="max_width" label="Lebar Maksimum (px)" :value="old('max_width', $settings->max_width ?? 3840)" min="640" max="3840" required hint="Maksimum: 3840px (4K)"/>
                    <x-admin.input type="number" name="max_height" label="Tinggi Maksimum (px)" :value="old('max_height', $settings->max_height ?? 2160)" min="480" max="2160" required hint="Maksimum: 2160px (2K)"/>
                    <hr class="border-zinc-200">
                    <x-admin.input name="aspect_ratio" label="Rasio Aspek" :value="old('aspect_ratio', $settings->aspect_ratio ?? '16:9')" placeholder="16:9" hint="Format: lebar:tinggi"/>
                    <x-admin.input type="number" name="max_file_size_mb" label="Ukuran File Maksimum (MB)" :value="old('max_file_size_mb', $settings->max_file_size_mb ?? 5)" min="1" max="20" required hint="Rentang: 1-20 MB"/>
                </div>
            </x-admin.card>
        </div>
        <div class="space-y-6">
            <x-admin.card title="Kontainer & Fitur">
                <div class="space-y-4">
                    <x-admin.input type="number" name="slider_delay_ms" label="Delay Auto-Play (ms)" :value="old('slider_delay_ms', $settings->slider_delay_ms ?? 5000)" min="1000" max="30000" step="500" required hint="Rentang: 1000-30000ms"/>
                    <hr class="border-zinc-200">
                    <x-admin.input type="number" name="min_height_px" label="Tinggi Minimum Kontainer (px)" :value="old('min_height_px', $settings->min_height_px ?? 300)" min="200" max="500" required hint="Tinggi minimum untuk mobile"/>
                    <x-admin.input type="number" name="max_height_px" label="Tinggi Maksimum Kontainer (px)" :value="old('max_height_px', $settings->max_height_px ?? 600)" min="300" max="1000" required hint="Tinggi maksimum untuk desktop"/>
                    <hr class="border-zinc-200">
                    <div class="space-y-3">
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="enable_autoplay" id="enable_autoplay" value="1" @if(old('enable_autoplay', $settings->enable_autoplay ?? true)) checked @endif class="rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500 h-4 w-4">
                            <label for="enable_autoplay" class="text-[13px] text-zinc-700 font-medium">Aktifkan Auto-Play</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="enable_touch_swipe" id="enable_touch_swipe" value="1" @if(old('enable_touch_swipe', $settings->enable_touch_swipe ?? true)) checked @endif class="rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500 h-4 w-4">
                            <label for="enable_touch_swipe" class="text-[13px] text-zinc-700 font-medium">Aktifkan Touch Swipe</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="enable_navigation_arrows" id="enable_navigation_arrows" value="1" @if(old('enable_navigation_arrows', $settings->enable_navigation_arrows ?? true)) checked @endif class="rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500 h-4 w-4">
                            <label for="enable_navigation_arrows" class="text-[13px] text-zinc-700 font-medium">Aktifkan Panah Navigasi</label>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="enable_dot_indicators" id="enable_dot_indicators" value="1" @if(old('enable_dot_indicators', $settings->enable_dot_indicators ?? true)) checked @endif class="rounded border-zinc-300 text-emerald-600 focus:ring-emerald-500 h-4 w-4">
                            <label for="enable_dot_indicators" class="text-[13px] text-zinc-700 font-medium">Aktifkan Indikator Titik</label>
                        </div>
                    </div>
                </div>
            </x-admin.card>
            <x-admin.card title="Informasi">
                <div class="text-[13px] text-zinc-600 space-y-2">
                    <p><strong>Ukuran Upload yang Direkomendasikan:</strong><br>
                        1920×1080px atau lebih besar</p>
                    <p><strong>Rasio Aspek:</strong><br>
                        Gambar akan dipotong sesuai rasio {{ $settings->aspect_ratio ?? '16:9' }}</p>
                </div>
            </x-admin.card>
            <div class="flex gap-3">
                <x-admin.button type="submit">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    Simpan Pengaturan
                </x-admin.button>
            </div>
        </div>
    </div>
</form>
@endsection
