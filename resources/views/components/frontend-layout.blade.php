<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth" x-data="themeData()" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Permissions Policy -->
    <meta http-equiv="Permissions-Policy" content="geolocation=(self), camera=(), microphone=()">

    <title>{{ $title ?? config('app.name', 'BPRS Bangka Belitung') }}</title>

    @php
        $company = $company ?? \App\Models\CompanyInfo::getInfo();
        $seoSettings = \App\Models\SiteSetting::getSettings();
        // Potong title maks 65 karakter agar tidak di-flag Bing/Google
        $rawTitle = $title ?? config('app.name', 'BPRS Bangka Belitung');
        $pageTitle = mb_strlen($rawTitle) > 65 ? mb_substr($rawTitle, 0, 62) . '...' : $rawTitle;
        // Pastikan description selalu ada walau kolom DB belum ada
        $defaultDesc = 'BPRS Bangka Belitung - Bank Pembiayaan Rakyat Syariah terpercaya. Menyediakan produk simpanan syariah, pembiayaan syariah, dan deposito syariah untuk masyarakat Bangka Belitung.';
        $pageDesc = $metaDescription ?? ($seoSettings?->seo_default_description ?: $defaultDesc);
    @endphp

    <title>{{ $pageTitle }}</title>

    {{-- Dynamic SEO Meta Tags --}}
    <meta name="description" content="{{ $pageDesc }}">
    <meta name="keywords" content="{{ $metaKeywords ?? ($seoSettings?->seo_default_keywords ?: 'BPRS, Bank Syariah, Simpanan Syariah, Pembiayaan Syariah, Deposito, Bangka Belitung, BPR Syariah') }}">
    <meta name="robots" content="{{ $metaRobots ?? ($seoSettings?->seo_robots_default ?? 'index, follow') }}">
    <meta name="theme-color" content="#059669">
    @if($seoSettings?->seo_google_verification)
    <meta name="google-site-verification" content="{{ $seoSettings->seo_google_verification }}">
    @endif
    @if($seoSettings->seo_bing_verification)
    <meta name="msvalidate.01" content="{{ $seoSettings->seo_bing_verification }}">
    @endif

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="{{ $ogType ?? 'website' }}">
    <meta property="og:title" content="{{ $ogTitle ?? ($title ?? $seoSettings->seo_site_name ?? config('app.name', 'BPRS Bangka Belitung')) }}">
    <meta property="og:description" content="{{ $ogDescription ?? ($metaDescription ?? ($seoSettings->seo_default_description ?: 'BPRS Bangka Belitung - Bank Pembiayaan Rakyat Syariah terpercaya.')) }}">
    <meta property="og:url" content="{{ $ogUrl ?? url()->current() }}">
    @if(isset($ogImage))
    <meta property="og:image" content="{{ $ogImage }}">
    @elseif($seoSettings->seo_og_image)
    <meta property="og:image" content="{{ $seoSettings->seo_og_image }}">
    @elseif(isset($company) && $company?->logo)
    <meta property="og:image" content="{{ \App\Helpers\StorageHelper::url($company->logo) }}">
    @endif

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $ogTitle ?? ($title ?? $seoSettings->seo_site_name ?? config('app.name', 'BPRS Bangka Belitung')) }}">
    <meta name="twitter:description" content="{{ $ogDescription ?? ($metaDescription ?? ($seoSettings->seo_default_description ?: 'BPRS Bangka Belitung - Bank Pembiayaan Rakyat Syariah terpercaya.')) }}">
    @if($seoSettings->seo_twitter_handle)
    <meta name="twitter:site" content="{{ $seoSettings->seo_twitter_handle }}">
    @endif
    @if(isset($ogImage))
    <meta name="twitter:image" content="{{ $ogImage }}">
    @elseif($seoSettings->seo_og_image)
    <meta name="twitter:image" content="{{ $seoSettings->seo_og_image }}">
    @elseif(isset($company) && $company?->logo)
    <meta name="twitter:image" content="{{ \App\Helpers\StorageHelper::url($company->logo) }}">
    @endif

    {{-- Canonical URL --}}
    @if($seoSettings->seo_canonical_enabled !== false)
    <link rel="canonical" href="{{ $canonicalUrl ?? url()->current() }}">
    @endif

    @if(isset($company) && $company?->favicon)
    <link rel="icon" href="{{ \App\Helpers\StorageHelper::url($company->favicon) }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ \App\Helpers\StorageHelper::url($company->favicon) }}">
    @endif

    {{-- Performance Optimizations --}}
    {{-- DNS Prefetch & Preconnect for critical origins --}}
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link rel="dns-prefetch" href="https://fonts.bunny.net">
    <link rel="preconnect" href="https://analytics.ahrefs.com" crossorigin>
    <link rel="dns-prefetch" href="https://analytics.ahrefs.com">

    @php
        $storageHost = parse_url(\App\Helpers\StorageHelper::url('x'), PHP_URL_HOST);
    @endphp
    @if($storageHost && !str_contains($storageHost, 'localhost'))
    <link rel="preconnect" href="https://{{ $storageHost }}" crossorigin>
    <link rel="dns-prefetch" href="https://{{ $storageHost }}">
    @endif

    @if(isset($company) && $company?->logo)
    <link rel="preload" as="image" href="{{ \App\Helpers\StorageHelper::url($company->logo) }}" fetchpriority="high">
    @endif

    @php $nonce = request()->attributes->get('csp_nonce', ''); @endphp

    {{-- Set navbar height immediately — prevents content-from-jumping on scroll --}}
    <style nonce="{{ $nonce }}">:root { --navbar-height: 88px; }</style>

    {{-- Fonts with display=swap for performance --}}
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700&display=swap" rel="stylesheet" />

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles(['nonce' => $nonce])

    @stack('head')

    {{-- Device Fingerprint for session security --}}
    <x-device-fingerprint />

    {{-- Google Analytics 4 --}}
    @env('production')
        @if(config('services.ga4.measurement_id'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('services.ga4.measurement_id') }}" nonce="{{ $nonce }}"></script>
        <script nonce="{{ $nonce }}">
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ config('services.ga4.measurement_id') }}');
        </script>
        @endif
    @endenv
