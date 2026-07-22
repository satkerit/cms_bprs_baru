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
    <section class="bg-white border-b border-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex flex-wrap items-center justify-center gap-x-10 gap-y-4 md:divide-x md:divide-border">
                <div class="flex items-center gap-3 px-4">
                    <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-foreground leading-tight">Terdaftar & Diawasi OJK</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 px-4">
                    <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-blue-50 text-blue-600 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-foreground leading-tight">Dijamin oleh LPS</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 px-4">
                    <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-amber-50 text-amber-600 shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-foreground leading-tight">Sesuai Prinsip Syariah</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 px-4">
                    <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 shrink-0">
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
    <section class="relative py-16 lg:py-20 overflow-hidden">
        <div class="absolute inset-0 gradient-primary-deep"></div>
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.04\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-40"></div>
        <div class="absolute top-10 left-10 w-64 h-64 bg-yellow-300/15 rounded-full blur-3xl animate-float-slow"></div>
        <div class="absolute bottom-10 right-10 w-80 h-80 bg-yellow-300/15 rounded-full blur-3xl animate-float-slow" style="animation-delay: 3s;"></div>

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
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/10 hover:bg-white/15 transition-all duration-300 min-h-[180px] flex flex-col">
                        <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-800/30 mb-4">
                            <svg class="w-6 h-6 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h4 class="text-white font-semibold text-sm mb-1">Perhitungan Cepat</h4>
                        <p class="text-xs text-white/80">Hasil simulasi instan dalam hitungan detik</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/10 hover:bg-white/15 transition-all duration-300 min-h-[180px] flex flex-col">
                        <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-800/30 mb-4">
                            <svg class="w-6 h-6 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <h4 class="text-white font-semibold text-sm mb-1">Transparan</h4>
                        <p class="text-xs text-white/80">Tanpa biaya tersembunyi, semua jelas</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/10 hover:bg-white/15 transition-all duration-300 min-h-[180px] flex flex-col">
                        <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-800/30 mb-4">
                            <svg class="w-6 h-6 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                        <h4 class="text-white font-semibold text-sm mb-1">Sesuai Kemampuan</h4>
                        <p class="text-xs text-white/80">Sesuaikan dengan budget Anda</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/10 hover:bg-white/15 transition-all duration-300 min-h-[180px] flex flex-col">
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

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($news as $index => $item)
                <x-frontend.card
                    :title="$item->title"
                    :subtitle="$item->published_at->format('d M Y')"
                    :image="$item->featured_image ? \App\Helpers\StorageHelper::url($item->featured_image) : null"
                    :href="route('news.show', $item->slug)"
                    class="fade-in-section"
                    x-intersect="$el.classList.add('is-visible')"
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
            <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-3xl p-8 sm:p-12 lg:p-16 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-yellow-300/15 rounded-full -mr-20 -mt-20 animate-float-slow"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-yellow-300/15 rounded-full -ml-16 -mb-16 animate-float-slow" style="animation-delay: 3s;"></div>

                <div class="relative text-center mx-auto">
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4 tracking-tight">Siap Memulai?</h2>
                    <p class="text-white/90 text-base sm:text-lg mb-8 leading-relaxed">
                        Hubungi kami untuk informasi lebih lanjut. Tim kami siap membantu Anda dengan layanan perbankan syariah terbaik.
                    </p>
                    <div class="flex flex-wrap justify-center gap-3">
                        <a href="{{ route('contact') }}"
                           class="inline-flex items-center gap-2 px-6 py-3.5 bg-white text-emerald-600 font-bold rounded-xl shadow-lg hover:bg-emerald-50 transition-all duration-300 btn-press">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            Hubungi Kami
                        </a>
                        <a href="{{ route('about.offices') }}"
                           class="inline-flex items-center gap-2 px-6 py-3.5 bg-white/10 backdrop-blur-sm text-white font-semibold rounded-xl border border-white/25 hover:bg-white/20 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Temukan Kantor
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-frontend-layout>
