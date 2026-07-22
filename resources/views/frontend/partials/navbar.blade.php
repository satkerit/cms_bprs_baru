@php
    $company = $company ?? \App\Models\CompanyInfo::getInfo();
    $nonce = request()->attributes->get('csp_nonce', '');

    // Active section detection
    $isHome = request()->routeIs('home');
    $isAbout = request()->routeIs('about.*');
    $isProducts = request()->routeIs('products.*') || request()->routeIs('financing-simulation');
    $isInfo = request()->routeIs('news.*') || request()->routeIs('auctions.*') || request()->routeIs('brochures.*') || request()->routeIs('careers.*');
    $isComplaint = request()->routeIs('pengaduan-nasabah') || request()->routeIs('whistleblowing');
    $isReports = request()->routeIs('reports.*');
    $isContact = request()->routeIs('contact');
@endphp
<style nonce="{{ $nonce }}">
    [x-cloak] { display: none !important; }
</style>

<nav class="relative"
     x-data="{
         scrolled: false,
         mobileOpen: false,
         ready: false,
         darkMode: localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),
         toggleDark() {
             this.darkMode = !this.darkMode;
             localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
             document.documentElement.classList.toggle('dark', this.darkMode);
         }
     }"
     x-init="$nextTick(() => { ready = true; scrolled = window.scrollY > 50 })"
     @scroll.window="scrolled = window.scrollY > 50"
     role="navigation"
     aria-label="Navigasi utama">
    <div class="transition-all duration-300 backdrop-blur-md"
         :class="scrolled ? 'bg-white/70 shadow-md border-b border-white/20' : 'bg-transparent'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-[72px] lg:h-[76px]">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0 group" aria-label="Beranda">
                    @if($company?->logo)
                    <img
                        src="{{ \App\Helpers\StorageHelper::url($company->logo) }}"
                        alt="{{ $company->name ?? 'Logo' }}"
                        class="h-12 w-auto max-w-[200px] object-contain transition-transform duration-300 group-hover:scale-[1.02]"
                        loading="eager"
                        fetchpriority="high"
                        decoding="sync"
                    />
                    @else
                    <div class="w-10 h-10 bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20 transition-transform duration-300 group-hover:scale-105">
                        <span class="text-white font-heading font-bold text-lg">B</span>
                    </div>
                    @endif
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center gap-0.5">
                    <!-- Beranda -->
                    <a href="{{ route('home') }}"
                       class="px-3 xl:px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 {{ $isHome ? 'text-emerald-600 bg-emerald-50' : 'text-foreground hover:text-emerald-600 hover:bg-emerald-50' }}">
                        Beranda
                    </a>

                    <!-- About Dropdown -->
                    <div class="relative" x-data="{ open: false, timeout: null }"
                         @mouseenter="clearTimeout(timeout); open = true"
                         @mouseleave="timeout = setTimeout(() => open = false, 150)">
                        <button class="px-3 xl:px-4 py-2 rounded-lg text-sm font-medium inline-flex items-center gap-1 transition-all duration-200 {{ $isAbout ? 'text-emerald-600 bg-emerald-50' : 'text-foreground hover:text-emerald-600 hover:bg-emerald-50' }}"
                                :aria-expanded="open"
                                aria-haspopup="true">
                            Tentang Kami
                            <svg class="h-3.5 w-3.5 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="absolute left-0 w-full h-2 top-full"></div>
                        <div x-cloak x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             class="absolute left-0 top-full pt-1 w-64 z-50">
                            <div class="bg-white/70 backdrop-blur-md rounded-xl shadow-lg shadow-black/5 py-2 border border-white/20 overflow-hidden">
                                <a href="{{ route('about.company') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-foreground hover:text-emerald-600 hover:bg-emerald-50 transition-colors">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    </span>
                                    Profil Perusahaan
                                </a>
                                <a href="{{ route('about.komisaris') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-foreground hover:text-emerald-600 hover:bg-emerald-50 transition-colors">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </span>
                                    Dewan Komisaris
                                </a>
                                <a href="{{ route('about.direksi') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-foreground hover:text-emerald-600 hover:bg-emerald-50 transition-colors">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/></svg>
                                    </span>
                                    Dewan Direksi
                                </a>
                                <a href="{{ route('about.pengawas-syariah') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-foreground hover:text-emerald-600 hover:bg-emerald-50 transition-colors">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    </span>
                                    Dewan Pengawas Syariah
                                </a>
                                <a href="{{ route('about.struktur') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-foreground hover:text-emerald-600 hover:bg-emerald-50 transition-colors">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                                    </span>
                                    Struktur Organisasi
                                </a>
                                <a href="{{ route('about.offices') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-foreground hover:text-emerald-600 hover:bg-emerald-50 transition-colors">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    </span>
                                    Kantor Kami
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Products Dropdown -->
                    <div class="relative" x-data="{ open: false, timeout: null }"
                         @mouseenter="clearTimeout(timeout); open = true"
                         @mouseleave="timeout = setTimeout(() => open = false, 150)">
                        <button class="px-3 xl:px-4 py-2 rounded-lg text-sm font-medium inline-flex items-center gap-1 transition-all duration-200 {{ $isProducts ? 'text-emerald-600 bg-emerald-50' : 'text-foreground hover:text-emerald-600 hover:bg-emerald-50' }}"
                                :aria-expanded="open"
                                aria-haspopup="true">
                            Produk & Layanan
                            <svg class="h-3.5 w-3.5 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="absolute left-0 w-full h-2 top-full"></div>
                        <div x-cloak x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             class="absolute left-0 top-full pt-1 w-64 z-50">
                            <div class="bg-white/70 backdrop-blur-md rounded-xl shadow-lg shadow-black/5 py-2 border border-white/20 overflow-hidden">
                                <a href="{{ route('products.simpanan-syariah') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-foreground hover:text-emerald-600 hover:bg-emerald-50 transition-colors">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    </span>
                                    Simpanan Syariah
                                </a>
                                <a href="{{ route('products.pembiayaan-syariah') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-foreground hover:text-emerald-600 hover:bg-emerald-50 transition-colors">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </span>
                                    Pembiayaan Syariah
                                </a>
                                <a href="{{ route('products.deposito-syariah') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-foreground hover:text-emerald-600 hover:bg-emerald-50 transition-colors">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </span>
                                    Deposito Syariah
                                </a>
                                <a href="{{ route('products.kas-keliling') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-foreground hover:text-emerald-600 hover:bg-emerald-50 transition-colors">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                    </span>
                                    Kas Keliling
                                </a>
                                <div class="border-t border-slate-100 my-1 mx-3"></div>
                                <a href="{{ route('financing-simulation') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-foreground hover:text-emerald-600 hover:bg-emerald-50 transition-colors">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    </span>
                                    Simulasi Pembiayaan
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Dropdown -->
                    <div class="relative" x-data="{ open: false, timeout: null }"
                         @mouseenter="clearTimeout(timeout); open = true"
                         @mouseleave="timeout = setTimeout(() => open = false, 150)">
                        <button class="px-3 xl:px-4 py-2 rounded-lg text-sm font-medium inline-flex items-center gap-1 transition-all duration-200 {{ $isInfo ? 'text-emerald-600 bg-emerald-50' : 'text-foreground hover:text-emerald-600 hover:bg-emerald-50' }}"
                                :aria-expanded="open"
                                aria-haspopup="true">
                            Informasi
                            <svg class="h-3.5 w-3.5 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="absolute left-0 w-full h-2 top-full"></div>
                        <div x-cloak x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             class="absolute left-0 top-full pt-1 w-64 z-50">
                            <div class="bg-white/70 backdrop-blur-md rounded-xl shadow-lg shadow-black/5 py-2 border border-white/20 overflow-hidden">
                                <a href="{{ route('news.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-foreground hover:text-emerald-600 hover:bg-emerald-50 transition-colors">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                    </span>
                                    Berita & Artikel
                                </a>
                                <a href="{{ route('auctions.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-foreground hover:text-emerald-600 hover:bg-emerald-50 transition-colors">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                                    </span>
                                    Lelang Agunan
                                </a>
                                <a href="{{ route('brochures.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-foreground hover:text-emerald-600 hover:bg-emerald-50 transition-colors">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                    </span>
                                    Brosur Pembiayaan
                                </a>
                                <a href="{{ route('careers.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-foreground hover:text-emerald-600 hover:bg-emerald-50 transition-colors">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </span>
                                    Karir
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Reports Dropdown -->
                    <div class="relative" x-data="{ open: false, timeout: null }"
                         @mouseenter="clearTimeout(timeout); open = true"
                         @mouseleave="timeout = setTimeout(() => open = false, 150)">
                        <button class="px-3 xl:px-4 py-2 rounded-lg text-sm font-medium inline-flex items-center gap-1 transition-all duration-200 {{ $isReports ? 'text-emerald-600 bg-emerald-50' : 'text-foreground hover:text-emerald-600 hover:bg-emerald-50' }}"
                                :aria-expanded="open"
                                aria-haspopup="true">
                            Laporan
                            <svg class="h-3.5 w-3.5 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="absolute left-0 w-full h-2 top-full"></div>
                        <div x-cloak x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             class="absolute left-0 top-full pt-1 w-72 z-50">
                            <div class="bg-white/70 backdrop-blur-md rounded-xl shadow-lg shadow-black/5 py-2 border border-white/20 overflow-hidden">
                                <a href="{{ route('reports.keuangan-publikasi') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-foreground hover:text-emerald-600 hover:bg-emerald-50 transition-colors">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </span>
                                    Laporan Keuangan Publikasi
                                </a>
                                <a href="{{ route('reports.tata-kelola') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-foreground hover:text-emerald-600 hover:bg-emerald-50 transition-colors">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </span>
                                    Laporan Tata Kelola
                                </a>
                                <a href="{{ route('reports.tahunan') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-foreground hover:text-emerald-600 hover:bg-emerald-50 transition-colors">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                    </span>
                                    Laporan Tahunan
                                </a>
                                <a href="{{ route('reports.tahunan-berkelanjutan') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-foreground hover:text-emerald-600 hover:bg-emerald-50 transition-colors">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </span>
                                    Laporan Berkelanjutan
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Dark Mode Toggle -->
                    <button @click="toggleDark()"
                            class="p-2 rounded-xl transition-all duration-200 btn-press dark-toggle hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300"
                            :title="darkMode ? 'Mode Terang' : 'Mode Gelap'"
                            aria-label="Toggle dark mode">
                        <svg x-show="!darkMode" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                        <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </button>

                    <!-- Hubungi Kami Button -->
                    <a href="{{ route('contact') }}"
                       class="ml-1 px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-300 btn-press {{ $isContact ? 'bg-amber-600 text-white shadow-lg shadow-amber-500/20' : 'bg-gradient-to-r from-amber-600 to-amber-700 text-white shadow-lg shadow-amber-500/20 hover:shadow-amber-500/30 hover:-translate-y-0.5' }}">
                        Hubungi Kami
                    </a>
                </div>

                <!-- Mobile Menu Trigger -->
                <div class="flex items-center gap-2 lg:hidden">
                    <button @click="mobileOpen = !mobileOpen"
                            class="relative z-50 p-3 rounded-xl bg-emerald-600 text-white shadow-lg shadow-emerald-500/20 btn-press"
                            aria-label="Toggle menu"
                            :aria-expanded="mobileOpen">
                        <span class="sr-only">Buka menu</span>
                        <svg x-show="!mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <svg x-show="mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation -->
    <div x-cloak
         x-show="mobileOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-4"
         @click.away="mobileOpen = false"
         @keydown.escape.window="mobileOpen = false"
         class="lg:hidden fixed inset-x-0 top-0 bottom-0 z-40 bg-white overflow-y-auto max-h-full overscroll-contain"
         style="-webkit-overflow-scrolling: touch;"
         role="dialog"
         aria-modal="true"
         aria-label="Menu navigasi">

        <!-- Mobile Header -->
        <div class="sticky top-0 bg-white/95 backdrop-blur border-b border-slate-100 px-4 py-4 z-10">
            <div class="flex justify-between items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    @if($company?->logo)
                    <img src="{{ \App\Helpers\StorageHelper::url($company->logo) }}" alt="{{ $company->name }}" class="h-10 w-auto max-w-[160px] object-contain">
                    @else
                    <div class="w-9 h-9 bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-xl flex items-center justify-center shadow-md">
                        <span class="text-white font-heading font-bold text-base">B</span>
                    </div>
                    @endif
                </a>
                <button @click="mobileOpen = false" class="p-2 -mr-2 rounded-lg hover:bg-slate-100 transition-colors" aria-label="Tutup menu">
                    <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Items -->
        <div class="px-4 pt-2 pb-24 space-y-1">
            <!-- Home -->
            <a href="{{ route('home') }}"
               @click="mobileOpen = false"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ $isHome ? 'bg-emerald-50 text-emerald-600 font-semibold' : 'text-foreground hover:bg-secondary/5' }}">
                <span class="flex items-center justify-center w-9 h-9 rounded-lg bg-emerald-50 text-emerald-600 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </span>
                <span>Beranda</span>
            </a>

            <!-- Tentang Kami -->
            <div x-data="{ open: {{ $isAbout ? 'true' : 'false' }} }">
                <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 {{ $isAbout ? 'bg-emerald-50 text-emerald-600 font-semibold' : 'text-foreground hover:bg-secondary/5' }}">
                    <div class="flex items-center gap-3">
                        <span class="flex items-center justify-center w-9 h-9 rounded-lg bg-emerald-50 text-emerald-600 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </span>
                        <span>Tentang Kami</span>
                    </div>
                    <svg class="h-4 w-4 transition-transform duration-200 shrink-0" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-cloak x-show="open" x-collapse class="ml-12 mt-1 pl-3 border-l-2 border-emerald-200 space-y-0.5">
                    <a href="{{ route('about.company') }}" @click="mobileOpen = false" class="block px-3 py-2 text-sm text-foreground hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors">Profil Perusahaan</a>
                    <a href="{{ route('about.komisaris') }}" @click="mobileOpen = false" class="block px-3 py-2 text-sm text-foreground hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors">Dewan Komisaris</a>
                    <a href="{{ route('about.direksi') }}" @click="mobileOpen = false" class="block px-3 py-2 text-sm text-foreground hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors">Dewan Direksi</a>
                    <a href="{{ route('about.pengawas-syariah') }}" @click="mobileOpen = false" class="block px-3 py-2 text-sm text-foreground hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors">Dewan Pengawas Syariah</a>
                    <a href="{{ route('about.struktur') }}" @click="mobileOpen = false" class="block px-3 py-2 text-sm text-foreground hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors">Struktur Organisasi</a>
                    <a href="{{ route('about.offices') }}" @click="mobileOpen = false" class="block px-3 py-2 text-sm text-foreground hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors">Kantor Kami</a>
                </div>
            </div>

            <!-- Produk & Layanan -->
            <div x-data="{ open: {{ $isProducts ? 'true' : 'false' }} }">
                <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 {{ $isProducts ? 'bg-emerald-50 text-emerald-600 font-semibold' : 'text-foreground hover:bg-secondary/5' }}">
                    <div class="flex items-center gap-3">
                        <span class="flex items-center justify-center w-9 h-9 rounded-lg bg-emerald-50 text-emerald-600 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </span>
                        <span>Produk & Layanan</span>
                    </div>
                    <svg class="h-4 w-4 transition-transform duration-200 shrink-0" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-cloak x-show="open" x-collapse class="ml-12 mt-1 pl-3 border-l-2 border-emerald-200 space-y-0.5">
                    <a href="{{ route('products.simpanan-syariah') }}" @click="mobileOpen = false" class="block px-3 py-2 text-sm text-foreground hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors">Simpanan Syariah</a>
                    <a href="{{ route('products.pembiayaan-syariah') }}" @click="mobileOpen = false" class="block px-3 py-2 text-sm text-foreground hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors">Pembiayaan Syariah</a>
                    <a href="{{ route('products.deposito-syariah') }}" @click="mobileOpen = false" class="block px-3 py-2 text-sm text-foreground hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors">Deposito Syariah</a>
                    <a href="{{ route('products.kas-keliling') }}" @click="mobileOpen = false" class="block px-3 py-2 text-sm text-foreground hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors">Kas Keliling</a>
                    <div class="border-t border-border my-1 mx-3"></div>
                    <a href="{{ route('financing-simulation') }}" @click="mobileOpen = false" class="block px-3 py-2 text-sm text-foreground hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors">Simulasi Pembiayaan</a>
                </div>
            </div>

            <!-- Informasi -->
            <div x-data="{ open: {{ $isInfo ? 'true' : 'false' }} }">
                <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 {{ $isInfo ? 'bg-emerald-50 text-emerald-600 font-semibold' : 'text-foreground hover:bg-secondary/5' }}">
                    <div class="flex items-center gap-3">
                        <span class="flex items-center justify-center w-9 h-9 rounded-lg bg-emerald-50 text-emerald-600 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </span>
                        <span>Informasi</span>
                    </div>
                    <svg class="h-4 w-4 transition-transform duration-200 shrink-0" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-cloak x-show="open" x-collapse class="ml-12 mt-1 pl-3 border-l-2 border-emerald-200 space-y-0.5">
                    <a href="{{ route('news.index') }}" @click="mobileOpen = false" class="block px-3 py-2 text-sm text-foreground hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors">Berita & Artikel</a>
                    <a href="{{ route('auctions.index') }}" @click="mobileOpen = false" class="block px-3 py-2 text-sm text-foreground hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors">Lelang Agunan</a>
                    <a href="{{ route('brochures.index') }}" @click="mobileOpen = false" class="block px-3 py-2 text-sm text-foreground hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors">Brosur Pembiayaan</a>
                    <a href="{{ route('careers.index') }}" @click="mobileOpen = false" class="block px-3 py-2 text-sm text-foreground hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors">Karir</a>
                </div>
            </div>

            <!-- Pengaduan -->
            <div x-data="{ open: {{ $isComplaint ? 'true' : 'false' }} }">
                <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 {{ $isComplaint ? 'bg-emerald-50 text-emerald-600 font-semibold' : 'text-foreground hover:bg-secondary/5' }}">
                    <div class="flex items-center gap-3">
                        <span class="flex items-center justify-center w-9 h-9 rounded-lg bg-emerald-50 text-emerald-600 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </span>
                        <span>Pengaduan</span>
                    </div>
                    <svg class="h-4 w-4 transition-transform duration-200 shrink-0" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-cloak x-show="open" x-collapse class="ml-12 mt-1 pl-3 border-l-2 border-emerald-200 space-y-0.5">
                    <a href="{{ route('pengaduan-nasabah') }}" @click="mobileOpen = false" class="block px-3 py-2 text-sm text-foreground hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors">Pengaduan Nasabah</a>
                    <a href="{{ route('whistleblowing') }}" @click="mobileOpen = false" class="block px-3 py-2 text-sm text-foreground hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors">Whistleblowing System</a>
                </div>
            </div>

            <!-- Laporan -->
            <div x-data="{ open: {{ $isReports ? 'true' : 'false' }} }">
                <button @click="open = !open"
                        class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition-all duration-200 {{ $isReports ? 'bg-emerald-50 text-emerald-600 font-semibold' : 'text-foreground hover:bg-secondary/5' }}">
                    <div class="flex items-center gap-3">
                        <span class="flex items-center justify-center w-9 h-9 rounded-lg bg-emerald-50 text-emerald-600 shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </span>
                        <span>Laporan</span>
                    </div>
                    <svg class="h-4 w-4 transition-transform duration-200 shrink-0" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-cloak x-show="open" x-collapse class="ml-12 mt-1 pl-3 border-l-2 border-emerald-200 space-y-0.5">
                    <a href="{{ route('reports.keuangan-publikasi') }}" @click="mobileOpen = false" class="block px-3 py-2 text-sm text-foreground hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors">Laporan Keuangan</a>
                    <a href="{{ route('reports.tata-kelola') }}" @click="mobileOpen = false" class="block px-3 py-2 text-sm text-foreground hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors">Laporan Tata Kelola</a>
                    <a href="{{ route('reports.tahunan') }}" @click="mobileOpen = false" class="block px-3 py-2 text-sm text-foreground hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors">Laporan Tahunan</a>
                    <a href="{{ route('reports.tahunan-berkelanjutan') }}" @click="mobileOpen = false" class="block px-3 py-2 text-sm text-foreground hover:text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors">Laporan Berkelanjutan</a>
                </div>
            </div>

            <!-- Search -->
            <div class="pt-2">
                @livewire('frontend.search.global-search')
            </div>

            <!-- Hubungi Kami CTA -->
            <div class="pt-3 mt-2 border-t border-border">
                <a href="{{ route('contact') }}"
                   @click="mobileOpen = false"
                   class="flex items-center justify-center gap-2 w-full py-3.5 px-4 bg-gradient-to-r from-amber-600 to-amber-700 text-white rounded-xl font-semibold shadow-lg shadow-amber-500/20 transition-all duration-300 btn-press">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="text-sm">Hubungi Kami</span>
                </a>
            </div>
        </div>
    </div>
</nav>