</head>
<body class="font-sans antialiased bg-background text-foreground selection:bg-emerald-100 selection:text-emerald-600">
    {{-- Scroll Progress Bar (must be in <body>, not <head>) --}}
    <div x-data="scrollProgress"
         class="scroll-progress"
         :style="{ transform: `scaleX(${progress})`, opacity: progress > 0.02 ? 1 : 0 }"
         style="opacity: 0;"
         aria-hidden="true"></div>

    <!-- Skip to main content for accessibility -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-[100] focus:px-4 focus:py-3 focus:bg-emerald-600 focus:text-white focus:rounded-lg focus:shadow-lg focus:outline-none focus:ring-2 focus:ring-white">
        Langsung ke konten utama
    </a>

    <!-- Header / Navbar -->
    <header class="fixed w-full top-0 z-50 transition-all duration-300"
            x-data="{
                scrolled: false,
                _rafId: null,
                _resizeTimer: null,

                init() {
                    this.updateNavbarHeight();

                    // Debounced resize — only runs 150ms after the user stops resizing.
                    // Stored reference so destroy() can remove it cleanly.
                    this._onResize = () => {
                        clearTimeout(this._resizeTimer);
                        this._resizeTimer = setTimeout(() => this.updateNavbarHeight(), 150);
                    };
                    window.addEventListener('resize', this._onResize);
                },

                destroy() {
                    cancelAnimationFrame(this._rafId);
                    clearTimeout(this._resizeTimer);
                    if (this._onResize) {
                        window.removeEventListener('resize', this._onResize);
                    }
                },

                // Throttled via requestAnimationFrame — skips frames the browser can't paint
                onScroll() {
                    this.scrolled = window.scrollY > 20;
                    if (!this._rafId) {
                        this._rafId = requestAnimationFrame(() => {
                            this.updateNavbarHeight();
                            this._rafId = null;
                        });
                    }
                },

                updateNavbarHeight() {
                    const w = window.innerWidth;
                    const h = this.scrolled ? 64 : (w >= 1024 ? 80 : 72);
                    document.documentElement.style.setProperty('--navbar-height', h + 'px');
                }
            }"
            :class="scrolled ? 'bg-white/70 backdrop-blur-md shadow-md border-b border-white/20' : 'bg-transparent'"
            @scroll.window="onScroll()">
        @include('frontend.partials.navbar', ['company' => $company])
    </header>

    <!-- Page Transition Animation -->
    <style nonce="{{ $nonce }}">
        @keyframes page-enter {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .page-enter {
            animation: page-enter 0.5s cubic-bezier(0.23, 1, 0.32, 1) forwards;
        }
    </style>

    <!-- Main Content -->
    <main id="main-content" class="min-h-screen page-enter" style="padding-top: var(--navbar-height, 88px);">
        {{ $slot }}
    </main>

    <!-- Footer -->
    @include('frontend.partials.footer', ['company' => $company])

    @livewireScripts(['nonce' => $nonce])
    @vite(['resources/js/pagination-fix.js'])
    @stack('scripts')

    {{-- Dark Mode Initialization --}}
    <script nonce="{{ $nonce }}">
        document.addEventListener('alpine:init', () => {
            Alpine.data('themeData', () => ({
                darkMode: localStorage.getItem('theme') === 'dark' ||
                    (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),
                init() {
                    this.$watch('darkMode', val => {
                        localStorage.setItem('theme', val ? 'dark' : 'light');
                        document.documentElement.classList.toggle('dark', val);
                    });
                    // Apply initial state
                    document.documentElement.classList.toggle('dark', this.darkMode);
                },
                toggleDark() {
                    this.darkMode = !this.darkMode;
                }
            }));
        });
    </script>
</body>
</html>
