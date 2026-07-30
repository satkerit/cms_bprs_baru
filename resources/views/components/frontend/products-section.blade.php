@props(['products'])

@php
    $typeConfig = [
        'simpanan_syariah' => [
            'label' => 'Simpanan',
            'gradient' => 'from-amber-500 to-amber-600',
            'overlay' => 'from-amber-900/80 via-amber-800/40 to-transparent',
            'hoverOverlay' => 'from-amber-600/90 via-amber-500/60 to-transparent',
            'icon' => 'M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z',
            'accentColor' => 'amber',
            'lightBg' => 'bg-amber-50',
        ],
        'pembiayaan_syariah' => [
            'label' => 'Pembiayaan',
            'gradient' => 'from-emerald-600 to-emerald-700',
            'overlay' => 'from-emerald-600/80 via-emerald-600/40 to-transparent',
            'hoverOverlay' => 'from-emerald-600/90 via-emerald-600/60 to-transparent',
            'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
            'accentColor' => 'emerald',
            'lightBg' => 'bg-emerald-50',
        ],
        'deposito_syariah' => [
            'label' => 'Deposito',
            'gradient' => 'from-amber-500 to-orange-500',
            'overlay' => 'from-amber-900/80 via-amber-800/40 to-transparent',
            'hoverOverlay' => 'from-amber-600/90 via-amber-500/60 to-transparent',
            'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
            'accentColor' => 'amber',
            'lightBg' => 'bg-amber-50',
        ],
    ];
@endphp

