<x-frontend-layout>
    <x-slot:title>Beranda - BPRS Bangka Belitung</x-slot:title>
    <x-slot:metaDescription>BPRS Bangka Belitung - Bank Pembiayaan Rakyat Syariah terpercaya di Bangka Belitung. Menyediakan produk simpanan syariah, pembiayaan syariah, deposito syariah, dan kas keliling untuk masyarakat.</x-slot:metaDescription>
    <x-slot:metaKeywords>BPRS Bangka Belitung, Bank Syariah, Simpanan Syariah, Pembiayaan Syariah, Deposito Syariah, Kas Keliling, BPR Syariah, Bangka, Belitung</x-slot:metaKeywords>
    @if(isset($firstHeroImage))
    @push('head')
    @php
        $firstId = $heroSlides->first()?->id;
        $firstImgs = $firstId ? ($heroSlideImages[$firstId] ?? []) : [];
        $compressedFirstImage = $firstImgs['compressed'] ?? $firstHeroImage;
        $avifFirst = $firstImgs['avif_responsive'] ?? [];
        $webpFirst = $firstImgs['webp_responsive'] ?? [];
    @endphp
    @if(!empty($avifFirst['desktop']))
    <link rel="preload" as="image" href="{{ \App\Helpers\StorageHelper::url($avifFirst['desktop']) }}" fetchpriority="high" type="image/avif">
    @elseif(!empty($webpFirst['desktop']))
    <link rel="preload" as="image" href="{{ \App\Helpers\StorageHelper::url($webpFirst['desktop']) }}" fetchpriority="high" type="image/webp">
    @else
    <link rel="preload" as="image" href="{{ \App\Helpers\StorageHelper::url($compressedFirstImage) }}" fetchpriority="high">
    @endif
    @if(!empty($avifFirst['mobile']))
    <link rel="preload" as="image" href="{{ \App\Helpers\StorageHelper::url($avifFirst['mobile']) }}" media="(max-width: 640px)" type="image/avif">
    @elseif(!empty($webpFirst['mobile']))
    <link rel="preload" as="image" href="{{ \App\Helpers\StorageHelper::url($webpFirst['mobile']) }}" media="(max-width: 640px)" type="image/webp">
    @endif
    @endpush
    @endif

    <!-- ═══ HERO SLIDER ═══ -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 mb-2">
        <x-frontend.hero-slider :hero-slides="$heroSlides" :hero-slide-images="$heroSlideImages ?? []" :hero-slider-delay="$heroSliderDelay ?? 5000" />
    </div>

    <!-- ═══ TRUST BADGES ═══ -->
    <section class="bg-white border-b border-border" x-data>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-wrap items-center justify-center gap-x-10 gap-y-4 md:divide-x md:divide-border"
                 x-intersect="$el.querySelectorAll('.trust-badge').forEach((el, i) => { setTimeout(() => el.classList.add('is-visible'), i * 100) })">
                <div class="flex items-center gap-3 px-4 trust-badge fade-in-section">
                    <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 shrink-0 group hover:scale-110 hover:rotate-3 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-foreground leading-tight">Terdaftar & Diawasi OJK</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 px-4 trust-badge fade-in-section">
                    <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-amber-50 text-amber-600 shrink-0 group hover:scale-110 hover:rotate-3 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-foreground leading-tight">Dijamin oleh LPS</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 px-4 trust-badge fade-in-section">
                    <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-amber-50 text-amber-600 shrink-0 group hover:scale-110 hover:rotate-3 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-foreground leading-tight">Sesuai Prinsip Syariah</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 px-4 trust-badge fade-in-section">
                    <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 shrink-0 group hover:scale-110 hover:rotate-3 transition-all duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-foreground leading-tight">BPRS Bangka Belitung</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ WHY CHOOSE US ═══ -->
    <section class="py-16 lg:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-frontend.why-choose-us :why-choose-us-settings="$whyChooseUsSettings" :why-choose-us="$whyChooseUs" />
        </div>
    </section>

    <!-- ═══ PRODUCTS ═══ -->
    <section class="py-16 lg:py-20 bg-muted">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-frontend.products-section :products="$products" />
        </div>
    </section>

    <!-- ═══ CTA - FINANCING SIMULATION ═══ -->
    <section class="relative py-16 lg:py-20 overflow-hidden" x-data="{ scrollOffset: 0 }"
             x-init="window.addEventListener('scroll', () => { scrollOffset = window.scrollY; }, { passive: true })">
        <div class="absolute inset-0 hero-gradient"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.04\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-40"></div>
        <!-- Parallax decorative circles -->
        <div class="absolute top-10 left-10 w-64 h-64 bg-yellow-300/15 rounded-full blur-3xl animate-float-slow"
             :style="{ transform: `translateY(${scrollOffset * 0.04}px)` }"></div>
        <div class="absolute bottom-10 right-10 w-80 h-80 bg-yellow-300/15 rounded-full blur-3xl animate-float-slow"
             :style="{ transform: `translateY(${-scrollOffset * 0.03}px)` }"
             style="animation-delay: 3s;"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                <!-- Left Content -->
                <div class="text-center lg:text-left fade-in-section" x-intersect="$el.classList.add('is-visible')">
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-full text-yellow-200 text-xs font-semibold border border-white/20 mb-4">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                        Simulasi Pembiayaan
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4 leading-tight tracking-tight">
                        Hitung Angsuran<br class="hidden sm:block">
                        <span class="text-yellow-200">Pembiayaan Anda</span>
                    </h2>
                    <p class="text-base text-white/90 mb-8 leading-relaxed lg:mx-0 mx-auto">
                        Gunakan kalkulator simulasi pembiayaan syariah kami untuk menghitung perkiraan angsuran bulanan sesuai dengan kemampuan Anda. Cepat, mudah, dan transparan.
                    </p>
                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-3">
                        <a href="{{ route('financing-simulation') }}"
                           class="group inline-flex items-center gap-2 px-6 py-3.5 bg-white text-emerald-600 font-bold rounded-xl shadow-lg shadow-black/20 hover:bg-emerald-50 transition-all duration-300 btn-press">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            <span>Coba Simulasi Sekarang</span>
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        <a href="{{ route('products.simpanan-syariah') }}"
                           class="inline-flex items-center gap-2 px-5 py-3.5 text-white font-semibold border border-white/30 rounded-xl hover:bg-white/10 transition-all duration-300 text-sm">
                            Lihat Produk
                        </a>
                    </div>
                </div>

                <!-- Right - Feature Cards -->
                <div class="hidden lg:grid grid-cols-2 gap-4 fade-in-section" x-intersect="$el.classList.add('is-visible')">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/10 hover:bg-white/15 hover:-translate-y-0.5 transition-all duration-300 min-h-[180px] flex flex-col">
                        <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-800/30 mb-4">
                            <svg class="w-6 h-6 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h4 class="text-white font-semibold text-sm mb-1">Perhitungan Cepat</h4>
                        <p class="text-xs text-white/80">Hasil simulasi instan dalam hitungan detik</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/10 hover:bg-white/15 hover:-translate-y-0.5 transition-all duration-300 min-h-[180px] flex flex-col">
                        <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-800/30 mb-4">
                            <svg class="w-6 h-6 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <h4 class="text-white font-semibold text-sm mb-1">Transparan</h4>
                        <p class="text-xs text-white/80">Tanpa biaya tersembunyi, semua jelas</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/10 hover:bg-white/15 hover:-translate-y-0.5 transition-all duration-300 min-h-[180px] flex flex-col">
                        <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-800/30 mb-4">
                            <svg class="w-6 h-6 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                        <h4 class="text-white font-semibold text-sm mb-1">Sesuai Kemampuan</h4>
                        <p class="text-xs text-white/80">Sesuaikan dengan budget Anda</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/10 hover:bg-white/15 hover:-translate-y-0.5 transition-all duration-300 min-h-[180px] flex flex-col">
                        <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-800/30 mb-4">
                            <svg class="w-6 h-6 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <h4 class="text-white font-semibold text-sm mb-1">100% Gratis</h4>
                        <p class="text-xs text-white/80">Tidak dipungut biaya apapun</p>
                    </div>
                </div>

                <!-- Mobile Feature Pills -->
                <div class="lg:hidden flex flex-wrap justify-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-full text-white/90 text-xs border border-white/20">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Perhitungan Cepat
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-full text-white/90 text-xs border border-white/20">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Transparan
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-full text-white/90 text-xs border border-white/20">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        100% Gratis
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ STATS ═══ -->
    <section class="py-16 lg:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-frontend.stats-section :company-info="$companyInfo" />
        </div>
    </section>

    <!-- ═══ AUCTIONS ═══ -->
    <section class="py-16 lg:py-20 bg-muted">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-frontend.auctions-section :auctions="$auctions" />
        </div>
    </section>

    <!-- ═══ NEWS ═══ -->
    <section class="py-16 lg:py-20 bg-white" aria-labelledby="news-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12">
                <div class="fade-in-section" x-intersect="$el.classList.add('is-visible')">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 rounded-full mb-3">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                        <span class="text-xs font-semibold text-emerald-600">Berita & Artikel</span>
                    </div>
                    <h2 id="news-heading" class="text-3xl sm:text-4xl font-bold text-foreground tracking-tight">Informasi Terkini</h2>
                    <p class="text-foreground mt-2">Ikuti perkembangan dan informasi terbaru dari BPRS Bangka Belitung</p>
                </div>
                <a href="{{ route('news.index') }}"
                   class="inline-flex items-center gap-1.5 text-emerald-600 font-semibold text-sm mt-4 sm:mt-0 hover:text-emerald-700 transition-colors shrink-0 btn-press">
                    Lihat Semua Berita
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                 x-intersect="$el.querySelectorAll('.news-card').forEach((el, i) => { setTimeout(() => el.classList.add('is-visible'), i * 120) })">
                @forelse($news as $index => $item)
                <x-frontend.card
                    :title="$item->title"
                    :subtitle="$item->published_at->format('d M Y')"
                    :image="$item->featured_image ? \App\Helpers\StorageHelper::url($item->featured_image) : null"
                    :href="route('news.show', $item->slug)"
                    class="news-card fade-in-section image-zoom"
                >
                    {{ $item->excerpt }}
                </x-frontend.card>
                @empty
                <div class="col-span-full text-center py-16">
                    <div class="flex items-center justify-center w-16 h-16 rounded-2xl bg-muted mx-auto mb-4">
                        <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    <p class="text-foreground">Belum ada berita tersedia</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- ═══ COMPLAINT & WHISTLEBLOWING ═══ -->
    <section class="py-16 lg:py-20 bg-white border-y border-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 fade-in-section" x-intersect="$el.classList.add('is-visible')">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-white rounded-full border border-border mb-4 text-secondary shadow-sm">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                    <span class="text-xs font-semibold uppercase tracking-wider">Layanan Pengaduan</span>
                </div>
                <h2 class="text-3xl sm:text-4xl font-bold text-foreground mb-3 leading-tight tracking-tight">
                    Kami Siap Mendengar Anda
                </h2>
                <p class="text-sm text-secondary mx-auto">
                    Sampaikan keluhan, masukan, atau laporan pelanggaran Anda. Setiap pengaduan akan ditangani secara profesional dan rahasia.
                </p>
            </div>

            <div class="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto">
                <!-- Pengaduan Nasabah -->
                <a href="{{ route('pengaduan-nasabah') }}"
                   class="group bg-white border border-border rounded-2xl p-6 shadow-sm hover:border-emerald-200 hover:shadow-lg transition-all duration-300 card-hover">
                    <div class="flex items-start gap-4">
                        <div class="shrink-0 flex items-center justify-center w-14 h-14 rounded-xl bg-emerald-50 border border-emerald-100 group-hover:bg-emerald-100 group-hover:scale-105 transition-all duration-300">
                            <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-foreground group-hover:text-emerald-600 transition-colors">Pengaduan Nasabah</h3>
                            <p class="text-sm text-secondary mt-1.5 leading-relaxed">Sampaikan keluhan atau masukan Anda untuk meningkatkan kualitas layanan kami.</p>
                            <span class="inline-flex items-center gap-1 text-emerald-600 font-semibold text-sm mt-3 group-hover:gap-2 transition-all">
                                Selengkapnya
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        </div>
                    </div>
                </a>

                <!-- Whistleblowing -->
                <a href="{{ route('whistleblowing') }}"
                   class="group bg-white border border-border rounded-2xl p-6 shadow-sm hover:border-red-200 hover:shadow-lg transition-all duration-300 card-hover">
                    <div class="flex items-start gap-4">
                        <div class="shrink-0 flex items-center justify-center w-14 h-14 rounded-xl bg-red-50 border border-red-100 group-hover:bg-red-100 group-hover:scale-105 transition-all duration-300">
                            <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-bold text-foreground group-hover:text-red-700 transition-colors">Whistleblowing System</h3>
                            <p class="text-sm text-secondary mt-1.5 leading-relaxed">Laporkan dugaan pelanggaran dengan aman dan terjamin kerahasiaannya.</p>
                            <span class="inline-flex items-center gap-1 text-red-600 font-semibold text-sm mt-3 group-hover:gap-2 transition-all">
                                Selengkapnya
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- ═══ CONTACT CTA ═══ -->
    <section class="py-16 lg:py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-3xl p-8 sm:p-12 lg:p-16 relative overflow-hidden fade-in-section"
                 x-intersect="$el.classList.add('is-visible')">
                <div class="absolute top-0 right-0 w-64 h-64 bg-yellow-300/15 rounded-full -mr-20 -mt-20 animate-float-slow"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-yellow-300/15 rounded-full -ml-16 -mb-16 animate-float-slow" style="animation-delay: 3s;"></div>

                <div class="relative text-center mx-auto">
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4 tracking-tight">Siap Memulai?</h2>
                    <p class="text-white/90 text-base sm:text-lg mb-8 leading-relaxed">
                        Hubungi kami untuk informasi lebih lanjut. Tim kami siap membantu Anda dengan layanan perbankan syariah terbaik.
                    </p>
                    <div class="flex flex-wrap justify-center gap-3">
                        <a href="{{ route('contact') }}"
                           class="group inline-flex items-center gap-2 px-6 py-3.5 bg-white text-emerald-600 font-bold rounded-xl shadow-lg hover:bg-emerald-50 transition-all duration-300 btn-press">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            Hubungi Kami
                        </a>
                        <a href="{{ route('about.offices') }}"
                           class="inline-flex items-center gap-2 px-6 py-3.5 bg-white/10 backdrop-blur-sm text-white font-semibold rounded-xl border border-white/25 hover:bg-white/20 hover:-translate-y-0.5 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Temukan Kantor
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- ═══ Floating Prayer Time Widget ═══ -->
<div id="pfw-wrap" class="fixed right-4 bottom-4 z-50 pfw-hide">
    <style nonce="{{ $nonce }}">
        #pfw-wrap * { box-sizing:border-box; }
        #pfw-wrap .pfw-box { width:320px; max-height:75vh; overflow-y:auto; background:linear-gradient(135deg,#059669,#065f46); border-radius:16px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.4); }
        #pfw-wrap .pfw-toggle-btn { position:absolute; left:0; bottom:24px; transform:translateX(-100%); background:#059669; color:#fff; border:none; padding:10px 14px; border-radius:12px 0 0 12px; cursor:pointer; box-shadow:0 10px 25px rgba(0,0,0,0.2); transition:all .3s; z-index:10; }
        #pfw-wrap .pfw-toggle-btn:hover { background:#047857; }
        #pfw-wrap.pfw-hide .pfw-box { display:none; }
        #pfw-wrap.pfw-hide .pfw-toggle-btn { opacity:1; }
        #pfw-wrap:not(.pfw-hide) .pfw-toggle-btn { opacity:0; }
        #pfw-wrap:hover:not(.pfw-hide) .pfw-toggle-btn { opacity:1; }
        @keyframes pfw-spin { to{transform:rotate(360deg)} }
        @keyframes pfw-float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-6px)} }
        @keyframes pfw-glow { 0%,100%{box-shadow:0 0 8px rgba(255,255,255,0.15)} 50%{box-shadow:0 0 22px rgba(255,255,255,0.35)} }
        @keyframes pfw-tick { 0%{transform:scale(1)} 50%{transform:scale(1.15)} 100%{transform:scale(1)} }
        @keyframes pfw-up { from{opacity:0;transform:translateY(12px)} to{opacity:1;transform:translateY(0)} }
        .pfw-spin { animation:pfw-spin .8s linear infinite; }
        .pfw-float { animation:pfw-float 4s ease-in-out infinite; }
        .pfw-glow { animation:pfw-glow 3s ease-in-out infinite; }
        .pfw-tick { animation:pfw-tick .15s ease-out; }
        .pfw-up { opacity:0; animation:pfw-up .5s cubic-bezier(0.16,1,0.3,1) forwards; }
        .pfw-entry { transition:background .2s; }
        .pfw-entry:hover { background:rgba(255,255,255,0.12) !important; }
        .pfw-entry.pfw-next:hover { background:rgba(255,255,255,0.28) !important; }
    </style>
    <button id="pfw-toggle" class="pfw-toggle-btn" aria-label="Toggle">
        <svg id="pfw-ico" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
    </button>
    <div class="pfw-box">
        <div class="pfw-up" style="padding:16px 20px;background:rgba(255,255,255,0.1);border-bottom:1px solid rgba(255,255,255,0.15);backdrop-filter:blur(8px)">
            <div class="pfw-up" style="animation-delay:.05s;display:flex;align-items:center;justify-content:space-between">
                <div style="display:flex;align-items:center;gap:12px">
                    <div class="pfw-float" style="width:40px;height:40px;background:rgba(255,255,255,0.2);border-radius:10px;display:flex;align-items:center;justify-content:center">
                        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color:#fff"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div><div style="color:#fff;font-weight:700;font-size:15px">Jadwal Sholat</div><div id="pfw-loc" style="color:rgba(255,255,255,0.7);font-size:13px">Memuat...</div></div>
                </div>
                <button id="pfw-refresh" style="padding:8px;background:none;border:none;cursor:pointer;border-radius:8px;color:#fff" title="Perbarui"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg></button>
            </div>
        </div>
        <div class="pfw-up" style="animation-delay:.1s;padding:10px 20px;background:rgba(255,255,255,0.05);border-bottom:1px solid rgba(255,255,255,0.1);text-align:center">
            <div id="pfw-clock" style="font-size:24px;font-weight:700;color:#fff"></div>
            <div id="pfw-date" style="color:rgba(255,255,255,0.7);font-size:13px"></div>
        </div>
        <div id="pfw-next" class="pfw-up pfw-glow" style="animation-delay:.15s;padding:14px 20px;background:rgba(255,255,255,0.1);border-bottom:1px solid rgba(255,255,255,0.1);text-align:center;display:none">
            <div style="color:rgba(255,255,255,0.7);font-size:13px;margin-bottom:4px">Menuju</div>
            <div id="pfw-nx" style="color:#fff;font-weight:700;font-size:16px;margin-bottom:10px"></div>
            <div style="display:flex;align-items:center;justify-content:center;gap:8px">
                <div style="background:rgba(255,255,255,0.2);border-radius:8px;padding:8px 12px;min-width:52px;backdrop-filter:blur(4px)"><div id="pfw-ch" style="font-size:20px;font-weight:700;color:#fff"></div><div style="color:rgba(255,255,255,0.7);font-size:11px">Jam</div></div>
                <div style="color:#fff;font-size:16px;animation:pfw-float 4s ease-in-out infinite">:</div>
                <div style="background:rgba(255,255,255,0.2);border-radius:8px;padding:8px 12px;min-width:52px;backdrop-filter:blur(4px)"><div id="pfw-cm" style="font-size:20px;font-weight:700;color:#fff"></div><div style="color:rgba(255,255,255,0.7);font-size:11px">Menit</div></div>
                <div style="color:#fff;font-size:16px;animation:pfw-float 4s ease-in-out infinite">:</div>
                <div style="background:rgba(255,255,255,0.2);border-radius:8px;padding:8px 12px;min-width:52px;backdrop-filter:blur(4px)"><div id="pfw-cs" style="font-size:20px;font-weight:700;color:#fff"></div><div style="color:rgba(255,255,255,0.7);font-size:11px">Detik</div></div>
            </div>
        </div>
        <div id="pfw-list" style="padding:16px 20px">
            <div id="pfw-load" style="text-align:center;padding:20px 0"><div class="pfw-spin" style="display:inline-block;width:28px;height:28px;border:3px solid rgba(255,255,255,0.2);border-top-color:#fff;border-radius:50%"></div><p style="color:rgba(255,255,255,0.8);font-size:13px;margin-top:10px">Memuat...</p></div>
            <div id="pfw-err" style="text-align:center;padding:16px 0;display:none"><p id="pfw-err-msg" style="color:rgba(255,255,255,0.9);font-size:13px;margin-bottom:10px"></p><button id="pfw-retry" style="padding:8px 18px;background:rgba(255,255,255,0.2);border:none;color:#fff;border-radius:8px;cursor:pointer;font-size:13px">Coba Lagi</button></div>
            <div id="pfw-times" style="display:none"></div>
        </div>
        <div class="pfw-up" style="animation-delay:.3s;padding:10px 20px;background:rgba(255,255,255,0.05);border-top:1px solid rgba(255,255,255,0.1);text-align:center"><p style="color:rgba(255,255,255,0.5);font-size:11px">Diperbarui otomatis setiap hari</p></div>
    </div>
