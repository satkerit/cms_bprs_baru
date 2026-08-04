@extends('layouts.admin')

@section('title', $auction->title)

@section('content')
@php
    $images = $auction->images ?? [];
    $statusColors = [
        'draft' => 'bg-zinc-100 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300',
        'published' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
        'registration_open' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
        'registration_closed' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
        'sold' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
        'cancelled' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
    ];
    $statusColor = $statusColors[$auction->status] ?? $statusColors['draft'];
    $rupiah = fn($v) => $v ? 'Rp ' . number_format($v, 0, ',', '.') : '-';
@endphp

<x-admin.page-header :title="$auction->title" subtitle="{{ $auction->auction_number }}">
    <x-slot:actions>
        <a href="{{ route('auctions.show', $auction->slug) }}" target="_blank"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 text-sm font-semibold hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            Lihat di Website
        </a>
        <x-admin.button href="{{ route('admin.auctions.edit', $auction) }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            Edit
        </x-admin.button>
    </x-slot:actions>
</x-admin.page-header>

@if(session('success'))
    <x-admin.alert type="success" title="Berhasil!" class="mb-5">{{ session('success') }}</x-admin.alert>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ═══ KIRI: Detail Utama ═══ --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- Gallery --}}
        <x-admin.card :noPadding="true">
            @if(count($images) > 0)
            <div x-data="{ active: 0 }">
                <div class="bg-zinc-100 dark:bg-zinc-800">
                    @foreach($images as $i => $img)
                    <img src="{{ \App\Helpers\StorageHelper::url($img) }}"
                        x-show="active === {{ $i }}" x-cloak
                        class="w-full h-80 object-cover" alt="">
                    @endforeach
                </div>
                @if(count($images) > 1)
                <div class="p-3 flex gap-2 overflow-x-auto">
                    @foreach($images as $i => $img)
                    <button type="button" @click="active = {{ $i }}"
                        :class="active === {{ $i }} ? 'ring-2 ring-emerald-500' : 'opacity-60 hover:opacity-100'"
                        class="flex-shrink-0 w-20 h-16 rounded-lg overflow-hidden transition-all">
                        <img src="{{ \App\Helpers\StorageHelper::url($img) }}" class="w-full h-full object-cover" alt="">
                    </button>
                    @endforeach
                </div>
                @endif
            </div>
            @else
            <div class="h-80 flex items-center justify-center bg-zinc-50 dark:bg-zinc-800 text-zinc-400">
                <span class="text-sm">Tidak ada gambar</span>
            </div>
            @endif
        </x-admin.card>

        {{-- Deskripsi --}}
        @if($auction->description)
        <x-admin.card title="Deskripsi">
            <p class="text-sm text-zinc-600 dark:text-zinc-300 leading-relaxed whitespace-pre-line">{{ $auction->description }}</p>
        </x-admin.card>
        @endif

        {{-- Detail Aset --}}
        <x-admin.card title="Detail Aset">
            <dl class="grid grid-cols-2 md:grid-cols-3 gap-x-6 gap-y-4">
                <div>
                    <dt class="text-xs text-zinc-500 dark:text-zinc-400">Tipe Aset</dt>
                    <dd class="mt-0.5 text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ ucfirst($auction->asset_type ?? '-') }}</dd>
                </div>
                @if($auction->building_condition)
                <div>
                    <dt class="text-xs text-zinc-500 dark:text-zinc-400">Kondisi</dt>
                    <dd class="mt-0.5 text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ $auction->building_condition }}</dd>
                </div>
                @endif
                @if($auction->land_area)
                <div>
                    <dt class="text-xs text-zinc-500 dark:text-zinc-400">Luas Tanah</dt>
                    <dd class="mt-0.5 text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ number_format($auction->land_area, 0) }} m²</dd>
                </div>
                @endif
                @if($auction->building_area)
                <div>
                    <dt class="text-xs text-zinc-500 dark:text-zinc-400">Luas Bangunan</dt>
                    <dd class="mt-0.5 text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ number_format($auction->building_area, 0) }} m²</dd>
                </div>
                @endif
                @if($auction->asset_description)
                <div class="col-span-2 md:col-span-3">
                    <dt class="text-xs text-zinc-500 dark:text-zinc-400">Deskripsi Aset</dt>
                    <dd class="mt-1 text-sm text-zinc-600 dark:text-zinc-300 leading-relaxed whitespace-pre-line">{{ $auction->asset_description }}</dd>
                </div>
                @endif
            </dl>
        </x-admin.card>

        {{-- Lokasi --}}
        @if($auction->address || $auction->city || $auction->province)
        <x-admin.card title="Lokasi">
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4.5 h-4.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <p class="text-sm text-zinc-700 dark:text-zinc-300">{{ $auction->address }}</p>
                    <p class="mt-1 text-xs text-zinc-500 dark:text-zinc-400">
                        {{ implode(', ', array_filter([$auction->village, $auction->district, $auction->city, $auction->province, $auction->postal_code])) }}
                    </p>
                </div>
            </div>
        </x-admin.card>
        @endif

        {{-- Sertifikat --}}
        @if($auction->certificate_type || $auction->certificate_number)
        <x-admin.card title="Sertifikat">
            <dl class="grid grid-cols-2 md:grid-cols-4 gap-x-6 gap-y-4">
                @if($auction->certificate_type)
                <div>
                    <dt class="text-xs text-zinc-500 dark:text-zinc-400">Jenis</dt>
                    <dd class="mt-0.5 text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ $auction->certificate_type }}</dd>
                </div>
                @endif
                @if($auction->certificate_number)
                <div>
                    <dt class="text-xs text-zinc-500 dark:text-zinc-400">Nomor</dt>
                    <dd class="mt-0.5 text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ $auction->certificate_number }}</dd>
                </div>
                @endif
            </dl>
        </x-admin.card>
        @endif

        {{-- Info Debitur --}}
        @if($auction->debtor_name)
        <x-admin.card title="Debitur">
            <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ $auction->debtor_name }}</p>
        </x-admin.card>
        @endif

    </div>

    {{-- ═══ KANAN: Sidebar ═══ --}}
    <div class="space-y-6">

        {{-- Status --}}
        <x-admin.card title="Status">
            <div class="flex items-center justify-between">
                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ $statusColor }}">{{ $auction->status_label ?? ucfirst($auction->status) }}</span>
                <span class="text-xs text-zinc-500 dark:text-zinc-400">{{ number_format($auction->view_count) }} dilihat</span>
            </div>
            <div class="mt-4 flex flex-wrap gap-2">
                @if($auction->is_featured)
                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-xs bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 font-medium">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        Unggulan
                    </span>
                @endif
            </div>
            <div class="mt-4 pt-4 border-t border-zinc-100 dark:border-zinc-800 space-y-2">
                <div class="flex justify-between text-xs">
                    <span class="text-zinc-500 dark:text-zinc-400">Dipublikasi</span>
                    <span class="font-medium text-zinc-700 dark:text-zinc-300">{{ $auction->published_at ? \Carbon\Carbon::parse($auction->published_at)->format('d M Y') : '-' }}</span>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-zinc-500 dark:text-zinc-400">Dibuat</span>
                    <span class="font-medium text-zinc-700 dark:text-zinc-300">{{ $auction->created_at?->format('d M Y') }}</span>
                </div>
            </div>
        </x-admin.card>

        {{-- Info Lelang --}}
        <x-admin.card title="Informasi Lelang">
            <dl class="space-y-3">
                <div class="flex items-start gap-3">
                    <svg class="w-4 h-4 text-zinc-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <div>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Tanggal Lelang</p>
                        <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ $auction->auction_date ? \Carbon\Carbon::parse($auction->auction_date)->translatedFormat('l, d M Y') : '-' }}</p>
                        @if($auction->auction_time)
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $auction->auction_time }}</p>
                        @endif
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <svg class="w-4 h-4 text-zinc-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <div>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Lokasi</p>
                        <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ $auction->auction_location ?? '-' }}</p>
                    </div>
                </div>
                <div class="flex items-start gap-3">
                    <svg class="w-4 h-4 text-zinc-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <div>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">Jenis</p>
                        <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ ucwords(str_replace('_', ' ', $auction->auction_type ?? '-')) }}</p>
                    </div>
                </div>
                @if($auction->auction_url)
                <a href="{{ $auction->auction_url }}" target="_blank" class="flex items-center gap-2 text-xs text-emerald-600 hover:text-emerald-700 font-semibold pt-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Buka Link Lelang
                </a>
                @endif
            </dl>
        </x-admin.card>

        {{-- Harga --}}
        <x-admin.card title="Harga">
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-xs text-zinc-500 dark:text-zinc-400">Harga Limit</span>
                    <span class="text-base font-bold text-zinc-900 dark:text-zinc-100">{{ $rupiah($auction->limit_price) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-zinc-500 dark:text-zinc-400">Uang Jaminan</span>
                    <span class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">{{ $rupiah($auction->deposit_amount) }}</span>
                </div>
            </div>
        </x-admin.card>

        {{-- Kontak --}}
        @if($auction->contact_name || $auction->contact_phone || $auction->contact_email)
        <x-admin.card title="Kontak">
            <div class="space-y-3 text-sm">
                @if($auction->contact_name)
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <span class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $auction->contact_name }}</span>
                </div>
                @endif
                @if($auction->contact_phone)
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 text-zinc-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                    <span class="text-zinc-700 dark:text-zinc-300">{{ $auction->contact_phone }}</span>
                </div>
                @endif
                @if($auction->contact_email)
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4 text-zinc-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span class="text-zinc-700 dark:text-zinc-300">{{ $auction->contact_email }}</span>
                </div>
                @endif
            </div>
        </x-admin.card>
        @endif

    </div>
</div>
@endsection
