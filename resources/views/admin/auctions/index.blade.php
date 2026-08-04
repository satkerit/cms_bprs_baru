@extends('layouts.admin')

@section('title', 'Lelang Agunan')

@section('content')
<x-admin.page-header title="Lelang Agunan" subtitle="Kelola data lelang agunan">
    <x-slot:actions>
        <x-admin.button href="{{ route('admin.auctions.create') }}" icon='<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>'>
            Tambah Lelang
        </x-admin.button>
    </x-slot:actions>
</x-admin.page-header>

@if(session('success'))
    <x-admin.alert type="success" title="Berhasil!" class="mb-5">{{ session('success') }}</x-admin.alert>
@endif
@if(session('error'))
    <x-admin.alert type="error" title="Gagal!" class="mb-5">{{ session('error') }}</x-admin.alert>
@endif

{{-- Stats --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white dark:bg-zinc-800 rounded-2xl p-4 border border-zinc-200 dark:border-zinc-700 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-zinc-100 dark:bg-zinc-700 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ $stats['total'] }}</p>
            <p class="text-xs text-zinc-500 dark:text-zinc-400">Total Lelang</p>
        </div>
    </div>
    <div class="bg-white dark:bg-zinc-800 rounded-2xl p-4 border border-zinc-200 dark:border-zinc-700 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ $stats['registration_open'] }}</p>
            <p class="text-xs text-zinc-500 dark:text-zinc-400">Pendaftaran Dibuka</p>
        </div>
    </div>
    <div class="bg-white dark:bg-zinc-800 rounded-2xl p-4 border border-zinc-200 dark:border-zinc-700 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ $stats['sold'] }}</p>
            <p class="text-xs text-zinc-500 dark:text-zinc-400">Terjual</p>
        </div>
    </div>
    <div class="bg-white dark:bg-zinc-800 rounded-2xl p-4 border border-zinc-200 dark:border-zinc-700 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-zinc-100 dark:bg-zinc-700 flex items-center justify-center flex-shrink-0">
            <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        </div>
        <div>
            <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ $stats['draft'] }}</p>
            <p class="text-xs text-zinc-500 dark:text-zinc-400">Draft</p>
        </div>
    </div>
</div>

