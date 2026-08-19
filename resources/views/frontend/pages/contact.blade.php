<x-frontend-layout>
    <x-slot:title>Hubungi Kami - {{ config('app.name') }}</x-slot:title>

    @php
        $offices = \Illuminate\Support\Facades\Cache::remember('contact_offices', 3600, fn() =>
            \App\Models\Office::active()
                ->orderByRaw("CASE type WHEN 'pusat' THEN 1 WHEN 'cabang' THEN 2 WHEN 'kas' THEN 3 WHEN 'kas_keliling' THEN 4 ELSE 5 END")
                ->get()
        );
        $officesWithCoords = $offices->filter(fn($o) => $o->has_coordinates);
        $centerLat = $officesWithCoords->avg('latitude') ?? -2.1316;
        $centerLng = $officesWithCoords->avg('longitude') ?? 106.1169;

        // Prepare offices data for JavaScript
        $officesJson = $offices->map(function($o) {
            return [
                'id' => $o->id,
                'name' => $o->name,
                'type' => $o->type,
                'type_label' => $o->type_label,
                'address' => $o->address,
                'phone' => $o->phone,
                'lat' => $o->latitude,
                'lng' => $o->longitude,
                'has_coords' => $o->has_coordinates,
                'directions_url' => $o->directions_url
            ];
        });
    @endphp

    {{-- ═══ HIGH-END v2: HERO — Ethereal Glass ═══ --}}
    <section class="relative pt-8 sm:pt-10 md:pt-12 pb-16 sm:pb-20 md:pb-28 overflow-hidden">
        <div class="absolute inset-0 hero-gradient">
            <div class="absolute inset-0 bg-grid-pattern opacity-30"></div>
            <div class="absolute top-10 left-1/4 w-80 h-80 bg-emerald-400/20 rounded-full blur-3xl animate-float-slow"></div>
            <div class="absolute bottom-10 right-1/4 w-96 h-96 bg-emerald-400/15 rounded-full blur-3xl animate-float-slow" style="animation-delay: 3s;"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="eyebrow-badge mb-5 inline-flex bg-white/20 text-white border-white/20">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Kontak Kami
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-white mb-4 sm:mb-6 tracking-tight leading-tight">Hubungi Kami</h1>
            <p class="text-base sm:text-lg md:text-xl text-white/80 w-full px-4 leading-relaxed">
                Kami siap membantu Anda dengan layanan perbankan syariah terbaik. Temukan kantor terdekat atau kirim pesan kepada kami.
            </p>
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-muted/30 to-transparent"></div>
    </section>

    {{-- ═══ QUICK CONTACT CARDS — Double-Bezel ═══ --}}
    <section class="py-16 lg:py-20 -mt-6 relative z-10">
        {{-- Section background for dark mode --}}
        <div class="absolute inset-0 bg-white dark:bg-slate-950 pointer-events-none" aria-hidden="true"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6"
                 x-intersect="$el.querySelectorAll('.quick-card').forEach((el, i) => { setTimeout(() => el.classList.add('is-visible'), i * 120) })">
                {{-- Phone Card --}}
                <a href="tel:{{ $companyInfo->phone ?? '' }}" class="quick-card reveal-up block no-underline">
                    <div class="double-bezel h-full">
                        <div class="double-bezel-inner p-5 sm:p-6 text-center">
                            <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-gradient-to-br from-emerald-50 to-emerald-100 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-500 shrink-0">
                                <svg class="w-7 h-7 sm:w-8 sm:h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <p class="text-xs sm:text-sm font-medium text-secondary dark:text-slate-400 mb-1 tracking-wide uppercase">Telepon</p>
                            <p class="text-base sm:text-lg font-bold text-foreground dark:text-slate-100 truncate group-hover:text-emerald-600 transition-colors duration-300">{{ $companyInfo->phone ?? '-' }}</p>
                        </div>
                    </div>
                </a>

                {{-- Email Card --}}
                <a href="mailto:{{ $companyInfo->email ?? '' }}" class="quick-card reveal-up block no-underline" style="transition-delay: 100ms">
                    <div class="double-bezel h-full">
                        <div class="double-bezel-inner p-5 sm:p-6 text-center">
                            <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-gradient-to-br from-amber-50 to-amber-100 flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform duration-500 shrink-0">
                                <svg class="w-7 h-7 sm:w-8 sm:h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <p class="text-xs sm:text-sm font-medium text-secondary dark:text-slate-400 mb-1 tracking-wide uppercase">Email</p>
                            <p class="text-base sm:text-lg font-bold text-foreground dark:text-slate-100 truncate group-hover:text-amber-600 transition-colors duration-300">{{ $companyInfo->email ?? '-' }}</p>
                        </div>
                    </div>
                </a>

                {{-- Operating Hours Card --}}
                <div class="quick-card reveal-up sm:col-span-2 lg:col-span-1" style="transition-delay: 200ms">
                    <div class="double-bezel h-full">
                        <div class="double-bezel-inner p-5 sm:p-6 text-center">
                            <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-gradient-to-br from-blue-50 to-blue-100 flex items-center justify-center mx-auto mb-4 shrink-0">
                                <svg class="w-7 h-7 sm:w-8 sm:h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <p class="text-xs sm:text-sm font-medium text-secondary dark:text-slate-400 mb-1 tracking-wide uppercase">Jam Operasional</p>
                            <p class="text-base sm:text-lg font-bold text-foreground dark:text-slate-100">Sen—Jum 08:00—16:00</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ MAP & OFFICES — Redesigned ═══ --}}
    <section class="pb-16 lg:pb-20 relative bg-white dark:bg-slate-950" id="mapContainer" x-data="officeMapData()" x-init="init()">
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
            <div class="absolute top-20 left-0 w-72 h-72 bg-emerald-50/60 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-20 right-0 w-64 h-64 bg-amber-50/30 rounded-full blur-[120px]"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Peta Full Width --}}
            <div class="reveal-up mb-8 sm:mb-10" x-intersect="$el.classList.add('is-visible')">
                <div class="double-bezel">
                    <div class="double-bezel-inner p-0 overflow-hidden">
                        <div class="p-4 sm:p-5 border-b border-border/50 flex items-center justify-between bg-white/50 dark:bg-slate-900/50">
                            <h2 class="font-bold text-foreground flex items-center text-base sm:text-lg tracking-tight">
                                <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 mr-3 shrink-0">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                </span>
                                Peta Lokasi Kantor
                            </h2>
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full bg-emerald-50 text-emerald-600 text-xs font-bold border border-emerald-100/50">
                                {{ $officesWithCoords->count() }} Lokasi
                            </span>
                        </div>
                        <div id="officeMap" class="w-full bg-muted" style="height: 420px; border-radius: 0 0 var(--radius-double-inner) var(--radius-double-inner);"></div>
                    </div>
                </div>
            </div>

            {{-- Section Header + Filter --}}
            <div class="reveal-up flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6" x-intersect="$el.classList.add('is-visible')">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-foreground dark:text-slate-100 tracking-tight">Daftar Kantor</h2>
                    <p class="text-sm text-secondary dark:text-slate-400 mt-1">Temukan kantor kami yang terdekat dengan Anda</p>
                </div>
                {{-- Filter Pills --}}
                <div class="flex flex-wrap gap-2">
                    <button @click="filterType = 'all'"
                            :class="filterType === 'all' ? 'bg-emerald-600 text-white shadow-sm shadow-emerald-500/25 border-transparent' : 'bg-white dark:bg-slate-800 text-secondary dark:text-slate-300 border-border/60 hover:border-emerald-300 hover:text-emerald-600'"
                            class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold rounded-full border transition-all duration-200 active:scale-[0.97]">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        Semua ({{ $offices->count() }})
                    </button>
                    <button @click="filterType = 'pusat'"
                            :class="filterType === 'pusat' ? 'bg-amber-500 text-white shadow-sm shadow-amber-500/25 border-transparent' : 'bg-white dark:bg-slate-800 text-secondary dark:text-slate-300 border-border/60 hover:border-amber-300 hover:text-amber-600'"
                            class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold rounded-full border transition-all duration-200 active:scale-[0.97]">
                        <span class="w-2 h-2 rounded-full bg-current"></span>
                        Pusat
                    </button>
                    <button @click="filterType = 'cabang'"
                            :class="filterType === 'cabang' ? 'bg-blue-500 text-white shadow-sm shadow-blue-500/25 border-transparent' : 'bg-white dark:bg-slate-800 text-secondary dark:text-slate-300 border-border/60 hover:border-blue-300 hover:text-blue-600'"
                            class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold rounded-full border transition-all duration-200 active:scale-[0.97]">
                        <span class="w-2 h-2 rounded-full bg-current"></span>
                        Cabang
                    </button>
                    <button @click="filterType = 'kas'"
                            :class="filterType === 'kas' ? 'bg-primary text-white shadow-sm shadow-primary/25 border-transparent' : 'bg-white dark:bg-slate-800 text-secondary dark:text-slate-300 border-border/60 hover:border-primary/50 hover:text-primary'"
                            class="inline-flex items-center gap-1.5 px-4 py-2 text-xs font-bold rounded-full border transition-all duration-200 active:scale-[0.97]">
                        <span class="w-2 h-2 rounded-full bg-current"></span>
                        Kas
                    </button>
                </div>
            </div>

            {{-- Office Card Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5 reveal-up" x-intersect="$el.classList.add('is-visible')">
                @foreach($offices as $office)
                @php
                    $typeConfig = [
                        'pusat' => [
                            'bg'     => 'bg-amber-500',
                            'light'  => 'bg-amber-50 dark:bg-amber-900/20',
                            'border' => 'border-amber-200 dark:border-amber-800/40',
                            'badge'  => 'text-amber-700 bg-amber-50 border-amber-200 dark:text-amber-400 dark:bg-amber-900/30 dark:border-amber-800/40',
                            'ring'   => 'ring-amber-400',
                            'icon'   => 'text-amber-600',
                            'action' => 'text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/20',
                        ],
                        'cabang' => [
                            'bg'     => 'bg-blue-500',
                            'light'  => 'bg-blue-50 dark:bg-blue-900/20',
                            'border' => 'border-blue-200 dark:border-blue-800/40',
                            'badge'  => 'text-blue-700 bg-blue-50 border-blue-200 dark:text-blue-400 dark:bg-blue-900/30 dark:border-blue-800/40',
                            'ring'   => 'ring-blue-400',
                            'icon'   => 'text-blue-600',
                            'action' => 'text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20',
                        ],
                        'kas' => [
                            'bg'     => 'bg-emerald-600',
                            'light'  => 'bg-emerald-50 dark:bg-emerald-900/20',
                            'border' => 'border-emerald-200 dark:border-emerald-800/40',
                            'badge'  => 'text-emerald-700 bg-emerald-50 border-emerald-200 dark:text-emerald-400 dark:bg-emerald-900/30 dark:border-emerald-800/40',
                            'ring'   => 'ring-emerald-400',
                            'icon'   => 'text-emerald-600',
                            'action' => 'text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/20',
                        ],
                        'kas_keliling' => [
                            'bg'     => 'bg-teal-500',
                            'light'  => 'bg-teal-50 dark:bg-teal-900/20',
                            'border' => 'border-teal-200 dark:border-teal-800/40',
                            'badge'  => 'text-teal-700 bg-teal-50 border-teal-200 dark:text-teal-400 dark:bg-teal-900/30 dark:border-teal-800/40',
                            'ring'   => 'ring-teal-400',
                            'icon'   => 'text-teal-600',
                            'action' => 'text-teal-600 hover:bg-teal-50 dark:hover:bg-teal-900/20',
                        ],
                    ];
                    $cfg = $typeConfig[$office->type] ?? $typeConfig['kas'];
                @endphp
                <div x-show="filterType === 'all' || filterType === '{{ $office->type }}'"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     @click="selectOffice({{ $office->id }}, {{ $office->latitude ?? 'null' }}, {{ $office->longitude ?? 'null' }})"
                     :class="selectedOffice === {{ $office->id }} ? 'ring-2 {{ $cfg['ring'] }} shadow-lg -translate-y-0.5' : 'hover:shadow-md hover:-translate-y-0.5'"
                     class="group relative bg-white dark:bg-slate-900 rounded-2xl border border-border/60 dark:border-slate-700/60 cursor-pointer transition-all duration-300 overflow-hidden">

                    {{-- Colored top bar --}}
                    <div class="h-1.5 w-full {{ $cfg['bg'] }}"></div>

                    <div class="p-5">
                        {{-- Header: icon + badge --}}
                        <div class="flex items-start justify-between gap-3 mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-11 h-11 {{ $cfg['light'] }} rounded-xl flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform duration-300">
                                    <svg class="w-5 h-5 {{ $cfg['icon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $cfg['badge'] }} mb-1">
                                        {{ $office->type_label }}
                                    </span>
                                    <h3 class="text-sm font-bold text-foreground dark:text-slate-100 leading-tight line-clamp-2">{{ $office->name }}</h3>
                                </div>
                            </div>
                            @if($office->has_coordinates)
                            <div class="shrink-0 w-7 h-7 rounded-lg {{ $cfg['light'] }} flex items-center justify-center opacity-60 group-hover:opacity-100 transition-opacity duration-200" title="Tersedia di peta">
                                <svg class="w-3.5 h-3.5 {{ $cfg['icon'] }}" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                            </div>
                            @endif
                        </div>

                        {{-- Address --}}
                        <div class="flex items-start gap-2 mb-3">
                            <svg class="w-3.5 h-3.5 text-secondary dark:text-slate-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <p class="text-xs text-secondary dark:text-slate-400 leading-relaxed line-clamp-2">{{ $office->address }}</p>
                        </div>

                        @if($office->phone)
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-3.5 h-3.5 text-secondary dark:text-slate-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <p class="text-xs font-medium text-secondary dark:text-slate-400">{{ $office->phone }}</p>
                        </div>
                        @else
                        <div class="mb-4"></div>
                        @endif

                        {{-- Action Buttons --}}
                        <div class="flex gap-2 pt-3 border-t border-border/40 dark:border-slate-700/40">
                            @if($office->phone)
                            <a href="tel:{{ $office->phone }}"
                               @click.stop
                               class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold {{ $cfg['action'] }} border border-border/50 dark:border-slate-700/50 transition-colors duration-200">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                Telepon
                            </a>
                            @endif
                            @if($office->directions_url)
                            <a href="{{ $office->directions_url }}"
                               target="_blank" rel="noopener noreferrer"
                               @click.stop
                               class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold {{ $cfg['action'] }} border border-border/50 dark:border-slate-700/50 transition-colors duration-200">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                                Arahkan
                            </a>
                            @endif
                            @if(!$office->phone && !$office->directions_url)
                            <span class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 rounded-xl text-xs font-medium text-secondary dark:text-slate-500 border border-border/40 dark:border-slate-700/40">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Info tidak tersedia
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </section>

    {{-- ═══ CONTACT FORM + COMPANY INFO — Double-Bezel ═══ --}}
    <section class="pb-20 lg:pb-28 relative bg-muted/30">
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
            <div class="absolute top-20 right-0 w-72 h-72 bg-emerald-50/40 rounded-full blur-[120px]"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
                {{-- Left: Company Info + Social --}}
                <div class="space-y-6 lg:space-y-8 reveal-up" x-intersect="$el.classList.add('is-visible')">
                    {{-- Kantor Pusat --}}
                    <div class="double-bezel">
                        <div class="double-bezel-inner p-5 sm:p-6">
                            <span class="eyebrow-badge inline-flex mb-3">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                Kantor Pusat
                            </span>
                            <div class="space-y-3 sm:space-y-4 text-sm">
                                <p class="text-secondary leading-relaxed font-medium text-base">{!! nl2br(e($companyInfo->address ?? 'Alamat belum tersedia')) !!}</p>

                                <div class="pt-4 border-t border-border/50 space-y-3">
                                    @if($companyInfo->phone)
                                    <div class="flex items-center gap-3 text-secondary group hover:text-emerald-600 transition-colors duration-200 cursor-pointer">
                                        <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-muted group-hover:bg-emerald-50 transition-colors duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                        </span>
                                        <span class="font-medium">{{ $companyInfo->phone }}</span>
                                    </div>
                                    @endif
                                    @if($companyInfo->email)
                                    <div class="flex items-center gap-3 text-secondary group hover:text-emerald-600 transition-colors duration-200 cursor-pointer">
                                        <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-muted group-hover:bg-emerald-50 transition-colors duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                        </span>
                                        <span class="font-medium">{{ $companyInfo->email }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Social Media --}}                                @if($companyInfo->facebook || $companyInfo->instagram || $companyInfo->twitter || $companyInfo->youtube)
                                    <div class="double-bezel">
                                        <div class="double-bezel-inner p-5 sm:p-6">
                                            <span class="eyebrow-badge inline-flex mb-4">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/></svg>
                                                Ikuti Kami
                                            </span>
                                            <div class="flex flex-wrap gap-2.5">
                                                @if($companyInfo->facebook)
                                                <a href="{{ $companyInfo->facebook }}" target="_blank" rel="nofollow noopener noreferrer" class="group inline-flex items-center justify-center w-11 h-11 rounded-full bg-white dark:bg-slate-800 text-foreground dark:text-slate-200 border border-border dark:border-slate-700 hover:bg-gradient-to-br hover:from-blue-600 hover:to-blue-700 hover:text-white hover:border-transparent transition-all duration-300 active:scale-[0.93] shadow-sm" aria-label="Facebook">
                                                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                                </a>
                                                @endif
                                                @if($companyInfo->twitter)
                                                <a href="{{ $companyInfo->twitter }}" target="_blank" rel="nofollow noopener noreferrer" class="group inline-flex items-center justify-center w-11 h-11 rounded-full bg-white dark:bg-slate-800 text-foreground dark:text-slate-200 border border-border dark:border-slate-700 hover:bg-gradient-to-br hover:from-gray-900 hover:to-gray-800 hover:text-white hover:border-transparent transition-all duration-300 active:scale-[0.93] shadow-sm" aria-label="Twitter / X">
                                                    <svg class="w-4 h-4 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                                </a>
                                                @endif
                                                @if($companyInfo->instagram)
                                                <a href="{{ $companyInfo->instagram }}" target="_blank" rel="nofollow noopener noreferrer" class="group inline-flex items-center justify-center w-11 h-11 rounded-full bg-white dark:bg-slate-800 text-foreground dark:text-slate-200 border border-border dark:border-slate-700 hover:bg-gradient-to-br hover:from-pink-500 hover:via-purple-500 hover:to-orange-400 hover:text-white hover:border-transparent transition-all duration-300 active:scale-[0.93] shadow-sm" aria-label="Instagram">
                                                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069z"/></svg>
                                                </a>
                                                @endif
                                                @if($companyInfo->youtube)
                                                <a href="{{ $companyInfo->youtube }}" target="_blank" rel="nofollow noopener noreferrer" class="group inline-flex items-center justify-center w-11 h-11 rounded-full bg-white dark:bg-slate-800 text-foreground dark:text-slate-200 border border-border dark:border-slate-700 hover:bg-gradient-to-br hover:from-red-600 hover:to-red-700 hover:text-white hover:border-transparent transition-all duration-300 active:scale-[0.93] shadow-sm" aria-label="YouTube">
                                                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                </div>

                {{-- Right: Contact Form --}}
                <div class="lg:col-span-2 reveal-up" style="transition-delay: 150ms" x-intersect="$el.classList.add('is-visible')">
                    <div class="double-bezel">
                        <div class="double-bezel-inner p-5 sm:p-6 md:p-8">
                            <div class="mb-6 sm:mb-8">
                                <span class="eyebrow-badge inline-flex mb-3">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    Kirim Pesan
                                </span>
                                <h2 class="text-2xl sm:text-3xl font-bold text-foreground mb-2 tracking-tight">Hubungi Kami</h2>
                                <p class="text-sm sm:text-base text-secondary">Isi form di bawah ini dan tim kami akan segera menghubungi Anda dalam waktu 24 jam kerja.</p>
                            </div>
                            <livewire:frontend.contact.form />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Leaflet CSS & JS --}}
    @push('head')
    @vite('resources/js/map-utils.js')
    <style>
        .leaflet-popup-content-wrapper { border-radius: 12px; }
        .leaflet-popup-content { margin: 12px 16px; }
        .custom-marker { background: none; border: none; }
    </style>
    @endpush

    @push('scripts')
    <script nonce="{{ $nonce }}">
        document.addEventListener('alpine:init', () => {
            Alpine.data('officeMapData', () => ({
                filterType: 'all',
                selectedOffice: null,
                mapCtx: null,
                offices: @json($officesJson),

                init() {
                    this.$nextTick(() => {
                        this.initMap();
                    });
                },

                initMap() {
                    const points = this.offices.map(o => ({
                        id: o.id,
                        name: o.name,
                        type: o.type_label,
                        address: o.address,
                        lat: o.lat,
                        lng: o.lng,
                        url: o.directions_url || null
                    }));
                    this.mapCtx = window.BPRSMaps?.initSimpleMap?.('officeMap', points, { scrollWheelZoom: false }) || null;
                },

                selectOffice(id, lat, lng) {
                    this.selectedOffice = id;
                    const la = parseFloat(String(lat ?? '').replace(',', '.'));
                    const lo = parseFloat(String(lng ?? '').replace(',', '.'));
                    const map = this.mapCtx?.map;
                    const mk = this.mapCtx?.markersById?.[String(id)];
                    if (isFinite(la) && isFinite(lo) && map) {
                        map.setView([la, lo], 15);
                        if (mk) mk.openPopup();
                    }
                }
            }));
        });
    </script>
    @endpush
</x-frontend-layout>