</div>

@push('scripts')
<script nonce="{{ $nonce }}">
(function(){ 'use strict';
    var w=document.getElementById('pfw-wrap'), b=w.querySelector('.pfw-box'), t=document.getElementById('pfw-toggle'), ic=document.getElementById('pfw-ico'),
        loc=document.getElementById('pfw-loc'), clock=document.getElementById('pfw-clock'), dateEl=document.getElementById('pfw-date'),
        nx=document.getElementById('pfw-next'), nxName=document.getElementById('pfw-nx'),
        ch=document.getElementById('pfw-ch'), cm=document.getElementById('pfw-cm'), cs=document.getElementById('pfw-cs'),
        loadEl=document.getElementById('pfw-load'), errEl=document.getElementById('pfw-err'), errMsg=document.getElementById('pfw-err-msg'),
        timesEl=document.getElementById('pfw-times');
    var S={min:true,lat:-6.2088,lng:106.8456,loc:'Jakarta, Indonesia',times:[],next:null,cd:{h:'00',m:'00',s:'00'},intvls:[],hideTO:null};
    function toggle(){S.min=!S.min;S.min?w.classList.add('pfw-hide'):(w.style.display='',w.classList.remove('pfw-hide'));t.style.opacity=S.min?'1':'0';ic.innerHTML=S.min?'<path d=\"M15 19l-7-7 7-7\"/>':'<path d=\"M9 5l7 7-7 7\"/>';cancelHide();}
    function cancelHide(){clearTimeout(S.hideTO);}
    function scheduleHide(delay){cancelHide();if(!S.min){S.hideTO=setTimeout(function(){if(!S.min){toggle();}},delay||2500);}}
    w.addEventListener('mouseenter',function(){cancelHide();if(S.min){toggle();}},false);
    w.addEventListener('mouseleave',function(){scheduleHide(2500);},false);
    function loadTimes(){loadEl.style.display='';errEl.style.display='none';timesEl.style.display='none';_ft(0);}
    function _ft(r){var d=new Date(),ds=d.getFullYear()+'-'+String(d.getMonth()+1).padStart(2,'0')+'-'+String(d.getDate()).padStart(2,'0');
        fetch('https://api.aladhan.com/v1/timings/'+ds+'?latitude='+S.lat+'&longitude='+S.lng+'&method=11').then(function(r){return r.json()}).then(function(d){
            if(d.code!==200||!d.data)throw Error();
            try{localStorage.setItem('pfw_cache',JSON.stringify({lat:S.lat,lng:S.lng,data:d.data}));}catch(e){}
            _renderTimes(d.data);
        }).catch(function(){
            if(r<2){setTimeout(function(){_ft(r+1);},2000*(r+1));return;}
            try{var c=JSON.parse(localStorage.getItem('pfw_cache'));if(c&&c.data){_renderTimes(c.data);loadEl.style.display='none';return;}}catch(e){}
            loadEl.style.display='none';errEl.style.display='';errMsg.textContent='Gagal memuat jadwal sholat. Periksa koneksi.';
        });}
    function _renderTimes(data){var timings=data.timings,list=[{n:'Subuh',k:'Fajr'},{n:'Dzuhur',k:'Dhuhr'},{n:'Ashar',k:'Asr'},{n:'Maghrib',k:'Maghrib'},{n:'Isya',k:'Isha'}];
        var now=new Date(),cur=now.getHours()*3600+now.getMinutes()*60+now.getSeconds(),times=[],next=null;
        for(var i=0;i<list.length;i++){var p=list[i],ts=timings[p.k];if(!ts)continue;var pt=ts.split(':'),sec=parseInt(pt[0])*3600+parseInt(pt[1])*60;
        times.push({n:p.n,t:pt[0]+':'+pt[1],nx:false});if(!next&&sec>cur){next={n:p.n,t:pt[0]+':'+pt[1],s:sec-cur};times[times.length-1].nx=true;}}
        S.times=times;S.next=next;
        var html='',icons=['🌅','☀️','🌤️','🌆','🌙'];
        for(i=0;i<times.length;i++){var x=times[i];html+='<div class=\"pfw-up pfw-entry'+(x.nx?' pfw-next':'')+'\" style=\"animation-delay:'+(.15+i*0.08)+'s;display:flex;align-items:center;justify-content:space-between;padding:10px 14px;border-radius:10px;margin-bottom:6px;background:'+(x.nx?'rgba(255,255,255,0.2);box-shadow:0 0 0 1px rgba(255,255,255,0.4)':'rgba(255,255,255,0.05)')+'\">'+
            '<div style=\"display:flex;align-items:center;gap:10px\"><div style=\"width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;background:'+(x.nx?'rgba(255,255,255,0.3)':'rgba(255,255,255,0.1)')+'\">'+(icons[i]||'')+'</div><span style=\"color:#fff;font-weight:500;font-size:15px\">'+x.n+'</span></div>'+
            '<div style=\"text-align:right\"><div style=\"color:#fff;font-weight:700;font-size:15px\">'+x.t+'</div>'+(x.nx?'<div style=\"color:rgba(255,255,255,0.8);font-size:11px\">Selanjutnya</div>':'')+'</div></div>';}
        timesEl.innerHTML=html;timesEl.style.display='';
        if(next){nx.style.display='';nxName.textContent=next.n;_.startCD(next.s);}else{nx.style.display='none';}}
    t.addEventListener('click',toggle,false);
    document.getElementById('pfw-refresh').addEventListener('click',loadTimes,false);
    document.getElementById('pfw-retry').addEventListener('click',loadTimes,false);
    var _={startCD:function(sec){for(var i=1;i<S.intvls.length;i++)clearInterval(S.intvls[i]);S.intvls=[S.intvls[0]];
        var r=sec;S.intvls.push(setInterval(function(){if(r<=0){loadTimes();return;}r--;
            var h=Math.floor(r/3600),m=Math.floor((r%3600)/60),s=r%60,prev=S.cd.s;
            S.cd={h:String(h).padStart(2,'0'),m:String(m).padStart(2,'0'),s:String(s).padStart(2,'0')};
            ch.textContent=S.cd.h;cm.textContent=S.cd.m;cs.textContent=S.cd.s;
            if(S.cd.s!==prev){cs.classList.remove('pfw-tick');void cs.offsetWidth;cs.classList.add('pfw-tick');}
        },1000));}};
    var ci=setInterval(function(){var n=new Date();clock.textContent=String(n.getHours()).padStart(2,'0')+':'+String(n.getMinutes()).padStart(2,'0')+':'+String(n.getSeconds()).padStart(2,'0');
        dateEl.textContent=['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'][n.getDay()]+', '+n.getDate()+' '+['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'][n.getMonth()]+' '+n.getFullYear();},1000);
    S.intvls.push(ci);
    if(navigator.geolocation){navigator.geolocation.getCurrentPosition(function(p){S.lat=p.coords.latitude;S.lng=p.coords.longitude;
        fetch('https://nominatim.openstreetmap.org/reverse?lat='+S.lat+'&lon='+S.lng+'&format=json').then(function(r){return r.json()}).then(function(d){
            if(d.address){var c=d.address.city||d.address.town||d.address.village||d.address.county;if(c){S.loc=c+', '+(d.address.state||'Indonesia');loc.textContent=S.loc;}}
        }).catch(function(){});loadTimes();},function(){loadTimes();},{timeout:10000,maximumAge:300000,enableHighAccuracy:false});}else{loadTimes();}
    cancelHide();
})();
</script>
@endpush
</x-frontend-layout>
