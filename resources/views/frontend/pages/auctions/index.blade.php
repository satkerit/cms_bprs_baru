<x-frontend-layout>
    <x-slot:title>Lelang Agunan - {{ config('app.name') }}</x-slot:title>
    <x-slot:metaDescription>Informasi lelang agunan BPRS Bangka Belitung. Temukan tanah, rumah, ruko, dan aset lainnya yang siap dilelang.</x-slot:metaDescription>

    @php
        $assetTypes = ['tanah' => 'Tanah', 'rumah' => 'Rumah Tinggal', 'ruko' => 'Ruko/Rukan', 'apartemen' => 'Apartemen', 'gedung' => 'Gedung', 'kendaraan' => 'Kendaraan'];
        $statusLabels = [
            'published' => 'Diumumkan',
            'registration_open' => 'Akan Datang',
            'registration_closed' => 'Selesai Lelang',
            'sold' => 'Terjual',
        ];
        $statusColorMap = [
            'published' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300',
            'registration_open' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300',
            'registration_closed' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300',
            'sold' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300',
        ];
    @endphp

    {{-- ═══ HERO — Ethereal Glass ═══ --}}
    <section class="relative pt-8 sm:pt-10 md:pt-12 pb-20 sm:pb-24 md:pb-28 overflow-hidden">
        <div class="absolute inset-0 hero-gradient">
            <div class="absolute inset-0 bg-grid-pattern opacity-30"></div>
            <div class="absolute top-10 left-1/4 w-80 h-80 bg-emerald-400/20 rounded-full blur-3xl animate-float-slow"></div>
            <div class="absolute bottom-10 right-1/4 w-96 h-96 bg-emerald-400/20 rounded-full blur-3xl animate-float-slow" style="animation-delay: 3s;"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="eyebrow-badge mb-5 inline-flex bg-white/20 text-white border-white/20">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Investasi & Aset
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-white mb-4 sm:mb-6 tracking-tight leading-tight">Lelang Agunan</h1>
            <p class="text-base sm:text-lg md:text-xl text-white/80 w-full px-4 leading-relaxed">
                Temukan kesempatan memiliki aset berkualitas — tanah, rumah, ruko, dan properti lainnya.
            </p>
        </div>
    </section>

    {{-- ═══ STATS ═══ --}}
    @if(isset($stats) && $stats['total'] > 0)
    <section class="relative z-10 -mt-8 sm:-mt-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="double-bezel">
                <div class="double-bezel-inner grid grid-cols-3 divide-x divide-border/60 dark:divide-slate-700/50">
                    <div class="py-4 sm:py-5 text-center">
                        <p class="text-2xl sm:text-3xl font-bold text-emerald-600">{{ number_format($stats['total']) }}</p>
                        <p class="text-[11px] sm:text-xs text-secondary dark:text-slate-400 font-medium mt-0.5">Total Ditampilkan</p>
                    </div>
                    <div class="py-4 sm:py-5 text-center">
                        <p class="text-2xl sm:text-3xl font-bold text-emerald-600">{{ number_format($stats['registration_open']) }}</p>
                        <p class="text-[11px] sm:text-xs text-secondary dark:text-slate-400 font-medium mt-0.5">Akan Datang</p>
                    </div>
                    <div class="py-4 sm:py-5 text-center">
                        <p class="text-2xl sm:text-3xl font-bold text-emerald-600">{{ number_format($stats['sold']) }}</p>
                        <p class="text-[11px] sm:text-xs text-secondary dark:text-slate-400 font-medium mt-0.5">Telah Terjual</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ SEARCH & FILTER ═══ --}}
    <section class="py-12 lg:py-16 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="reveal-up" x-intersect="$el.classList.add('is-visible')">
                <div class="double-bezel">
                    <div class="double-bezel-inner p-4 sm:p-6 lg:p-8">
                        <form method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-3 sm:gap-4 items-end">
                            <div class="md:col-span-5">
                                <label class="block text-xs font-medium text-secondary dark:text-slate-400 mb-1.5">Cari Aset</label>
                                <div class="relative">
                                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 text-secondary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Judul, kota, atau debitur..." class="w-full pl-11 pr-4 py-3 rounded-full border border-border bg-white dark:bg-slate-800/90 text-foreground text-sm placeholder:text-secondary dark:placeholder:text-slate-500 hover:border-emerald-200 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition-all duration-200">
                                </div>
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-secondary dark:text-slate-400 mb-1.5">Tipe Aset</label>
                                <select name="asset_type" class="w-full px-4 py-3 rounded-full border border-border bg-white dark:bg-slate-800/90 text-foreground text-sm hover:border-emerald-200 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition-all duration-200 appearance-none">
                                    <option value="">Semua Tipe</option>
                                    @foreach($assetTypes as $val => $label)
                                    <option value="{{ $val }}" {{ request('asset_type') == $val ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-secondary dark:text-slate-400 mb-1.5">Status</label>
                                <select name="status" class="w-full px-4 py-3 rounded-full border border-border bg-white dark:bg-slate-800/90 text-foreground text-sm hover:border-emerald-200 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition-all duration-200 appearance-none">
                                    <option value="">Semua Status</option>
                                    @foreach($statusLabels as $statusKey => $statusLabel)
                                    <option value="{{ $statusKey }}" {{ request('status') == $statusKey ? 'selected' : '' }}>{{ $statusLabel }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="md:col-span-1">
                                <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-full bg-emerald-600 text-white font-bold shadow-lg shadow-emerald-500/15 hover:bg-emerald-700 hover:shadow-emerald-500/25 transition-all duration-500 ease-[cubic-bezier(0.32,0.72,0,1)] active:scale-[0.98] text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                    <span class="md:hidden">Cari</span>
                                </button>
                            </div>
                        </form>

                        @if(request('search') || request('status') || request('asset_type'))
                        <div class="flex flex-wrap items-center gap-2 pt-4 mt-4 border-t border-border/50 dark:border-slate-700/50">
                            <span class="text-xs text-secondary dark:text-slate-400 font-medium">Filter aktif:</span>
                            @if(request('search'))
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-muted dark:bg-slate-800 text-foreground text-xs font-medium border border-border dark:border-slate-700">
                                "{{ request('search') }}"
                                <a href="{{ route('auctions.index', request()->except('search')) }}" class="hover:text-foreground ml-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></a>
                            </span>
                            @endif
                            @if(request('status'))
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-muted dark:bg-slate-800 text-foreground text-xs font-medium border border-border dark:border-slate-700">
                                {{ $statusLabels[request('status')] ?? request('status') }}
                                <a href="{{ route('auctions.index', request()->except('status')) }}" class="hover:text-foreground ml-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></a>
                            </span>
                            @endif
                            @if(request('asset_type'))
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-muted dark:bg-slate-800 text-foreground text-xs font-medium border border-border dark:border-slate-700">
                                {{ $assetTypes[request('asset_type')] ?? request('asset_type') }}
                                <a href="{{ route('auctions.index', request()->except('asset_type')) }}" class="hover:text-foreground ml-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></a>
                            </span>
                            @endif
                            <a href="{{ route('auctions.index') }}" class="text-xs text-secondary dark:text-slate-400 hover:text-emerald-600 font-medium transition-colors ml-1">Reset</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ AUCTION GRID ═══ --}}
    <section class="pb-20 lg:pb-28 bg-muted/30 dark:bg-slate-950/50 relative">
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
            <div class="absolute top-20 left-0 w-64 h-64 bg-emerald-50 rounded-full blur-[100px]"></div>
            <div class="absolute bottom-20 right-0 w-64 h-64 bg-emerald-50 rounded-full blur-[100px]"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8"
                 x-intersect="$el.querySelectorAll('.auction-card').forEach((el, i) => { setTimeout(() => el.classList.add('is-visible'), i * 100) })">
                @forelse($auctions as $index => $auction)
                @php $statusColor = $statusColorMap[$auction->status] ?? $statusColorMap['published']; @endphp
                <article class="auction-card reveal-up" style="transition-delay: {{ $index * 60 }}ms">
                    <a href="{{ route('auctions.show', $auction->slug) }}" class="block group no-underline">
                        <div class="double-bezel">
                            <div class="double-bezel-inner">
                                {{-- Image --}}
                                <div class="relative overflow-hidden" style="border-radius: var(--radius-double-inner) var(--radius-double-inner) 0 0;">
                                    @php $img = $auction->main_image; @endphp
                                    @if($img)
                                    <div class="aspect-[16/10] bg-muted dark:bg-slate-800">
                                        <x-optimized-image
                                            :src="\App\Helpers\StorageHelper::url($img)"
                                            :alt="$auction->title"
                                            :priority="$index < 3"
                                            :lazy="$index >= 3"
                                            class="w-full h-full transition-all duration-700 ease-[cubic-bezier(0.32,0.72,0,1)] group-hover:scale-105"
                                            aspect-ratio="16/10" />
                                    </div>
                                    @else
                                    <div class="aspect-[16/10] bg-gradient-to-br from-emerald-50 dark:from-emerald-900/30 to-emerald-100/50 dark:to-emerald-900/10 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h2m4 0h4M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </div>
                                    @endif

                                    {{-- Status badge --}}
                                    <div class="absolute top-3 left-3 z-10">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold shadow-sm {{ $statusColor }}">
                                            <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                                            {{ $statusLabels[$auction->status] ?? ucwords(str_replace('_', ' ', $auction->status)) }}
                                        </span>
                                    </div>

                                    {{-- Type badge --}}
                                    @if($auction->asset_type)
                                    <div class="absolute top-3 right-3 z-10">
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-[10px] font-bold bg-white/90 dark:bg-slate-900/90 backdrop-blur-sm text-slate-700 dark:text-slate-200 border border-white/50 dark:border-slate-700/50 shadow-sm">
                                            {{ $assetTypes[$auction->asset_type] ?? ucfirst($auction->asset_type) }}
                                        </span>
                                    </div>
                                    @endif

                                    {{-- Watermark Terjual --}}
                                    @if($auction->status === 'sold')
                                    <div class="absolute inset-0 z-[5] flex items-center justify-center pointer-events-none" aria-hidden="true">
                                        <div class="select-none border-4 border-white/80 text-white font-black uppercase tracking-[0.35em] text-2xl sm:text-3xl px-6 py-2 -rotate-[24deg] bg-red-600/45 shadow-xl">Terjual</div>
                                    </div>
                                    @endif
                                </div>

                                {{-- Content --}}
                                <div class="p-5 sm:p-6">
                                    {{-- Location --}}
                                    <div class="flex items-center gap-1.5 text-xs text-secondary dark:text-slate-400 mb-2">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span>{{ trim(implode(', ', array_filter([$auction->city, $auction->province]))) ?: '-' }}</span>
                                    </div>

                                    {{-- Title --}}
                                    <h3 class="text-base sm:text-lg font-bold text-foreground mb-3 line-clamp-2 group-hover:text-emerald-600 transition-colors duration-300 leading-snug">
                                        {{ $auction->title }}
                                    </h3>

                                    {{-- Meta grid --}}
                                    <div class="grid grid-cols-2 gap-y-2 gap-x-3 mb-4">
                                        @if($auction->land_area || $auction->building_area)
                                        <div class="flex items-center gap-1.5 text-xs text-secondary dark:text-slate-400">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4V15.414a1 1 0 00-.293-.707L4.293 8.293A1 1 0 014 7.586V5z"/></svg>
                                            <span>{{ $auction->land_area ?? $auction->building_area }} m²</span>
                                        </div>
                                        @endif
                                        @if($auction->auction_date)
                                        <div class="flex items-center gap-1.5 text-xs text-secondary dark:text-slate-400">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            <span>{{ \Carbon\Carbon::parse($auction->auction_date)->translatedFormat('d M Y') }}</span>
                                        </div>
                                        @endif
                                    </div>

                                    {{-- Price + CTA --}}
                                    <div class="pt-3 border-t border-border/50 dark:border-slate-700/50">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-[10px] text-secondary dark:text-slate-400 font-medium uppercase tracking-wide">Harga Limit</p>
                                                <p class="text-lg font-bold text-emerald-600">{{ $auction->limit_price ? format_rupiah($auction->limit_price) : '-' }}</p>
                                            </div>
                                            <div class="inline-flex items-center gap-1.5 text-emerald-600 font-semibold text-sm group-hover:gap-2.5 transition-all duration-300">
                                                <span>Detail</span>
                                                <span class="flex items-center justify-center w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400 transition-all duration-500 group-hover:translate-x-0.5 group-hover:scale-105">
                                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </article>
                @empty
                <div class="col-span-full reveal-up" x-intersect="$el.classList.add('is-visible')">
                    <div class="double-bezel">
                        <div class="double-bezel-inner py-16 px-6 text-center">
                            <div class="w-16 h-16 rounded-full bg-muted dark:bg-slate-800 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 21h18M12 15v6m0-6l-3-3m3 3l3-3M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-foreground mb-2">Belum Ada Lelang</h3>
                            <p class="text-sm text-secondary dark:text-slate-400 w-full mb-6">Belum ada lelang agunan yang sesuai dengan kriteria pencarian Anda.</p>
                            <a href="{{ route('auctions.index') }}" class="group inline-flex items-center gap-2 px-6 py-3 rounded-full bg-emerald-600 text-white font-bold shadow-lg shadow-emerald-500/15 hover:bg-emerald-700 transition-all duration-500 ease-[cubic-bezier(0.32,0.72,0,1)] active:scale-[0.98] text-sm">
                                Reset Pencarian
                            </a>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>

            @if($auctions->hasPages())
            <div class="mt-12 flex justify-center reveal-up" x-intersect="$el.classList.add('is-visible')">
                {{ $auctions->links() }}
            </div>
            @endif
        </div>
    </section>
</x-frontend-layout>
