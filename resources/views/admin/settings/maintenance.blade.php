@extends('layouts.admin')

@section('title', 'Pengaturan Maintenance')

@section('content')

@php
$isActive = old('maintenance_mode', $settings->maintenance_mode ?? false);
$groupedPages = [
    'Beranda'         => ['home'],
    'Tentang Kami'    => ['about', 'about_company', 'about_manajemen', 'about_struktur', 'about_offices'],
    'Produk & Layanan'=> ['products', 'products_simpanan', 'products_pembiayaan', 'products_deposito', 'products_kas_keliling'],
    'Informasi'       => ['auctions', 'news', 'careers'],
    'Laporan'         => ['reports', 'reports_keuangan', 'reports_tata_kelola', 'reports_tahunan', 'reports_berkelanjutan'],
    'Layanan Lainnya' => ['contact', 'whistleblowing', 'pengaduan_nasabah', 'download_logo', 'financing_simulation'],
];
$parentKeys = ['about', 'products', 'reports'];
$selectedPages = old('maintenance_pages', $settings->maintenance_pages ?? []);
@endphp

<x-admin.page-header title="Pengaturan Maintenance" subtitle="Kelola mode maintenance website"/>

@if(session('success'))
<div class="mb-6 flex items-center gap-3 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-700 rounded-xl">
    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
    </svg>
    <p class="text-sm font-medium text-emerald-700 dark:text-emerald-300">{{ session('success') }}</p>
</div>
@endif

