<x-frontend-layout>
    <x-slot:title>{{ $auction->title }} - {{ config('app.name') }}</x-slot:title>
    <x-slot:metaDescription>{{ $auction->meta_description ?: Str::limit(strip_tags($auction->description), 155) }}</x-slot:metaDescription>

    @php
        $images = $auction->images ?? [];
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
        $statusColor = $statusColorMap[$auction->status] ?? $statusColorMap['published'];
    @endphp

    {{-- ═══ CRUMB + HERO ═══ --}}
    <section class="relative pt-8 sm:pt-10 md:pt-12 pb-12 sm:pb-16 overflow-hidden">
        <div class="absolute inset-0 hero-gradient">
            <div class="absolute inset-0 bg-grid-pattern opacity-30"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 text-xs text-white/70 mb-6">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">Beranda</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('auctions.index') }}" class="hover:text-white transition-colors">Lelang Agunan</a>
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-white/90 font-medium line-clamp-1">{{ $auction->title }}</span>
            </nav>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $statusColor }}">
                <span class="w-1.5 h-1.5 rounded-full bg-current"></span>
                {{ $statusLabels[$auction->status] ?? ucwords(str_replace('_', ' ', $auction->status)) }}
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mt-4 mb-3 tracking-tight leading-tight">{{ $auction->title }}</h1>
            <p class="flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-white/80">
                @if($auction->auction_number)
                <span class="inline-flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>Lelang No. {{ $auction->auction_number }}</span>
                @endif
                @if($auction->city)
                <span class="inline-flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>{{ $auction->city }}</span>
                @endif
                @if($auction->auction_date)
                <span class="inline-flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>{{ \Carbon\Carbon::parse($auction->auction_date)->translatedFormat('d F Y') }}</span>
                @endif
            </p>
        </div>
    </section>

    {{-- ═══ MAIN CONTENT ═══ --}}
    <section class="pb-20 lg:pb-28 bg-muted/30 dark:bg-slate-950/50 relative -mt-2">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-10">

                {{-- Kiri: Detail --}}
                <div class="lg:col-span-2 space-y-8">

                    {{-- Gallery --}}
                    <div class="reveal-up" x-intersect="$el.classList.add('is-visible')">
                        <div class="double-bezel">
                            <div class="double-bezel-inner p-3 sm:p-4" x-data="{ active: 0 }">
                                <div class="relative overflow-hidden rounded-xl">
                                    @if(count($images) > 0)
                                    <div class="aspect-[16/10] bg-muted dark:bg-slate-800">
                                        @foreach($images as $i => $img)
                                        <img src="{{ \App\Helpers\StorageHelper::url($img) }}"
                                            x-show="active === {{ $i }}" x-cloak
                                            :class="active === {{ $i }} ? '' : 'hidden'"
                                            class="w-full h-full object-cover" alt="{{ $auction->title }}">
                                        @endforeach
                                    </div>
                                    @if(count($images) > 1)
                                    <div class="absolute bottom-3 right-3 z-10 px-2 py-1 rounded-full bg-black/50 backdrop-blur-sm text-white text-xs font-medium" x-text="(active + 1) + ' / ' + {{ count($images) }}"></div>
                                    @endif
                                    @else
                                    <div class="aspect-[16/10] bg-gradient-to-br from-emerald-50 dark:from-emerald-900/30 to-emerald-100/50 dark:to-emerald-900/10 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h2m4 0h4M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </div>
                                    @endif

                                    {{-- Watermark Terjual --}}
                                    @if($auction->status === 'sold')
                                    <div class="absolute inset-0 z-[5] flex items-center justify-center pointer-events-none" aria-hidden="true">
                                        <div class="select-none border-4 border-white/80 text-white font-black uppercase tracking-[0.35em] text-3xl sm:text-4xl px-8 py-2 -rotate-[24deg] bg-red-600/45 shadow-xl">Terjual</div>
                                    </div>
                                    @endif
                                </div>
                                @if(count($images) > 1)
                                <div class="flex gap-2 mt-3 overflow-x-auto pb-1">
                                    @foreach($images as $i => $img)
                                    <button type="button" @click="active = {{ $i }}"
                                        :class="active === {{ $i }} ? 'ring-2 ring-emerald-500' : 'opacity-60 hover:opacity-100'"
                                        class="flex-shrink-0 w-20 h-14 rounded-lg overflow-hidden transition-all">
                                        <img src="{{ \App\Helpers\StorageHelper::url($img) }}" class="w-full h-full object-cover" alt="">
                                    </button>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Description --}}
                    @if($auction->description)
                    <div class="reveal-up" x-intersect="$el.classList.add('is-visible')">
                        <h2 class="text-xl font-bold text-foreground mb-4 flex items-center gap-3">
                            <span class="w-1 h-6 rounded-full bg-gradient-to-b from-emerald-500 to-emerald-600"></span>
                            Deskripsi
                        </h2>
                        <div class="text-secondary dark:text-slate-400 leading-relaxed whitespace-pre-line">{{ $auction->description }}</div>
                    </div>
                    @endif

                    {{-- Detail Aset --}}
                    @if($auction->land_area || $auction->building_area || $auction->certificate_type || $auction->asset_description)
                    <div class="reveal-up" x-intersect="$el.classList.add('is-visible')">
                        <h2 class="text-xl font-bold text-foreground mb-4 flex items-center gap-3">
                            <span class="w-1 h-6 rounded-full bg-gradient-to-b from-emerald-500 to-emerald-600"></span>
                            Detail Aset
                        </h2>
                        <div class="double-bezel">
                            <div class="double-bezel-inner p-5 sm:p-6">
                                <dl class="grid grid-cols-2 sm:grid-cols-3 gap-x-6 gap-y-4">
                                    @if($auction->asset_type)
                                    <div>
                                        <dt class="text-xs text-secondary dark:text-slate-400">Tipe Aset</dt>
                                        <dd class="mt-0.5 text-sm font-semibold text-foreground">{{ $assetTypes[$auction->asset_type] ?? ucfirst($auction->asset_type) }}</dd>
                                    </div>
                                    @endif
                                    @if($auction->land_area)
                                    <div>
                                        <dt class="text-xs text-secondary dark:text-slate-400">Luas Tanah</dt>
                                        <dd class="mt-0.5 text-sm font-semibold text-foreground">{{ number_format($auction->land_area, 0) }} m²</dd>
                                    </div>
                                    @endif
                                    @if($auction->building_area)
                                    <div>
                                        <dt class="text-xs text-secondary dark:text-slate-400">Luas Bangunan</dt>
                                        <dd class="mt-0.5 text-sm font-semibold text-foreground">{{ number_format($auction->building_area, 0) }} m²</dd>
                                    </div>
                                    @endif
                                    @if($auction->certificate_type)
                                    <div>
                                        <dt class="text-xs text-secondary dark:text-slate-400">Sertifikat</dt>
                                        <dd class="mt-0.5 text-sm font-semibold text-foreground">{{ $auction->certificate_type }}@if($auction->certificate_number) · {{ $auction->certificate_number }}@endif</dd>
                                    </div>
                                    @endif
                                    @if($auction->asset_category)
                                    <div>
                                        <dt class="text-xs text-secondary dark:text-slate-400">Kategori</dt>
                                        <dd class="mt-0.5 text-sm font-semibold text-foreground">{{ $auction->asset_category }}</dd>
                                    </div>
                                    @endif
                                    @if($auction->building_condition)
                                    <div>
                                        <dt class="text-xs text-secondary dark:text-slate-400">Kondisi</dt>
                                        <dd class="mt-0.5 text-sm font-semibold text-foreground">{{ $auction->building_condition }}</dd>
                                    </div>
                                    @endif
                                </dl>
                                @if($auction->asset_description)
                                <p class="mt-4 pt-4 border-t border-border/50 dark:border-slate-700/50 text-sm text-secondary dark:text-slate-400 leading-relaxed whitespace-pre-line">{{ $auction->asset_description }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Lokasi --}}
                    @if($auction->address || $auction->city)
                    <div class="reveal-up" x-intersect="$el.classList.add('is-visible')">
                        <h2 class="text-xl font-bold text-foreground mb-4 flex items-center gap-3">
                            <span class="w-1 h-6 rounded-full bg-gradient-to-b from-emerald-500 to-emerald-600"></span>
                            Lokasi Aset
                        </h2>
                        <div class="flex items-start gap-3 text-sm text-secondary dark:text-slate-400">
                            <svg class="w-5 h-5 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <div>
                                <p class="font-semibold text-foreground">{{ $auction->address }}</p>
                                <p class="mt-0.5">{{ implode(', ', array_filter([$auction->village, $auction->district, $auction->city, $auction->province])) }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Info Debitur --}}
                    @if($auction->debtor_name)
                    <div class="reveal-up" x-intersect="$el.classList.add('is-visible')">
                        <h2 class="text-xl font-bold text-foreground mb-4 flex items-center gap-3">
                            <span class="w-1 h-6 rounded-full bg-gradient-to-b from-emerald-500 to-emerald-600"></span>
                            Informasi Debitur
                        </h2>
                        <div class="flex items-center gap-3 text-sm">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/50 flex items-center justify-center">
                                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            </div>
                            <span class="font-semibold text-foreground">{{ $auction->debtor_name }}</span>
                        </div>
                    </div>
                    @endif

                </div>

                {{-- Kanan: Sidebar --}}
                <div class="lg:col-span-1 space-y-6">

                    {{-- Harga + CTA --}}
                    <div class="double-bezel reveal-up" x-intersect="$el.classList.add('is-visible')">
                        <div class="double-bezel-inner p-6">
                            <p class="text-[11px] text-secondary dark:text-slate-400 font-medium uppercase tracking-wide mb-1">Harga Limit</p>
                            <p class="text-3xl font-bold text-emerald-600">{{ $auction->limit_price ? format_rupiah($auction->limit_price) : '-' }}</p>

                            @if($auction->deposit_amount)
                            <div class="mt-4 flex items-center justify-between pt-4 border-t border-border/50 dark:border-slate-700/50">
                                <span class="text-sm text-secondary dark:text-slate-400">Uang Jaminan</span>
                                <span class="text-sm font-semibold text-foreground">{{ format_rupiah($auction->deposit_amount) }}</span>
                            </div>
                            @endif

                            @if($auction->auction_url)
                            <a href="{{ $auction->auction_url }}" target="_blank" rel="nofollow noopener noreferrer"
                                class="mt-6 w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl border border-emerald-200 dark:border-emerald-900/60 text-emerald-700 dark:text-emerald-300 font-bold hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-all duration-300 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                Lihat Lelang Resmi
                            </a>
                            @endif
                        </div>
                    </div>

                    {{-- Info Lelang --}}
                    <div class="reveal-up" x-intersect="$el.classList.add('is-visible')">
                        <div class="double-bezel">
                            <div class="double-bezel-inner p-6">
                                <h3 class="text-sm font-bold text-foreground mb-5 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Informasi Lelang
                                </h3>
                                <dl class="space-y-4">
                                    @if($auction->auction_date)
                                    <div class="flex justify-between gap-3">
                                        <dt class="text-sm text-secondary dark:text-slate-400">Tanggal</dt>
                                        <dd class="text-sm font-semibold text-foreground text-right">{{ \Carbon\Carbon::parse($auction->auction_date)->translatedFormat('l, d M Y') }}@if($auction->auction_time) · {{ $auction->auction_time }}@endif</dd>
                                    </div>
                                    @endif
                                    @if($auction->auction_location)
                                    <div class="flex justify-between gap-3">
                                        <dt class="text-sm text-secondary dark:text-slate-400">Lokasi</dt>
                                        <dd class="text-sm font-semibold text-foreground text-right">{{ $auction->auction_location }}</dd>
                                    </div>
                                    @endif
                                    @if($auction->auction_number)
                                    <div class="flex justify-between gap-3">
                                        <dt class="text-sm text-secondary dark:text-slate-400">Nomor Lelang</dt>
                                        <dd class="text-sm font-semibold text-foreground">{{ $auction->auction_number }}</dd>
                                    </div>
                                    @endif
                                    @if($auction->auction_type)
                                    <div class="flex justify-between gap-3">
                                        <dt class="text-sm text-secondary dark:text-slate-400">Jenis</dt>
                                        <dd class="text-sm font-semibold text-foreground text-right">{{ ucwords(str_replace('_', ' ', $auction->auction_type)) }}</dd>
                                    </div>
                                    @endif
                                </dl>
                            </div>
                        </div>
                    </div>

                    {{-- Kontak --}}
                    @if($auction->contact_name || $auction->contact_phone || $auction->contact_email)
                    <div class="reveal-up" x-intersect="$el.classList.add('is-visible')">
                        <div class="double-bezel">
                            <div class="double-bezel-inner p-6">
                                <h3 class="text-sm font-bold text-foreground mb-5 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    Informasi & Kontak
                                </h3>
                                <div class="space-y-3 text-sm">
                                    @if($auction->contact_name)
                                    <div class="flex items-center gap-3">
                                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        <span class="font-semibold text-foreground">{{ $auction->contact_name }}</span>
                                    </div>
                                    @endif
                                    @if($auction->contact_phone)
                                    <a href="tel:{{ $auction->contact_phone }}" class="flex items-center gap-3 text-secondary dark:text-slate-400 hover:text-emerald-600 transition-colors">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                        {{ $auction->contact_phone }}
                                    </a>
                                    @endif
                                    @if($auction->contact_email)
                                    <a href="mailto:{{ $auction->contact_email }}" class="flex items-center gap-3 text-secondary dark:text-slate-400 hover:text-emerald-600 transition-colors">
                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                        {{ $auction->contact_email }}
                                    </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>

            {{-- ═══ RELATED ═══ --}}
            @if($related && $related->count() > 0)
            <div class="mt-16 lg:mt-20 reveal-up" x-intersect="$el.classList.add('is-visible')">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-foreground">Lelang Serupa</h2>
                    <a href="{{ route('auctions.index') }}" class="group inline-flex items-center gap-1.5 text-emerald-600 font-semibold text-sm">
                        Lihat Semua
                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 lg:gap-8">
                    @foreach($related as $rel)
                    <a href="{{ route('auctions.show', $rel->slug) }}" class="block group no-underline">
                        <div class="double-bezel">
                            <div class="double-bezel-inner">
                                <div class="relative overflow-hidden" style="border-radius: var(--radius-double-inner) var(--radius-double-inner) 0 0;">
                                    @if($rel->main_image)
                                    <div class="aspect-[16/10] bg-muted dark:bg-slate-800">
                                        <x-optimized-image :src="\App\Helpers\StorageHelper::url($rel->main_image)" :alt="$rel->title" class="w-full h-full transition-all duration-700 ease-[cubic-bezier(0.32,0.72,0,1)] group-hover:scale-105" aspect-ratio="16/10" />
                                    </div>
                                    @else
                                    <div class="aspect-[16/10] bg-gradient-to-br from-emerald-50 dark:from-emerald-900/30 to-emerald-100/50 dark:to-emerald-900/10"></div>
                                    @endif
                                    @if($rel->status === 'sold')
                                    <div class="absolute inset-0 z-[5] flex items-center justify-center pointer-events-none" aria-hidden="true">
                                        <div class="select-none border-4 border-white/80 text-white font-black uppercase tracking-[0.3em] text-2xl px-5 py-1 -rotate-[24deg] bg-red-600/45 shadow-xl">Terjual</div>
                                    </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="text-sm font-bold text-foreground line-clamp-2 group-hover:text-emerald-600 transition-colors leading-snug mb-2">{{ $rel->title }}</h3>
                                    <p class="text-sm font-bold text-emerald-600">{{ $rel->limit_price ? format_rupiah($rel->limit_price) : '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </section>
</x-frontend-layout>
