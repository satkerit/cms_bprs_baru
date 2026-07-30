@props(['auctions'])

<!-- Auctions Section -->
@if($auctions->count() > 0)
<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Section Header -->
        <div class="text-center mb-12 lg:mb-14 fade-in-section" x-intersect="$el.classList.add('is-visible')">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-semibold bg-amber-100 text-amber-700 mb-4 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Lelang Agunan
            </span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-foreground tracking-tight mb-3">
                Informasi Lelang Terbaru
            </h2>
            <p class="text-secondary mx-auto text-base sm:text-lg leading-relaxed">
                Temukan peluang investasi menarik melalui lelang agunan dari BPRS Bangka Belitung
            </p>
        </div>

        <!-- Auctions Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach($auctions as $index => $auction)
            @php
                $delay = $index * 100;
                $statusStyle = $auction->status === 'published' ? ['bg' => 'bg-emerald-600', 'text' => 'Dipublikasi'] :
                    ($auction->status === 'registration_open' ? ['bg' => 'bg-emerald-600', 'text' => 'Dibuka'] :
                    ($auction->status === 'auction_scheduled' ? ['bg' => 'bg-emerald-500', 'text' => 'Terjadwal'] :
                    ['bg' => 'bg-secondary/30', 'text' => $auction->status_label]));
            @endphp
            <a href="{{ route('auctions.show', $auction->slug) }}"
               class="group relative block bg-white rounded-2xl border border-border overflow-hidden shadow-sm hover:shadow-xl transition-all duration-500"
               style="animation-delay: {{ $delay }}ms"
               x-intersect="$el.classList.add('animate-slide-up')">

                <!-- Image -->
                <div class="relative aspect-[4/3] overflow-hidden bg-muted">
                    @if($auction->main_image)
                    <img src="{{ $auction->main_image }}"
                         alt="{{ $auction->title }}"
                         class="absolute inset-0 w-full h-full object-cover transition-all duration-700 group-hover:scale-110 group-hover:rotate-[2deg]"
                         loading="{{ $index < 3 ? 'eager' : 'lazy' }}"
                         decoding="async"
                         fetchpriority="{{ $index < 2 ? 'high' : 'auto' }}" />
                    @else
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center">
                        <svg class="w-20 h-20 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    @endif

                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-foreground/70 via-foreground/30 to-transparent transition-opacity duration-500 group-hover:opacity-0"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-emerald-600/80 via-emerald-500/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                    <!-- Status Badge - top left -->
                    <div class="absolute top-3 left-3 z-20">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold shadow-lg backdrop-blur-sm {{ $statusStyle['bg'] }} text-white transform group-hover:scale-105 transition-transform duration-300">
                            <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span>
                            {{ $statusStyle['text'] }}
                        </span>
                    </div>

                    <!-- Price overlay - bottom left (always visible) -->
                    <div class="absolute bottom-3 left-3 z-20">
                        <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-bold bg-white/90 backdrop-blur-sm text-emerald-700 shadow-lg">
                            <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $auction->formatted_limit_price }}
                        </span>
                    </div>

                    <!-- Sold Watermark -->
                    @if($auction->status === 'sold')
                    <div class="absolute inset-0 flex items-center justify-center bg-black/40 z-20 pointer-events-none" aria-hidden="true">
                        <div class="-rotate-12 bg-red-600/90 text-white py-2 px-8 text-xl font-black tracking-widest border-4 border-white uppercase backdrop-blur-sm shadow-xl">
                            TERJUAL
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Content -->
                <div class="p-5 sm:p-6">
                    <h3 class="text-base sm:text-lg font-bold text-foreground group-hover:text-emerald-600 transition-colors duration-300 leading-tight mb-3 line-clamp-2">
                        {{ $auction->title }}
                    </h3>

                    <div class="space-y-2 mb-4">
                        <div class="flex items-center text-xs text-secondary">
                            <svg class="w-3.5 h-3.5 mr-2 shrink-0 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            {{ $auction->city ?? 'Lokasi tidak tersedia' }}
                        </div>
                        <div class="flex items-center text-xs text-secondary">
                            <svg class="w-3.5 h-3.5 mr-2 shrink-0 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            {{ $auction->auction_date ? $auction->auction_date->format('d M Y') : 'Belum ditentukan' }}
                        </div>
                    </div>

                    <!-- Bottom CTA -->
                    <div class="flex items-center justify-between pt-2 border-t border-border">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-medium bg-emerald-50 text-emerald-700">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                Lelang
                            </span>
                        </div>
                        <span class="inline-flex items-center gap-1.5 text-sm font-semibold text-emerald-600 group-hover:gap-2.5 transition-all duration-300">
                            Detail
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <!-- Bottom accent -->
                <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 to-emerald-600 transform scale-x-0 group-hover:scale-x-100 transition-transform duration-500 origin-left"></div>
            </a>
            @endforeach
        </div>

        <!-- View All Button -->
        <div class="text-center mt-12 lg:mt-14 fade-in-section" x-intersect="$el.classList.add('is-visible')">
            <a href="{{ route('auctions.index') }}"
               class="group inline-flex items-center gap-2.5 px-7 py-3.5 rounded-xl font-bold bg-gradient-to-r from-emerald-600 to-emerald-700 text-white shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/40 hover:-translate-y-0.5 transition-all duration-300 btn-press">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <span>Lihat Semua Lelang</span>
                <svg class="w-4 h-4 group-hover:translate-x-1.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</div>
@endif