{{-- Filter --}}
<x-admin.card class="mb-5">
    <form method="GET" class="flex flex-col sm:flex-row gap-3">
        <div class="flex-1">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari judul, nomor lelang, kota, debitur..."
                class="w-full rounded-xl border border-zinc-300 dark:border-zinc-600 px-4 py-2.5 text-sm bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-emerald-500">
        </div>
        <div>
            <select name="status" class="w-full rounded-xl border border-zinc-300 dark:border-zinc-600 px-4 py-2.5 text-sm bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <option value="">Semua Status</option>
                @foreach(\App\Enums\AuctionStatus::cases() as $s)
                    <option value="{{ $s->value }}" @selected(request('status') === $s->value)>{{ $s->label() }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <select name="asset_type" class="w-full rounded-xl border border-zinc-300 dark:border-zinc-600 px-4 py-2.5 text-sm bg-white dark:bg-zinc-800 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                <option value="">Semua Tipe Aset</option>
                @foreach(['tanah','rumah','ruko','apartemen','gedung','pabrik','kendaraan','mesin','lainnya'] as $type)
                    <option value="{{ $type }}" @selected(request('asset_type') === $type)>{{ ucfirst($type) }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            Filter
        </button>
        @if(request()->hasAny(['search','status','asset_type']))
            <a href="{{ route('admin.auctions.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-zinc-300 dark:border-zinc-600 text-zinc-600 dark:text-zinc-400 text-sm font-semibold hover:bg-zinc-50 dark:hover:bg-zinc-700 transition-colors">
                Reset
            </a>
        @endif
    </form>
</x-admin.card>

{{-- Table --}}
<x-admin.card :noPadding="true">
    <x-admin.table :headers="['Aset', 'Tipe & Lokasi', 'Harga Limit', 'Tgl Lelang', 'Status', 'Aksi']">
        @forelse($auctions as $item)
        @php
            $statusEnum = \App\Enums\AuctionStatus::tryFrom($item->status ?? '');
            $colorMap = ['zinc'=>'bg-zinc-100 text-zinc-700 dark:bg-zinc-700 dark:text-zinc-300','blue'=>'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400','emerald'=>'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400','amber'=>'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400','purple'=>'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400','red'=>'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'];
            $badgeClass = $colorMap[$statusEnum?->color() ?? 'zinc'] ?? $colorMap['zinc'];
        @endphp
        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-700/40 transition-colors">
            <td class="px-6 py-4">
                <div class="flex items-center gap-3">
                    @if(!empty($item->images[0]))
                        <img src="{{ \App\Helpers\StorageHelper::url($item->images[0]) }}" alt="{{ $item->title }}" class="w-12 h-12 rounded-xl object-cover flex-shrink-0 bg-zinc-100 dark:bg-zinc-700 ring-1 ring-zinc-200/60">
                    @else
                        <div class="w-12 h-12 rounded-xl bg-zinc-100 dark:bg-zinc-700 ring-1 ring-zinc-200/60 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                    <div>
                        <p class="font-semibold text-sm text-zinc-900 dark:text-zinc-100 line-clamp-1">{{ $item->title }}</p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">{{ $item->auction_number }}</p>
                        @if($item->is_featured)
                            <span class="inline-flex items-center gap-1 mt-1 px-1.5 py-0.5 rounded text-xs bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 font-medium">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                Unggulan
                            </span>
                        @endif
                    </div>
                </div>
            </td>
            <td class="px-6 py-4">
                <p class="text-sm font-medium text-zinc-800 dark:text-zinc-200">{{ ucfirst($item->asset_type ?? '-') }}</p>
                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                    {{ implode(', ', array_filter([$item->city, $item->province])) ?: '-' }}
                </p>
            </td>
            <td class="px-6 py-4">
                <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                    @if($item->limit_price)
                        Rp {{ number_format($item->limit_price, 0, ',', '.') }}
                    @else
                        <span class="text-zinc-400">-</span>
                    @endif
                </p>
            </td>
            <td class="px-6 py-4">
                <p class="text-sm text-zinc-700 dark:text-zinc-300">
                    {{ $item->auction_date ? \Carbon\Carbon::parse($item->auction_date)->format('d M Y') : '-' }}
                </p>
                @if($item->auction_time)
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $item->auction_time }}</p>
                @endif
            </td>
            <td class="px-6 py-4">
                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold {{ $badgeClass }}">
                    {{ $statusEnum?->label() ?? ucfirst($item->status ?? '-') }}
                </span>
            </td>
            <td class="px-6 py-4">
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.auctions.show', $item) }}" title="Detail"
                        class="p-1.5 rounded-lg text-zinc-500 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </a>
                    <a href="{{ route('admin.auctions.edit', $item) }}" title="Edit"
                        class="p-1.5 rounded-lg text-zinc-500 hover:text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </a>
                    <button type="button" title="Hapus"
                        data-open-modal="deleteAuction{{ $item->id }}"
                        data-title="Hapus Lelang"
                        data-text="Apakah Anda yakin ingin menghapus lelang ini? Semua gambar juga akan dihapus dan tidak dapat dikembalikan."
                        data-action="{{ route('admin.auctions.destroy', $item) }}"
                        data-confirm="Ya, hapus!"
                        class="p-1.5 rounded-lg text-zinc-500 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6">
                <x-admin.empty-state
                    icon="document"
                    title="Belum ada data lelang"
                    description="Klik tombol 'Tambah Lelang' untuk menambahkan lelang baru."
                />
            </td>
        </tr>
        @endforelse
    </x-admin.table>

    {{-- Delete Modals --}}
    @foreach($auctions as $item)
        <x-admin.delete-modal
            id="deleteAuction{{ $item->id }}"
            title="Hapus Lelang"
            message="Apakah Anda yakin ingin menghapus lelang ini? Semua gambar juga akan dihapus dan tidak dapat dikembalikan."
            action="{{ route('admin.auctions.destroy', $item) }}"
        />
    @endforeach

    @if($auctions->hasPages())
        <div class="p-5 border-t border-zinc-200/60 dark:border-zinc-700 bg-zinc-50/30 dark:bg-zinc-800/30">
            {{ $auctions->links() }}
        </div>
    @endif
</x-admin.card>
@endsection
