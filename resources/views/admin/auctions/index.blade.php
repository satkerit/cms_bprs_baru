@extends('layouts.admin')

@section('title', 'Kelola Lelang Agunan')

@section('content')
<x-admin.page-header title="Kelola Lelang Agunan" subtitle="Daftar semua lelang agunan yang tersedia">
    <x-slot:actions>
        <x-admin.button href="{{ route('admin.auctions.create') }}" icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>'>
            Tambah Lelang Agunan
        </x-admin.button>
    </x-slot:actions>
</x-admin.page-header>

@if(session('success'))
    <x-admin.alert type="success" title="Berhasil!" class="mb-5">
        {{ session('success') }}
    </x-admin.alert>
@endif

@if(session('error'))
    <x-admin.alert type="error" title="Gagal!" class="mb-5">
        {{ session('error') }}
    </x-admin.alert>
@endif

<x-admin.card :noPadding="true">
    {{-- Filter Section --}}
    <div class="p-5 border-b border-slate-200/60 bg-gradient-to-r from-slate-50/80 to-white">
        <form method="GET" class="flex flex-col sm:flex-row gap-3">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 dark:text-slate-500 dark:text-slate-500 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Cari judul, nomor lelang, alamat..."
                       class="w-full pl-10 rounded-xl border border-slate-200 py-2.5 px-4 text-sm text-slate-900 bg-white shadow-sm placeholder:text-slate-400 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all duration-200">
            </div>
            <div class="flex flex-wrap gap-3">
                <select name="status"
                        class="rounded-xl border border-slate-200 py-2.5 pl-4 pr-10 text-sm text-slate-900 bg-white shadow-sm appearance-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all duration-200">
                    <option value="">Semua Status</option>
                    @foreach(\App\Enums\AuctionStatus::cases() as $status)
                        <option value="{{ $status->value }}" {{ request('status') === $status->value ? 'selected' : '' }}>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>
                <select name="asset_type"
                        class="rounded-xl border border-slate-200 py-2.5 pl-4 pr-10 text-sm text-slate-900 bg-white shadow-sm appearance-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all duration-200">
                    <option value="">Semua Jenis</option>
                    @foreach(\App\Enums\AssetType::cases() as $assetType)
                        <option value="{{ $assetType->value }}" {{ request('asset_type') === $assetType->value ? 'selected' : '' }}>
                            {{ $assetType->label() }}
                        </option>
                    @endforeach
                </select>
                <input type="text" name="city" value="{{ request('city') }}"
                       placeholder="Kota..."
                       class="rounded-xl border border-slate-200 py-2.5 px-4 text-sm text-slate-900 bg-white shadow-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all duration-200 w-32">
                <x-admin.button type="submit" variant="secondary">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    Filter
                </x-admin.button>
                @if(request('search') || request('status') || request('asset_type') || request('city'))
                    <a href="{{ route('admin.auctions.index') }}"
                       class="inline-flex items-center px-4 py-2.5 text-sm font-medium text-slate-600 bg-white rounded-xl border border-slate-200 hover:bg-slate-50 transition-colors no-underline">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Mobile Card View --}}
    <div class="block md:hidden p-4 space-y-4">
        @forelse($auctions as $auction)
            <div class="bg-white border border-slate-200/60 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-200">
                {{-- Image --}}
                <div class="relative h-40 bg-slate-100">
                    @if($auction->images && is_array($auction->images) && count($auction->images) > 0)
                        <img src="{{ \App\Helpers\StorageHelper::url($auction->images[0]) }}" alt="{{ $auction->title }}" class="w-full h-full object-cover" loading="lazy">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    @endif
                    {{-- Status Badge --}}
                    <div class="absolute top-3 right-3">
                        @php
                            $statusVariant = match($auction->status) {
                                'upcoming', 'scheduled' => 'info',
                                'active', 'published' => 'success',
                                'completed', 'sold', 'awarded' => 'default',
                                'cancelled', 'failed', 'batal' => 'destructive',
                                default => 'secondary'
                            };
                        @endphp
                        <x-admin.badge :variant="$statusVariant">{{ $auction->status_label }}</x-admin.badge>
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-4">
                    <div class="flex items-start justify-between gap-3 mb-2">
                        <h3 class="font-bold text-slate-900 line-clamp-1">{{ $auction->title }}</h3>
                    </div>
                    <div class="flex items-center gap-2 mb-2">
                        <x-admin.badge>{{ \App\Enums\AssetType::tryFrom($auction->asset_type)?->label() ?? $auction->asset_type }}</x-admin.badge>
                        <span class="text-[11px] text-slate-400">{{ $auction->auction_number }}</span>
                    </div>
                    <p class="text-[13px] text-slate-500 line-clamp-2 mb-3">{{ Str::limit($auction->description ?? 'Tidak ada deskripsi', 80) }}</p>
                    <div class="flex items-center justify-between mb-3">
                        <span class="font-bold text-emerald-700 tabular-nums">{{ $auction->formatted_limit_price }}</span>
                        <span class="text-[12px] text-slate-400 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $auction->city ?? '-' }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2 text-[11px] text-slate-400 mb-3">
                        @if($auction->auction_date)
                        <span class="flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $auction->auction_date->format('d M Y') }}
                        </span>
                        @endif
                    </div>

                    {{-- Actions --}}
                    <div class="grid grid-cols-2 gap-3 pt-3 border-t border-slate-100">
                        <a href="{{ route('admin.auctions.edit', $auction) }}"
                           class="btn-outline text-xs !py-2.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit
                        </a>
                        <button type="button"
                                data-auction-id="{{ $auction->id }}"
                                data-auction-title="{{ $auction->title }}"
                                data-open-modal="deleteAuction{{ $auction->id }}"
                                class="btn-destructive text-xs !py-2.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <x-admin.empty-state
                icon="inbox"
                title="Belum Ada Lelang Agunan"
                description="Mulai tambahkan lelang agunan pertama"
                actionUrl="{{ route('admin.auctions.create') }}"
                actionLabel="Tambah Lelang Agunan"
            />
        @endforelse
    </div>

    {{-- Desktop Table View --}}
    <div class="hidden md:block">
        <x-admin.table :headers="['Lelang', 'Jenis', 'Status', 'Harga Limit', 'Tanggal', 'Aksi']">
            @forelse($auctions as $auction)
                <tr>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-4">
                            @if($auction->images && is_array($auction->images) && count($auction->images) > 0)
                                <img src="{{ \App\Helpers\StorageHelper::url($auction->images[0]) }}" alt=""
                                     class="w-14 h-14 rounded-xl object-cover bg-slate-100 ring-1 ring-slate-200/60 flex-shrink-0 transition-all duration-300"
                                     loading="lazy">
                            @else
                                <div class="w-14 h-14 rounded-xl bg-slate-100 ring-1 ring-slate-200/60 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="min-w-0">
                                <div class="font-semibold text-slate-900 truncate max-w-[280px]">{{ $auction->title }}</div>
                                <div class="text-[12px] text-slate-500 mt-0.5">
                                    <span class="font-mono">{{ $auction->auction_number }}</span>
                                    @if($auction->city)
                                        <span class="mx-1.5">•</span>
                                        <span>{{ $auction->city }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <x-admin.badge>{{ \App\Enums\AssetType::tryFrom($auction->asset_type)?->label() ?? $auction->asset_type }}</x-admin.badge>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $statusVariant = match($auction->status) {
                                'upcoming', 'scheduled' => 'info',
                                'active', 'published' => 'success',
                                'completed', 'sold', 'awarded' => 'default',
                                'cancelled', 'failed', 'batal' => 'destructive',
                                default => 'secondary'
                            };
                        @endphp
                        <x-admin.badge :variant="$statusVariant">{{ $auction->status_label }}</x-admin.badge>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-slate-900 tabular-nums">
                        {{ $auction->formatted_limit_price }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-[13px] text-slate-500">
                        @if($auction->auction_date)
                            {{ $auction->auction_date->format('d M Y') }}
                        @else
                            <span class="text-slate-400">Belum ditentukan</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-1">
                            <a href="{{ route('admin.auctions.show', $auction) }}"
                               class="table-action-btn" title="Lihat Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <a href="{{ route('admin.auctions.edit', $auction) }}"
                               class="table-action-btn" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <button type="button"
                                    data-open-modal="deleteAuction{{ $auction->id }}"
                                    class="table-action-btn-danger" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        <x-admin.empty-state
                            icon="inbox"
                            title="Belum ada lelang agunan"
                            description="Klik tombol 'Tambah Lelang Agunan' untuk memulai."
                        />
                    </td>
                </tr>
            @endforelse
        </x-admin.table>
    </div>

    {{-- Shared Delete Modals (rendered once, used by both mobile & desktop) --}}
    @if($auctions->count())
        @foreach($auctions as $auction)
            <x-admin.delete-modal
                id="deleteAuction{{ $auction->id }}"
                title="Hapus Lelang Agunan"
                :message="'Apakah Anda yakin ingin menghapus lelang ' . json_encode($auction->title) . '? Data yang dihapus tidak dapat dikembalikan.'"
                action="{{ route('admin.auctions.destroy', $auction) }}"
            />
        @endforeach
    @endif

    {{-- Pagination --}}
    @if(method_exists($auctions, 'hasPages') && $auctions->hasPages())
        <div class="p-5 border-t border-slate-200/60 bg-slate-50/30">
            {{ $auctions->links() }}
        </div>
    @endif
</x-admin.card>
@endsection
