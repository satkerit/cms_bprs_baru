@props(['whyChooseUsSettings', 'whyChooseUs'])

<!-- Why Choose Us Section -->
@if($whyChooseUsSettings?->is_active)
<div class="relative py-8 lg:py-0">
    <!-- Ambient Background -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
        <div class="absolute top-10 left-1/4 w-72 h-72 bg-emerald-50 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-10 right-1/4 w-80 h-80 bg-emerald-50 rounded-full blur-[100px]"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-center">

            <!-- â”€â”€â”€ LEFT: Feature Cards (Grid) â”€â”€â”€ -->
            <div class="order-2 lg:order-1">
                <div class="grid sm:grid-cols-2 gap-4">
                    @forelse($whyChooseUs as $index => $item)
                    @php
                        $delay = $index * 100;
                        $colorMap = [
                            'bg-emerald-50' => ['card' => 'border-emerald-200 hover:border-emerald-300', 'accent' => 'bg-emerald-600', 'icon' => 'text-emerald-600', 'ring' => 'ring-emerald-500/20'],
                            'bg-emerald-100' => ['card' => 'border-emerald-200 hover:border-emerald-300', 'accent' => 'bg-emerald-600', 'icon' => 'text-emerald-600', 'ring' => 'ring-emerald-500/20'],
                            'bg-amber-50' => ['card' => 'border-amber-200 hover:border-amber-300', 'accent' => 'bg-amber-500', 'icon' => 'text-amber-600', 'ring' => 'ring-amber-500/20'],
                            'bg-amber-100' => ['card' => 'border-amber-200 hover:border-amber-300', 'accent' => 'bg-amber-500', 'icon' => 'text-amber-600', 'ring' => 'ring-amber-500/20'],
                        ];
                        $bgClass = $item->bg_class ?? 'bg-emerald-50';
                        $colors = $colorMap[$bgClass] ?? $colorMap['bg-emerald-50'];
                    @endphp
                    <div class="group bg-white rounded-2xl border-2 {{ $colors['card'] }} p-5 sm:p-6 shadow-sm hover:shadow-lg transition-all duration-500 hover:-translate-y-1"
                         style="animation-delay: {{ $delay }}ms"
                         x-intersect="$el.classList.add('animate-slide-up')">
                        <!-- Icon -->
                        <div class="flex items-center justify-center w-12 h-12 rounded-xl {{ $bgClass }} {{ $colors['icon'] }} mb-4 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            @if($item->icon)
                            <img src="{{ \App\Helpers\StorageHelper::url($item->icon) }}" class="w-5 h-5 object-contain" alt="{{ $item->title }}" width="20" height="20" loading="lazy" />
                            @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            @endif
                        </div>

                        <!-- Title -->
                        <h4 class="text-base font-bold text-foreground mb-2 group-hover:text-emerald-600 transition-colors">{{ $item->title }}</h4>

                        <!-- Description (no change - still shown per original design) -->
                        <p class="text-sm text-secondary leading-relaxed">{{ $item->description }}</p>

                        <!-- Bottom accent -->
                        <div class="mt-4 w-8 h-0.5 rounded-full {{ $colors['accent'] }} opacity-50 group-hover:opacity-100 group-hover:w-12 transition-all duration-300"></div>
                    </div>
                    @empty
                    <!-- Default cards if no dynamic data -->
                    @php
                        $defaults = [
                            ['title' => 'Sesuai Prinsip Syariah', 'desc' => 'Seluruh produk dan layanan telah disetujui oleh Dewan Pengawas Syariah', 'bg' => 'bg-emerald-50', 'color' => 'text-emerald-600'],
                            ['title' => 'Aman & Terpercaya', 'desc' => 'Diawasi oleh OJK dan dijamin oleh LPS untuk keamanan dana Anda', 'bg' => 'bg-emerald-100', 'color' => 'text-emerald-600'],
                            ['title' => 'Proses Cepat & Mudah', 'desc' => 'Layanan yang efisien dengan proses transparan dan mudah dipahami', 'bg' => 'bg-amber-100', 'color' => 'text-amber-600'],
                            ['title' => 'Pelayanan Profesional', 'desc' => 'Tim kami berdedikasi memberikan pelayanan terbaik bagi nasabah', 'bg' => 'bg-amber-50', 'color' => 'text-amber-600'],
                        ];
                    @endphp
                    @foreach($defaults as $i => $d)
                    <div class="group bg-white rounded-2xl border-2 border-border hover:border-emerald-200 p-5 sm:p-6 shadow-sm hover:shadow-lg transition-all duration-500 hover:-translate-y-1"
                         style="animation-delay: {{ $i * 100 }}ms"
                         x-intersect="$el.classList.add('animate-slide-up')">
                        <div class="flex items-center justify-center w-12 h-12 rounded-xl {{ $d['bg'] }} {{ $d['color'] }} mb-4 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <h4 class="text-base font-bold text-foreground mb-2 group-hover:text-emerald-600 transition-colors">{{ $d['title'] }}</h4>
                        <p class="text-sm text-secondary leading-relaxed">{{ $d['desc'] }}</p>
                        <div class="mt-4 w-8 h-0.5 rounded-full {{ $d['bg'] }} opacity-50 group-hover:opacity-100 group-hover:w-12 transition-all duration-300"></div>
                    </div>
                    @endforeach
                    @endforelse
                </div>
            </div>

            <!-- â”€â”€â”€ RIGHT: Header + Image â”€â”€â”€ -->
            <div class="order-1 lg:order-2 fade-in-section" x-intersect="$el.classList.add('is-visible')">
                <!-- Section Label -->
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-semibold bg-emerald-50 text-emerald-700 mb-4 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Mengapa Memilih Kami
                </span>

                <!-- Title -->
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-foreground mb-4 leading-tight tracking-tight">
                    {!! $whyChooseUsSettings->section_title ?? 'Bank Syariah yang <span class="text-emerald-600">Terpercaya</span> dan Amanah' !!}
                </h2>

                <p class="text-secondary text-base sm:text-lg mb-8 leading-relaxed">
                    {{ $whyChooseUsSettings->section_subtitle ?? 'Kami berkomitmen memberikan layanan perbankan syariah terbaik dengan prinsip kehati-hatian dan kepatuhan terhadap syariah Islam.' }}
                </p>

                <!-- Image -->
                <div class="relative group">
                    <div class="relative rounded-2xl overflow-hidden shadow-lg border border-border">
                        @if($whyChooseUsSettings->section_image)
                        <img src="{{ \App\Helpers\StorageHelper::url($whyChooseUsSettings->section_image) }}"
                             alt="Why Choose Us"
                             class="w-full aspect-[4/3] sm:aspect-[16/9] lg:aspect-auto lg:h-[400px] object-cover transition-all duration-700 group-hover:scale-105"
                             loading="lazy"
                             decoding="async" />
                        @else
                        <div class="w-full aspect-[4/3] sm:aspect-[16/9] lg:aspect-auto lg:h-[400px] bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center">
                            <div class="text-center p-8">
                                <div class="w-20 h-20 mx-auto mb-4 rounded-2xl bg-white shadow-sm flex items-center justify-center">
                                    <svg class="w-10 h-10 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        @endif
                        <!-- Image overlay gradient -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                    </div>
                    <!-- Decorative offset frame -->
                    <div class="absolute -bottom-3 -left-3 w-full h-full rounded-2xl border-2 border-emerald-200 -z-10"></div>
                </div>
            </div>

        </div>
    </div>
</div>
@endif