<div class="relative">
    <!-- Subtle pattern overlay -->
    <div class="absolute inset-0 opacity-[0.02] pointer-events-none" aria-hidden="true">
        <div class="absolute inset-0" style="background-image: repeating-linear-gradient(0deg, transparent, transparent 59px, #000 59px, #000 60px), repeating-linear-gradient(90deg, transparent, transparent 59px, #000 59px, #000 60px);"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-12 lg:mb-14 fade-in-section" x-intersect="$el.classList.add('is-visible')">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-semibold bg-emerald-50 dark:bg-emerald-100 text-emerald-700 dark:text-emerald-400 mb-4 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
                Produk & Layanan
            </span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-foreground tracking-tight mb-3">
                Solusi Keuangan Syariah
            </h2>
            <p class="text-secondary mx-auto text-base sm:text-lg leading-relaxed">
                Produk simpanan dan pembiayaan syariah untuk setiap kebutuhan finansial Anda
            </p>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @forelse($products as $index => $product)
            @php
                $cfg = $typeConfig[$product->type] ?? $typeConfig['simpanan_syariah'];
                $delay = $index * 100;
            @endphp
            <a href="{{ route('products.show', $product->slug) }}"
               class="group relative block bg-white dark:bg-muted rounded-2xl border border-border overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500"
               style="animation-delay: {{ $delay }}ms"
               x-intersect="$el.classList.add('animate-slide-up')">

                <!-- Image Area (60% of card) -->
                <div class="relative aspect-[4/3] overflow-hidden bg-muted">
                    @if($product->image)
                    <img
                         src="{{ \App\Helpers\StorageHelper::url($product->image) }}"
                         alt="{{ $product->name }}"
                         class="absolute inset-0 w-full h-full object-cover transition-all duration-700 group-hover:scale-110 group-hover:rotate-[2deg]"
                         loading="{{ $index < 3 ? 'eager' : 'lazy' }}"
                         decoding="async"
                         fetchpriority="{{ $index < 2 ? 'high' : 'auto' }}"
                    />
                    @else
                    <div class="absolute inset-0 bg-gradient-to-br {{ $cfg['gradient'] }} flex items-center justify-center">
                        <svg class="w-20 h-20 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $cfg['icon'] }}"/>
                        </svg>
                    </div>
                    @endif

                    <!-- Gradient Overlay (always visible) -->
                    <div class="absolute inset-0 bg-gradient-to-t {{ $cfg['overlay'] }} transition-opacity duration-500 group-hover:opacity-0"></div>

                    <!-- Hover Gradient Overlay (reveals on hover) -->
                    <div class="absolute inset-0 bg-gradient-to-t {{ $cfg['hoverOverlay'] }} opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                    <!-- Category Badge - floating top-left -->
                    <div class="absolute top-3 left-3 z-20">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold shadow-lg backdrop-blur-sm
                            {{ $cfg['accentColor'] === 'blue' ? 'bg-blue-500 text-white' : '' }}
                            {{ $cfg['accentColor'] === 'emerald' ? 'bg-emerald-600 text-white' : '' }}
                            {{ $cfg['accentColor'] === 'amber' ? 'bg-amber-500 text-white' : '' }}
                            transform group-hover:scale-105 transition-transform duration-300">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $cfg['icon'] }}"/>
                            </svg>
                            {{ $cfg['label'] }}
                        </span>
                    </div>

                    <!-- Floating Icon Overlay - center (visible on hover) -->
                    <div class="absolute inset-0 flex items-center justify-center z-20 opacity-0 group-hover:opacity-100 transition-all duration-500 transform translate-y-4 group-hover:translate-y-0">
                        <span class="flex items-center justify-center w-16 h-16 rounded-2xl bg-white/20 backdrop-blur-md border border-white/30 shadow-xl">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <!-- Content Area -->
                <div class="p-5 sm:p-6 flex flex-col flex-1">
                    <!-- Product Name -->
                    <h3 class="text-lg sm:text-xl font-bold text-foreground group-hover:text-emerald-600 transition-colors duration-300 leading-tight mb-2">
                        {{ $product->name }}
                    </h3>

                    <!-- Description - truncated to 2 lines -->
                    @if($product->short_description)
                    <p class="text-sm text-secondary leading-relaxed line-clamp-2 flex-1">
                        {{ $product->short_description }}
                    </p>
                    @else
                    <div class="flex-1"></div>
                    @endif

                    <!-- Bottom row: icon + CTA -->
                    <div class="flex items-center justify-between pt-4 mt-4 border-t border-border/50">
                        <div class="flex items-center gap-2">
                            <div class="flex -space-x-1.5">
                                <div class="w-6 h-6 rounded-full {{ $cfg['lightBg'] }} border-2 border-white flex items-center justify-center">
                                    <svg class="w-3 h-3 {{ $cfg['accentColor'] === 'blue' ? 'text-blue-500' : '' }}{{ $cfg['accentColor'] === 'emerald' ? 'text-emerald-600' : '' }}{{ $cfg['accentColor'] === 'amber' ? 'text-amber-500' : '' }}" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                    </svg>
                                </div>
                            </div>
                            <span class="text-xs text-secondary font-medium">Produk {{ $cfg['label'] }}</span>
                        </div>

                        <span class="inline-flex items-center gap-1.5 text-sm font-semibold
                            {{ $cfg['accentColor'] === 'blue' ? 'text-blue-600' : '' }}
                            {{ $cfg['accentColor'] === 'emerald' ? 'text-emerald-600' : '' }}
                            {{ $cfg['accentColor'] === 'amber' ? 'text-amber-600' : '' }}
                            group-hover:gap-2.5 transition-all duration-300">
                            Detail
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <!-- Bottom accent line -->
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r {{ $cfg['gradient'] }} transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
            </a>
            @empty
            <div class="col-span-full text-center py-16">
                <div class="w-20 h-20 rounded-full bg-muted flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                </div>                    <p class="text-foreground font-medium">Belum ada produk tersedia</p>
            </div>
            @endforelse
        </div>

        <!-- View All CTA -->
        <div class="text-center mt-12 lg:mt-14 fade-in-section" x-intersect="$el.classList.add('is-visible')">
            <a href="{{ route('products.simpanan-syariah') }}"
               class="group inline-flex items-center gap-2.5 px-7 py-3.5 rounded-xl font-bold bg-gradient-to-r from-emerald-600 to-emerald-700 text-white shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/40 hover:-translate-y-0.5 transition-all duration-300 btn-press">
                <span>Jelajahi Semua Produk</span>
                <svg class="w-4 h-4 group-hover:translate-x-1.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</div>