<form action="{{ route('admin.settings.maintenance.update') }}" method="POST">
    @csrf
    @method('PUT')

    <div
        x-data="{
            enabled: {{ $isActive ? 'true' : 'false' }},
            partial: false,
            selectedCount: {{ count($selectedPages) }}
        }"
        class="space-y-6">

        {{-- ===== STATUS BANNER ===== --}}
        <div class="rounded-2xl border-2 transition-all duration-300 overflow-hidden"
            :class="enabled
                ? 'border-amber-300 dark:border-amber-600'
                : 'border-zinc-200 dark:border-zinc-700'">

            {{-- Header berwarna --}}
            <div class="px-6 py-5 flex items-center justify-between transition-colors duration-300"
                :class="enabled
                    ? 'bg-amber-50 dark:bg-amber-900/30'
                    : 'bg-zinc-50 dark:bg-zinc-800/50'">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 transition-colors duration-300"
                        :class="enabled ? 'bg-amber-200 dark:bg-amber-800' : 'bg-zinc-200 dark:bg-zinc-700'">
                        <svg class="w-5 h-5 transition-colors duration-300"
                            :class="enabled ? 'text-amber-700 dark:text-amber-300' : 'text-zinc-500 dark:text-zinc-400'"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold transition-colors duration-300"
                            :class="enabled ? 'text-amber-900 dark:text-amber-100' : 'text-zinc-700 dark:text-zinc-300'">
                            Mode Maintenance
                        </p>
                        <p class="text-xs mt-0.5 transition-colors duration-300"
                            :class="enabled ? 'text-amber-700 dark:text-amber-400' : 'text-zinc-500 dark:text-zinc-400'"
                            x-text="enabled ? 'Website sedang dalam mode maintenance — pengunjung tidak dapat mengakses.' : 'Website beroperasi normal. Aktifkan untuk menampilkan halaman maintenance.'">
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3 flex-shrink-0">
                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full transition-colors duration-300"
                        :class="enabled
                            ? 'bg-amber-200 text-amber-800 dark:bg-amber-800 dark:text-amber-200'
                            : 'bg-zinc-200 text-zinc-600 dark:bg-zinc-700 dark:text-zinc-400'"
                        x-text="enabled ? 'AKTIF' : 'NONAKTIF'">
                    </span>
                    <button type="button" @click="enabled = !enabled"
                        :class="enabled ? 'bg-amber-500 hover:bg-amber-600' : 'bg-zinc-300 dark:bg-zinc-600 hover:bg-zinc-400'"
                        class="relative inline-flex h-7 w-12 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                        <span :class="enabled ? 'translate-x-6' : 'translate-x-1'"
                            class="inline-block h-5 w-5 transform rounded-full bg-white shadow-sm transition-transform duration-200"></span>
                    </button>
                    <input type="hidden" name="maintenance_mode" :value="enabled ? '1' : '0'">
                </div>
            </div>

            {{-- Body form --}}
            <div class="p-6 bg-white dark:bg-zinc-900 border-t border-zinc-100 dark:border-zinc-800">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Pesan --}}
                    <div class="md:col-span-2">
                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">
                            Pesan untuk Pengunjung
                        </label>
                        <textarea name="maintenance_message" rows="3"
                            class="w-full rounded-xl border border-zinc-300 dark:border-zinc-600 px-4 py-2.5 text-sm bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-amber-500 resize-none"
                            placeholder="Website sedang dalam proses pemeliharaan. Mohon kunjungi kembali beberapa saat lagi.">{{ old('maintenance_message', $settings->maintenance_message ?? '') }}</textarea>
                        <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Pesan ini ditampilkan di halaman maintenance untuk pengunjung</p>
                    </div>

                    {{-- Waktu Selesai --}}
                    <div>
                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">
                            Waktu Selesai
                            <span class="font-normal text-zinc-400 dark:text-zinc-500">(Opsional)</span>
                        </label>
                        <input type="datetime-local"
                            name="maintenance_end_time"
                            value="{{ old('maintenance_end_time', $settings->maintenance_end_time?->format('Y-m-d\TH:i') ?? '') }}"
                            class="w-full rounded-xl border border-zinc-300 dark:border-zinc-600 px-4 py-2.5 text-sm bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Maintenance otomatis nonaktif setelah waktu ini</p>
                    </div>

                    {{-- IP Whitelist --}}
                    <div>
                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 mb-1.5">
                            IP yang Diizinkan
                            <span class="font-normal text-zinc-400 dark:text-zinc-500">(Bypass maintenance)</span>
                        </label>
                        <textarea name="maintenance_allowed_ips" rows="3"
                            class="w-full rounded-xl border border-zinc-300 dark:border-zinc-600 px-4 py-2.5 text-sm bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-amber-500 font-mono resize-none"
                            placeholder="192.168.1.1&#10;10.0.0.1">{{ old('maintenance_allowed_ips', $settings->maintenance_allowed_ips ?? '') }}</textarea>
                        <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">Satu IP per baris. IP ini tetap bisa mengakses website.</p>
                    </div>

                </div>
            </div>
        </div>

        {{-- ===== MAINTENANCE PARSIAL ===== --}}
        <div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">

            {{-- Header section --}}
            <button type="button" @click="partial = !partial"
                class="w-full flex items-center justify-between px-6 py-4 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors text-left">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                        <svg class="w-4 h-4 text-zinc-500 dark:text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h8M4 18h8"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">Maintenance Parsial</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">
                            <span x-show="selectedCount === 0">Pilih halaman tertentu yang ingin di-maintenance</span>
                            <span x-show="selectedCount > 0" x-text="selectedCount + ' halaman dipilih untuk di-maintenance'"></span>
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span x-show="selectedCount > 0"
                        class="text-xs font-semibold px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300"
                        x-text="selectedCount + ' dipilih'"></span>
                    <svg class="w-4 h-4 text-zinc-400 transition-transform duration-200"
                        :class="partial ? 'rotate-180' : ''"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </button>

            {{-- Konten halaman parsial --}}
            <div x-show="partial" x-cloak
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="border-t border-zinc-100 dark:border-zinc-800">

                <div class="p-6 space-y-4">
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">
                        Kosongkan semua pilihan untuk maintenance seluruh website. Memilih halaman induk akan menonaktifkan seluruh sub-halamannya.
                    </p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        @foreach($groupedPages as $groupName => $pageKeys)
                        @php
                            $groupHasPages = collect($pageKeys)->filter(fn($k) => isset($availablePages[$k]))->isNotEmpty();
                        @endphp
                        @if($groupHasPages)
                        <div class="rounded-xl border border-zinc-200 dark:border-zinc-700 overflow-hidden">
                            <div class="px-3 py-2 bg-zinc-50 dark:bg-zinc-800/60 border-b border-zinc-200 dark:border-zinc-700 flex items-center justify-between">
                                <span class="text-[11px] font-semibold text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">{{ $groupName }}</span>
                            </div>
                            <div class="p-2 space-y-px">
                                @foreach($pageKeys as $key)
                                @if(isset($availablePages[$key]))
                                @php
                                    $isChild = !in_array($key, $parentKeys)
                                        && (str_starts_with($key, 'about_')
                                        || str_starts_with($key, 'products_')
                                        || str_starts_with($key, 'reports_'));
                                    $isChecked = in_array($key, $selectedPages);
                                @endphp
                                <label class="flex items-center gap-2 px-2 py-1.5 rounded-lg cursor-pointer hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors {{ $isChild ? 'pl-5' : '' }}">
                                    <input type="checkbox"
                                        name="maintenance_pages[]"
                                        value="{{ $key }}"
                                        {{ $isChecked ? 'checked' : '' }}
                                        @change="$event.target.checked ? selectedCount++ : selectedCount--"
                                        class="rounded border-zinc-300 dark:border-zinc-600 text-amber-500 focus:ring-amber-500 flex-shrink-0">
                                    <span class="text-xs text-zinc-700 dark:text-zinc-300 leading-tight {{ !$isChild ? 'font-medium' : '' }}">
                                        {{ $availablePages[$key]['name'] }}
                                    </span>
                                </label>
                                @endif
                                @endforeach
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>

                    {{-- Note --}}
                    <div class="flex items-start gap-2 p-3 bg-zinc-50 dark:bg-zinc-800/50 rounded-xl border border-zinc-200 dark:border-zinc-700">
                        <svg class="w-4 h-4 text-zinc-500 dark:text-zinc-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-xs text-zinc-600 dark:text-zinc-400">
                            Halaman yang tidak dipilih tetap dapat diakses pengunjung meskipun mode maintenance aktif.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ===== SUBMIT ===== --}}
        <div class="flex items-center justify-between pt-2">
            <p class="text-xs text-zinc-400 dark:text-zinc-500">
                Perubahan akan langsung berlaku setelah disimpan.
            </p>
            <x-admin.button type="submit">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Simpan Pengaturan
            </x-admin.button>
        </div>

    </div>
</form>

@endsection
