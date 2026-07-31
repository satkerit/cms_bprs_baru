@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="flex flex-col gap-6">

    {{-- Welcome Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-2">
        <div>
            <div class="flex items-center gap-3">
                <div class="w-1 h-8 rounded-full bg-gradient-to-b from-emerald-500 to-emerald-600 shrink-0"></div>
                <div>
                    <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-slate-100">Dashboard</h1>
                    <p class="text-slate-500 dark:text-slate-400 text-[13px] mt-0.5">
                        {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                    </p>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <form method="POST" action="{{ route('admin.cache.clear') }}">
                @csrf
                <button type="submit"
                    class="btn-secondary h-9 text-xs"
                    onclick="return confirm('Bersihkan semua cache?')">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    Clear Cache
                </button>
            </form>
            <form method="POST" action="{{ route('admin.cache.hard-refresh') }}">
                @csrf
                <button type="submit"
                    class="inline-flex items-center gap-1.5 h-9 px-3 rounded-lg text-xs font-medium bg-emerald-600 hover:bg-emerald-700 text-white transition-colors"
                    onclick="return confirm('Jalankan hard refresh? Ini akan me-rebuild config cache untuk production.')">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Hard Refresh
                </button>
            </form>
        </div>
    </div>

    {{-- ═══ QUICK STATS — Emerald + Gold Bento Grid ═══ --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <a href="{{ route('admin.news.index') }}"
           class="stat-card-emerald group hover:-translate-y-0.5 no-underline block">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-[11px] font-semibold text-emerald-600/70 uppercase tracking-wider mb-1">Total Berita</p>                            <p class="text-3xl font-bold tabular-nums tracking-tight text-slate-900 dark:text-slate-100">{{ $newsCount }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-100/80 flex items-center justify-center text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white group-hover:scale-110 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </div>
            </div>
            <div class="pt-3 border-t border-emerald-200/40 text-[12px] text-emerald-600/60 group-hover:text-emerald-700 flex items-center justify-between">
                <span class="font-medium">Kelola berita</span>
                <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </div>
        </a>

        <a href="{{ route('admin.products.index') }}"
           class="stat-card-sky group hover:-translate-y-0.5 no-underline block">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-[11px] font-semibold text-sky-600/70 uppercase tracking-wider mb-1">Total Produk</p>                            <p class="text-3xl font-bold tabular-nums tracking-tight text-slate-900 dark:text-slate-100">{{ $productCount }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-sky-100/80 flex items-center justify-center text-sky-600 group-hover:bg-sky-600 group-hover:text-white group-hover:scale-110 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
            </div>
            <div class="pt-3 border-t border-sky-200/40 text-[12px] text-sky-600/60 group-hover:text-sky-700 flex items-center justify-between">
                <span class="font-medium">Kelola produk</span>
                <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </div>
        </a>

        <a href="{{ route('admin.auctions.index') }}"
           class="stat-card-gold group hover:-translate-y-0.5 no-underline block">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-[11px] font-semibold text-amber-600/70 uppercase tracking-wider mb-1">Lelang Aktif</p>                            <p class="text-3xl font-bold tabular-nums tracking-tight text-slate-900 dark:text-slate-100">{{ $upcomingAuctions }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-100/80 flex items-center justify-center text-amber-600 group-hover:bg-amber-600 group-hover:text-white group-hover:scale-110 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="pt-3 border-t border-amber-200/40 text-[12px] text-amber-600/60 group-hover:text-amber-700 flex items-center justify-between">
                <span class="font-medium">Kelola lelang</span>
                <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </div>
        </a>

        <a href="{{ route('admin.complaints.index') }}"
           class="stat-card group hover:-translate-y-0.5 no-underline block bg-gradient-to-br from-red-50 dark:from-red-950/40 to-white dark:to-slate-900 border-red-200/50 dark:border-red-900/50 hover:shadow-lg hover:shadow-red-500/5">
            <div class="flex items-start justify-between mb-4">
                <div>
                    <p class="text-[11px] font-semibold text-red-600/70 uppercase tracking-wider mb-1">Aduan Baru</p>                            <p class="text-3xl font-bold tabular-nums tracking-tight text-slate-900 dark:text-slate-100">{{ $pendingComplaints }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-red-100/80 flex items-center justify-center text-red-600 group-hover:bg-red-600 group-hover:text-white group-hover:scale-110 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
            </div>
            <div class="pt-3 border-t border-red-200/40 text-[12px] flex items-center justify-between">
                @if($pendingComplaints > 0)
                <span class="font-medium text-red-600 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                    Perlu tindakan
                </span>
                @else
                <span class="text-red-600/60">Semua tertangani</span>
                @endif
                <svg class="w-3.5 h-3.5 text-red-400/60 group-hover:text-red-500 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </div>
        </a>
    </div>

    {{-- ═══ VISITOR STATISTICS CHART ═══ --}}
    <div class="card">
        <div class="card-header flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="admin-accent-strip"></div>
                    <div>
                        <h2 class="text-[15px] font-semibold text-slate-900 dark:text-slate-100 tracking-tight">Statistik Pengunjung</h2>
                        <p class="text-[12px] text-slate-400 dark:text-slate-500">7 hari terakhir</p>
                </div>
            </div>
            <a href="{{ route('admin.visitor-stats.index') }}" class="btn-outline h-8 text-xs">
                Lihat Detail
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        <div class="card-body">
            {{-- Mini Stats --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 mb-6">
                <div class="stat-card-emerald">
                    <p class="text-[10px] font-semibold text-emerald-600 mb-1 uppercase tracking-wider">Hari Ini</p>
                    <p class="text-lg font-bold text-slate-900 dark:text-slate-100 tabular-nums">{{ number_format($visitorStats['todayVisits']) }}</p>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500">kunjungan</p>
                </div>
                <div class="stat-card-sky">
                    <p class="text-[10px] font-semibold text-sky-600 mb-1 uppercase tracking-wider">Unik Hari Ini</p>
                    <p class="text-lg font-bold text-slate-900 dark:text-slate-100 tabular-nums">{{ number_format($visitorStats['todayUnique']) }}</p>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500">pengunjung</p>
                </div>
                <div class="stat-card-emerald">
                    <p class="text-[10px] font-semibold text-emerald-600 mb-1 uppercase tracking-wider">7 Hari</p>
                    <p class="text-lg font-bold text-slate-900 dark:text-slate-100 tabular-nums">{{ number_format($visitorStats['weekTotal']) }}</p>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500">kunjungan</p>
                </div>
                <div class="stat-card-violet">
                    <p class="text-[10px] font-semibold text-violet-600 mb-1 uppercase tracking-wider">Unik 7 Hari</p>
                    <p class="text-lg font-bold text-slate-900 dark:text-slate-100 tabular-nums">{{ number_format($visitorStats['weekUnique']) }}</p>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500">pengunjung</p>
                </div>
            </div>

            {{-- Chart --}}
            <div class="relative h-64">
                <canvas id="visitorChart"></canvas>
            </div>
        </div>
    </div>

    {{-- ═══ RECENT ACTIVITY — Two Column Grid ═══ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Recent News --}}
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="admin-accent-strip"></div>
                    <h3 class="text-[15px] font-semibold text-slate-900 dark:text-slate-100 tracking-tight">Berita Terbaru</h3>
                </div>
                <a href="{{ route('admin.news.index') }}" class="text-[12px] font-medium text-emerald-600 hover:text-emerald-700 transition-colors">Lihat Semua</a>
            </div>                        <div class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($recentNews as $news)
                    <div class="px-6 py-4 flex items-center gap-3 hover:bg-slate-50/50 transition-colors duration-150 group">
                        @if($news->featured_image && \Illuminate\Support\Facades\Storage::disk('public')->exists($news->featured_image))
                            <img src="{{ \App\Helpers\StorageHelper::url($news->featured_image) }}"
                                 alt="{{ $news->title }}"
                                 class="w-12 h-10 rounded-xl object-cover border border-slate-200 flex-shrink-0 group-hover:shadow-md transition-shadow"
                                 data-fallback="news-thumbnail">
                        @else                                <div class="w-12 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center flex-shrink-0">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('admin.news.edit', $news) }}" class="text-[13px] font-medium text-slate-900 dark:text-slate-200 hover:text-emerald-600 truncate block transition-colors no-underline">{{ $news->title }}</a>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-[11px] text-slate-400 dark:text-slate-500 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    {{ $news->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                        @if($news->is_published)
                            <x-admin.badge variant="success">Published</x-admin.badge>
                        @else
                            <x-admin.badge variant="secondary">Draft</x-admin.badge>
                        @endif
                    </div>
                @empty
                    <div class="py-12 px-6 text-center text-[13px] text-slate-500">
                        <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                        </div>
                        <p class="text-[13px] text-slate-500">Belum ada berita</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Recent Complaints --}}
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="admin-accent-strip"></div>
                    <h3 class="text-[15px] font-semibold text-slate-900 tracking-tight">Pengaduan Terbaru</h3>
                </div>
                <a href="{{ route('admin.complaints.index') }}" class="text-[12px] font-medium text-emerald-600 hover:text-emerald-700 transition-colors">Lihat Semua</a>
            </div>                        <div class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse($recentComplaints as $complaint)
                    <a href="{{ route('admin.complaints.show', $complaint) }}" class="block px-6 py-4 no-underline text-inherit hover:bg-slate-50/50 transition-colors duration-150 group">
                        <div class="flex items-center gap-3">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-[10px] font-mono font-medium text-slate-500 bg-slate-100 px-1.5 py-0.5 rounded-md border border-slate-200/60">{{ $complaint->ticket_number }}</span>
                                    <span class="text-[13px] font-medium text-slate-900 truncate group-hover:text-emerald-600 transition-colors duration-150">{{ $complaint->subject }}</span>
                                </div>
                                <p class="text-[12px] text-slate-400 truncate">{{ Str::limit($complaint->description, 60) }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                @switch($complaint->status)
                                    @case('pending')
                                        <x-admin.badge variant="warning">Menunggu</x-admin.badge>
                                        @break
                                    @case('in_review')
                                    @case('investigating')
                                        <x-admin.badge variant="info">Review</x-admin.badge>
                                        @break
                                    @case('resolved')
                                        <x-admin.badge variant="success">Selesai</x-admin.badge>
                                        @break
                                    @default
                                        <x-admin.badge variant="secondary">{{ $complaint->status }}</x-admin.badge>
                                @endswitch
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="py-12 px-6 text-center text-[13px] text-slate-500">
                        <div class="w-14 h-14 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <p class="font-medium text-slate-900 mb-1">Belum Ada Pengaduan</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- ═══ ACCOUNT INFO ═══ --}}
    <div class="card">
        <div class="card-header">
            <div class="flex items-center gap-2.5">
                <div class="admin-accent-strip"></div>
                <h2 class="text-[15px] font-semibold text-slate-900 tracking-tight">Informasi Akun</h2>
            </div>
        </div>
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex items-start gap-4 p-4 rounded-xl bg-gradient-to-br from-emerald-50 to-white border border-emerald-200/50">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] font-semibold uppercase text-emerald-600 tracking-wider mb-0.5">Email Saat Ini</p>
                        <p class="text-[13px] font-medium text-slate-900 truncate">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-4 p-4 rounded-xl bg-gradient-to-br from-sky-50 to-white border border-sky-200/50">
                    <div class="w-10 h-10 rounded-xl bg-sky-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] font-semibold uppercase text-sky-600 tracking-wider mb-0.5">Peran Akses</p>
                        <p class="text-[13px] font-medium text-slate-900 truncate">{{ auth()->user()->roleModel?->display_name ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-4 p-4 rounded-xl bg-gradient-to-br from-violet-50 to-white border border-violet-200/50">
                    <div class="w-10 h-10 rounded-xl bg-violet-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] font-semibold uppercase text-violet-600 tracking-wider mb-0.5">Status Akun</p>
                        <x-admin.badge variant="success">Aktif</x-admin.badge>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js" crossorigin="anonymous" referrerpolicy="no-referrer" nonce="{{ $nonce }}"></script>
<script nonce="{{ $nonce }}">
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('img[data-fallback="news-thumbnail"]').forEach(function(img) {
        img.addEventListener('error', function() {
            this.parentElement.innerHTML = '<div class="w-12 h-10 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center flex-shrink-0"><svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>';
        });
        if (img.complete && img.naturalWidth === 0) {
            img.parentElement.innerHTML = '<div class="w-12 h-10 rounded-xl bg-slate-100 border border-slate-200 flex items-center justify-center flex-shrink-0"><svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></div>';
        }
    });

    const canvas = document.getElementById('visitorChart');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');

    function isDark() {
        return document.documentElement.classList.contains('dark');
    }

    function getChartColors() {
        const dark = isDark();
        return {
            gridColor: dark ? 'rgba(51, 65, 85, 0.5)' : 'rgba(226, 232, 240, 0.6)',
            tickColor: dark ? '#94a3b8' : '#64748b',
            legendColor: dark ? '#cbd5e1' : '#334155',
        };
    }

    function getChartOptions() {
        const c = getChartColors();
        return {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { intersect: false, mode: 'index' },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: { size: 12, weight: '500' },
                        color: c.legendColor,
                    }
                },
                tooltip: {
                    backgroundColor: isDark() ? '#1e293b' : '#18181b',
                    titleFont: { size: 13, weight: '600' },
                    bodyFont: { size: 12 },
                    padding: 12,
                    cornerRadius: 10,
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: { font: { size: 11 }, color: c.tickColor }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: c.gridColor },
                    ticks: { font: { size: 11 }, color: c.tickColor, stepSize: 1, padding: 8 }
                }
            }
        };
    }

    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: @js($visitorStats['labels']),
            datasets: [
                {
                    label: 'Total Kunjungan',
                    data: @js($visitorStats['totalVisits']),
                    borderColor: '#059669',
                    backgroundColor: 'rgba(5, 150, 105, 0.08)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2.5,
                    pointBackgroundColor: '#059669',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 7,
                },
                {
                    label: 'Pengunjung Unik',
                    data: @js($visitorStats['uniqueVisitors']),
                    borderColor: '#d97706',
                    backgroundColor: 'rgba(217, 119, 6, 0.06)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2.5,
                    borderDash: [5, 5],
                    pointBackgroundColor: '#d97706',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 7,
                }
            ]
        },
        options: getChartOptions()
    });

    // Watch for dark mode toggle — update chart reactively
    const observer = new MutationObserver(function() {
        chart.options = getChartOptions();
        chart.update();
    });
    observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });
});
</script>
@endpush
