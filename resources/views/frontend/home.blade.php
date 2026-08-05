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

    {{-- ═══ HERO SLIDER ═══ --}}
    {{-- pt = memberi ruang untuk floating island navbar --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-6 sm:pb-8">
        <x-frontend.hero-slider :hero-slides="$heroSlides" :hero-slide-images="$heroSlideImages ?? []" :hero-slider-delay="$heroSliderDelay ?? 5000" />
    </div>

    {{-- ═══ TRUST BADGES ═══ --}}
    <section class="relative">
        <div class="absolute inset-0 bg-gradient-to-b from-emerald-50/30 dark:from-emerald-950/20 to-transparent pointer-events-none"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">
            <div class="flex flex-wrap items-center justify-center gap-3 lg:gap-5">
                <div class="flex items-center gap-2.5 px-4 py-2.5 rounded-full bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm border border-emerald-100/50 dark:border-emerald-900/50 shadow-sm hover:shadow-md hover:border-emerald-200 dark:hover:border-emerald-700 transition-all duration-300">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <span class="text-xs sm:text-sm font-semibold text-foreground">Terdaftar & Diawasi OJK</span>
                </div>
                <div class="flex items-center gap-2.5 px-4 py-2.5 rounded-full bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm border border-amber-100/50 dark:border-amber-900/50 shadow-sm hover:shadow-md hover:border-amber-200 dark:hover:border-amber-700 transition-all duration-300">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-amber-50 text-amber-600 shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <span class="text-xs sm:text-sm font-semibold text-foreground">Dijamin oleh LPS</span>
                </div>
                <div class="flex items-center gap-2.5 px-4 py-2.5 rounded-full bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm border border-emerald-100/50 dark:border-emerald-900/50 shadow-sm hover:shadow-md hover:border-emerald-200 dark:hover:border-emerald-700 transition-all duration-300">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                    </div>
                    <span class="text-xs sm:text-sm font-semibold text-foreground">Sesuai Prinsip Syariah</span>
                </div>
                <div class="flex items-center gap-2.5 px-4 py-2.5 rounded-full bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm border border-emerald-100/50 dark:border-emerald-900/50 shadow-sm hover:shadow-md hover:border-emerald-200 dark:hover:border-emerald-700 transition-all duration-300">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <span class="text-xs sm:text-sm font-semibold text-foreground">BPRS Bangka Belitung</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ ABOUT / INTRO ═══ --}}
    <section class="py-14 lg:py-20 bg-muted dark:bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 reveal-up" x-intersect="$el.classList.add('is-visible')">
                <span class="eyebrow-badge mb-3 inline-flex">Tentang Kami</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-foreground tracking-tight leading-tight">
                    Bank Syariah Terpercaya di Kepulauan Bangka Belitung
                </h2>
            </div>
            <div class="max-w-4xl mx-auto text-center text-secondary dark:text-slate-400 space-y-4 reveal-up" x-intersect="$el.classList.add('is-visible')">
                <p>
                    PT. Bank Perekonomian Rakyat Syariah (BPRS) Bangka Belitung adalah bank syariah yang terdaftar dan diawasi
                    oleh Otoritas Jasa Keuangan (OJK) serta merupakan peserta penjaminan Lembaga Penjamin Simpanan (LPS).
                    Seluruh produk dan layanan kami telah disetujui oleh Dewan Pengawas Syariah sehingga aman dan sesuai
                    prinsip syariah.
                </p>
                <p>
                    Kami melayani kebutuhan keuangan masyarakat Negeri Serumpun Sebalai melalui <a href="{{ route('products.simpanan-syariah') }}" class="font-semibold text-emerald-600 dark:text-emerald-400 hover:underline">simpanan syariah</a>
                    (tabungan wadiah, tabungan pelajar, dan deposito mudharabah), <a href="{{ route('products.pembiayaan-syariah') }}" class="font-semibold text-emerald-600 dark:text-emerald-400 hover:underline">pembiayaan syariah</a>
                    (modal kerja, kendaraan bermotor, multiguna, hingga pembiayaan sertifikasi guru), serta layanan
                    <a href="{{ route('products.kas-keliling') }}" class="font-semibold text-emerald-600 dark:text-emerald-400 hover:underline">kas keliling</a>
                    yang menjangkau berbagai wilayah di Bangka dan Belitung.
                </p>
                <p>
                    Dengan kantor pusat di Pangkalpinang dan jaringan kantor cabang di Sungailiat, Mentok, Koba, Toboali,
                    Tanjung Pandan, dan Manggar, BPRS Bangka Belitung siap mendampingi pertumbuhan UMKM dan ekonomi syariah di daerah.
                    Mulai dari menabung, berinvestasi, hingga mendapatkan pembiayaan sesuai kebutuhan.
                </p>
                <div class="pt-2">
                    <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 hover:shadow-lg transition-all duration-300">
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ WHY CHOOSE US ═══ --}}
    <section class="py-14 lg:py-20 bg-white dark:bg-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-frontend.why-choose-us :why-choose-us-settings="$whyChooseUsSettings" :why-choose-us="$whyChooseUs" />
        </div>
    </section>

    {{-- ═══ QUICK ACCESS — Shortcut Cards ═══ --}}
    <section class="py-14 lg:py-20 bg-muted dark:bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-intersect="$el.classList.add('is-visible')">
            <div class="text-center mb-10 reveal-up">
                <span class="eyebrow-badge mb-3 inline-flex">Jelajahi Layanan</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-foreground tracking-tight leading-tight">
                    Akses Cepat
                </h2>
                <p class="text-secondary dark:text-slate-400 mt-2 text-base mx-auto">
                    Temukan layanan dan informasi yang Anda butuhkan
                </p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 lg:gap-6">
                {{-- Produk & Layanan --}}
                <a href="{{ route('products.simpanan-syariah') }}"
                   class="group relative bg-white dark:bg-slate-800 rounded-2xl p-5 sm:p-6 border border-border dark:border-slate-700 hover:border-emerald-200 dark:hover:border-emerald-700 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 reveal-up card-hover">
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400 mb-4 group-hover:scale-110 group-hover:bg-emerald-100 dark:group-hover:bg-emerald-800/70 transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <h3 class="font-bold text-foreground dark:text-slate-100 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors text-sm sm:text-base">Produk & Layanan</h3>
                    <p class="text-xs sm:text-sm text-secondary dark:text-slate-400 mt-1 leading-relaxed">Simpanan, pembiayaan, deposito syariah</p>
                </a>

                {{-- Simulasi Pembiayaan --}}
                <a href="{{ route('financing-simulation') }}"
                   class="group relative bg-white dark:bg-slate-800 rounded-2xl p-5 sm:p-6 border border-border dark:border-slate-700 hover:border-amber-200 dark:hover:border-amber-700 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 reveal-up card-hover">
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-900/50 text-amber-600 dark:text-amber-400 mb-4 group-hover:scale-110 group-hover:bg-amber-100 dark:group-hover:bg-amber-800/70 transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="font-bold text-foreground dark:text-slate-100 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors text-sm sm:text-base">Simulasi Pembiayaan</h3>
                    <p class="text-xs sm:text-sm text-secondary dark:text-slate-400 mt-1 leading-relaxed">Hitung angsuran sesuai kemampuan Anda</p>
                </a>

                {{-- Berita & Artikel --}}
                <a href="{{ route('news.index') }}"
                   class="group relative bg-white dark:bg-slate-800 rounded-2xl p-5 sm:p-6 border border-border dark:border-slate-700 hover:border-emerald-200 dark:hover:border-emerald-700 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 reveal-up card-hover">
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400 mb-4 group-hover:scale-110 group-hover:bg-emerald-100 dark:group-hover:bg-emerald-800/70 transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </div>
                    <h3 class="font-bold text-foreground dark:text-slate-100 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors text-sm sm:text-base">Berita & Artikel</h3>
                    <p class="text-xs sm:text-sm text-secondary dark:text-slate-400 mt-1 leading-relaxed">Informasi terkini ekonomi syariah</p>
                </a>

                {{-- Lelang Agunan --}}
                <a href="{{ route('auctions.index') }}"
                   class="group relative bg-white dark:bg-slate-800 rounded-2xl p-5 sm:p-6 border border-border dark:border-slate-700 hover:border-emerald-200 dark:hover:border-emerald-700 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 reveal-up card-hover">
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400 mb-4 group-hover:scale-110 group-hover:bg-emerald-100 dark:group-hover:bg-emerald-800/70 transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                    </div>
                    <h3 class="font-bold text-foreground dark:text-slate-100 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors text-sm sm:text-base">Lelang Agunan</h3>
                    <p class="text-xs sm:text-sm text-secondary dark:text-slate-400 mt-1 leading-relaxed">Daftar aset agunan tersedia</p>
                </a>

                {{-- Pengaduan Nasabah --}}
                <a href="{{ route('pengaduan-nasabah') }}"
                   class="group relative bg-white dark:bg-slate-800 rounded-2xl p-5 sm:p-6 border border-border dark:border-slate-700 hover:border-red-200 dark:hover:border-red-700 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 reveal-up card-hover">
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-red-50 dark:bg-red-900/50 text-red-600 dark:text-red-400 mb-4 group-hover:scale-110 group-hover:bg-red-100 dark:group-hover:bg-red-800/70 transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    </div>
                    <h3 class="font-bold text-foreground dark:text-slate-100 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors text-sm sm:text-base">Pengaduan Nasabah</h3>
                    <p class="text-xs sm:text-sm text-secondary dark:text-slate-400 mt-1 leading-relaxed">Sampaikan keluhan atau masukan</p>
                </a>

                {{-- Hubungi Kami --}}
                <a href="{{ route('contact') }}"
                   class="group relative bg-white dark:bg-slate-800 rounded-2xl p-5 sm:p-6 border border-border dark:border-slate-700 hover:border-amber-200 dark:hover:border-amber-700 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 reveal-up card-hover">
                    <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-900/50 text-amber-600 dark:text-amber-400 mb-4 group-hover:scale-110 group-hover:bg-amber-100 dark:group-hover:bg-amber-800/70 transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="font-bold text-foreground dark:text-slate-100 group-hover:text-amber-600 dark:group-hover:text-amber-400 transition-colors text-sm sm:text-base">Hubungi Kami</h3>
                    <p class="text-xs sm:text-sm text-secondary dark:text-slate-400 mt-1 leading-relaxed">Kantor cabang dan kontak layanan</p>
                </a>
            </div>
        </div>
    </section>

    {{-- ═══ STATS ═══ --}}
    <section class="py-14 lg:py-20 bg-white dark:bg-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-frontend.stats-section :company-info="$companyInfo" />
        </div>
    </section>

    {{-- ═══ COMPLAINT & WHISTLEBLOWING ═══ --}}
    <section class="py-14 lg:py-20 bg-muted dark:bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8 fade-in-section" x-intersect="$el.classList.add('is-visible')">
                <h2 class="text-2xl sm:text-3xl font-bold text-foreground mb-2 leading-tight tracking-tight">
                    Kami Siap Mendengar Anda
                </h2>
                <p class="text-sm text-secondary dark:text-slate-400 max-w-4xl mx-auto">
                    Sampaikan keluhan, masukan, atau laporan pelanggaran. Ditangani secara profesional dan rahasia.
                </p>
            </div>
            <div class="grid sm:grid-cols-2 gap-4 max-w-5xl mx-auto">
                <a href="{{ route('pengaduan-nasabah') }}"
                   class="group flex items-center gap-4 bg-white dark:bg-slate-800 border border-border dark:border-slate-700 rounded-xl p-5 hover:border-emerald-200 dark:hover:border-emerald-700 hover:shadow-md transition-all duration-300">
                    <div class="shrink-0 flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400 group-hover:bg-emerald-100 dark:group-hover:bg-emerald-800/70 transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-foreground dark:text-slate-100 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors text-sm sm:text-base">Pengaduan Nasabah</h3>
                        <p class="text-xs sm:text-sm text-secondary dark:text-slate-400">Keluhan atau masukan untuk kualitas layanan</p>
                    </div>
                    <svg class="w-4 h-4 text-secondary shrink-0 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                <a href="{{ route('whistleblowing') }}"
                   class="group flex items-center gap-4 bg-white dark:bg-slate-800 border border-border dark:border-slate-700 rounded-xl p-5 hover:border-red-200 dark:hover:border-red-700 hover:shadow-md transition-all duration-300">
                    <div class="shrink-0 flex items-center justify-center w-12 h-12 rounded-xl bg-red-50 dark:bg-red-900/50 text-red-600 dark:text-red-400 group-hover:bg-red-100 dark:group-hover:bg-red-800/70 transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-foreground dark:text-slate-100 group-hover:text-red-600 dark:group-hover:text-red-400 transition-colors text-sm sm:text-base">Whistleblowing</h3>
                        <p class="text-xs sm:text-sm text-secondary dark:text-slate-400">Lapor dugaan pelanggaran secara rahasia</p>
                    </div>
                    <svg class="w-4 h-4 text-secondary shrink-0 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- ═══ Floating Prayer Time Widget ═══ --}}
    <div id="pfw-wrap" class="fixed right-6 bottom-24 z-50 pfw-hide">
        <button id="pfw-toggle" class="pfw-toggle-btn" aria-label="Toggle">
            <svg id="pfw-ico" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
        </button>
        <div class="pfw-box">
            <div class="pfw-up pfw-header">
                <div class="pfw-up pfw-header-row" style="animation-delay:.05s">
                    <div style="display:flex;align-items:center;gap:12px">
                        <div class="pfw-float pfw-icon-box">
                            <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="color:#fff"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div><div style="color:#fff;font-weight:700;font-size:15px">Jadwal Sholat</div><div id="pfw-loc" class="pfw-subtle">Memuat...</div></div>
                    </div>
                    <button id="pfw-refresh" class="pfw-btn-icon" title="Perbarui"><svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg></button>
                </div>
            </div>
            <div class="pfw-up pfw-clock-area" style="animation-delay:.1s">
                <div id="pfw-clock" class="pfw-clock-text"></div>
                <div id="pfw-date" class="pfw-subtle"></div>
            </div>
            <div id="pfw-next" class="pfw-up pfw-glow pfw-next-area" style="animation-delay:.15s">
                <div class="pfw-subtle" style="margin-bottom:4px">Menuju</div>
                <div id="pfw-nx" class="pfw-next-name"></div>
                <div style="display:flex;align-items:center;justify-content:center;gap:8px">
                    <div class="pfw-countdown-box"><div id="pfw-ch" class="pfw-countdown-val"></div><div class="pfw-countdown-lbl">Jam</div></div>
                    <div class="pfw-sep" style="animation:pfw-float 4s ease-in-out infinite">:</div>
                    <div class="pfw-countdown-box"><div id="pfw-cm" class="pfw-countdown-val"></div><div class="pfw-countdown-lbl">Menit</div></div>
                    <div class="pfw-sep" style="animation:pfw-float 4s ease-in-out infinite">:</div>
                    <div class="pfw-countdown-box"><div id="pfw-cs" class="pfw-countdown-val"></div><div class="pfw-countdown-lbl">Detik</div></div>
                </div>
            </div>
            <div id="pfw-list" style="padding:16px 20px">
                <div id="pfw-load" class="pfw-load-area"><div class="pfw-spin" style="display:inline-block;width:28px;height:28px;border:3px solid rgba(255,255,255,0.2);border-top-color:#fff;border-radius:50%"></div><p style="color:rgba(255,255,255,0.8);font-size:13px;margin-top:10px">Memuat...</p></div>
                <div id="pfw-err" class="pfw-err-area"><p id="pfw-err-msg" style="color:rgba(255,255,255,0.9);font-size:13px;margin-bottom:10px"></p><button id="pfw-retry" style="padding:8px 18px;background:rgba(255,255,255,0.2);border:none;color:#fff;border-radius:8px;cursor:pointer;font-size:13px">Coba Lagi</button></div>
                <div id="pfw-times" style="display:none"></div>
            </div>
            <div class="pfw-up pfw-footer" style="animation-delay:.3s"><p class="pfw-muted">Diperbarui otomatis setiap hari</p></div>
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
        function toggle(){S.min=!S.min;S.min?w.classList.add('pfw-hide'):(w.style.display='',w.classList.remove('pfw-hide'));t.style.opacity=S.min?'1':'0';ic.innerHTML=S.min?'<path d="M15 19l-7-7 7-7"/>':'<path d="M9 5l7 7-7 7"/>';cancelHide();}
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
            var html='',icons=['\ud83c\udf05','\u2600\ufe0f','\ud83c\udf24\ufe0f','\ud83c\udf06','\ud83c\udf19'];
            for(i=0;i<times.length;i++){var x=times[i];html+='<div class="pfw-up pfw-entry'+(x.nx?' pfw-next':'')+'" style="animation-delay:'+(.15+i*0.08)+'s;display:flex;align-items:center;justify-content:space-between;padding:10px 14px;border-radius:10px;margin-bottom:6px;background:'+(x.nx?'rgba(255,255,255,0.2);box-shadow:0 0 0 1px rgba(255,255,255,0.4)':'rgba(255,255,255,0.05)')+'">'+
                '<div style="display:flex;align-items:center;gap:10px"><div style="width:36px;height:36px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;background:'+(x.nx?'rgba(255,255,255,0.3)':'rgba(255,255,255,0.1)')+'">'+(icons[i]||'')+'</div><span style="color:#fff;font-weight:500;font-size:15px">'+x.n+'</span></div>'+
                '<div style="text-align:right"><div style="color:#fff;font-weight:700;font-size:15px">'+x.t+'</div>'+(x.nx?'<div style="color:rgba(255,255,255,0.8);font-size:11px">Selanjutnya</div>':'')+'</div></div>';}
            timesEl.innerHTML=html;timesEl.style.display='';loadEl.style.display='none';
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
