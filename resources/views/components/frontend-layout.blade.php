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
    @endphp

    {{-- Dynamic SEO Meta Tags --}}
    <meta name="description" content="{{ $metaDescription ?? 'BPRS Bangka Belitung - Bank Pembiayaan Rakyat Syariah terpercaya. Menyediakan produk simpanan syariah, pembiayaan syariah, dan deposito syariah untuk masyarakat.' }}">
    <meta name="keywords" content="{{ $metaKeywords ?? 'BPRS, Bank Syariah, Simpanan Syariah, Pembiayaan Syariah, Deposito, Bangka Belitung, BPR Syariah' }}">
    <meta name="robots" content="{{ $metaRobots ?? 'index, follow' }}">
    <meta name="theme-color" content="#059669">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="{{ $ogType ?? 'website' }}">
    <meta property="og:title" content="{{ $ogTitle ?? ($title ?? config('app.name', 'BPRS Bangka Belitung')) }}">
    <meta property="og:description" content="{{ $ogDescription ?? ($metaDescription ?? 'BPRS Bangka Belitung - Bank Pembiayaan Rakyat Syariah terpercaya.') }}">
    <meta property="og:url" content="{{ $ogUrl ?? url()->current() }}">
    @if(isset($ogImage))
    <meta property="og:image" content="{{ $ogImage }}">
    @elseif(isset($company) && $company?->logo)
    <meta property="og:image" content="{{ \App\Helpers\StorageHelper::url($company->logo) }}">
    @endif

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $ogTitle ?? ($title ?? config('app.name', 'BPRS Bangka Belitung')) }}">
    <meta name="twitter:description" content="{{ $ogDescription ?? ($metaDescription ?? 'BPRS Bangka Belitung - Bank Pembiayaan Rakyat Syariah terpercaya.') }}">
    @if(isset($ogImage))
    <meta name="twitter:image" content="{{ $ogImage }}">
    @elseif(isset($company) && $company?->logo)
    <meta name="twitter:image" content="{{ \App\Helpers\StorageHelper::url($company->logo) }}">
    @endif

    {{-- Canonical URL --}}
    <link rel="canonical" href="{{ $canonicalUrl ?? url()->current() }}">

    @if(isset($company) && $company?->favicon)
    <link rel="icon" href="{{ \App\Helpers\StorageHelper::url($company->favicon) }}" type="image/x-icon">
    <link rel="apple-touch-icon" href="{{ \App\Helpers\StorageHelper::url($company->favicon) }}">
    @endif

    {{-- Performance Optimizations --}}
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link rel="dns-prefetch" href="https://fonts.bunny.net">
    @php
        $storageHost = parse_url(\App\Helpers\StorageHelper::url('x'), PHP_URL_HOST);
    @endphp
    @if($storageHost && !str_contains($storageHost, 'localhost'))
    <link rel="preconnect" href="https://{{ $storageHost }}" crossorigin>
    @endif

    @if(isset($company) && $company?->logo)
    <link rel="preload" as="image" href="{{ \App\Helpers\StorageHelper::url($company->logo) }}" fetchpriority="high">
    @endif

    {{-- Fonts --}}
    <link href="https://fonts.bunny.net/css?family=montserrat:400,500,600,700,800|inter:400,500,600,700&display=swap" rel="stylesheet" />

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @php $nonce = request()->attributes->get('csp_nonce', ''); @endphp
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
    <!-- Skip to main content for accessibility -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-[100] focus:px-4 focus:py-3 focus:bg-emerald-600 focus:text-white focus:rounded-lg focus:shadow-lg focus:outline-none focus:ring-2 focus:ring-white">
        Langsung ke konten utama
    </a>

    <!-- Header / Navbar -->
    <header class="fixed w-full top-0 z-50 transition-all duration-300"
            x-data="{ scrolled: false }"
            :class="scrolled ? 'bg-white/70 backdrop-blur-md shadow-md border-b border-white/20' : 'bg-transparent'"
            @scroll.window="scrolled = window.scrollY > 20">
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

    <!-- Floating Prayer Time Widget -->
    <div x-data="prayerWidgetSidebar()"
         x-show="ready"
         x-transition:enter="transition ease-out duration-500"
         x-transition:enter-start="opacity-0 translate-x-full"
         x-transition:enter-end="opacity-100 translate-x-0"
         x-cloak
         class="fixed right-0 z-40 transition-all duration-500"
         :class="minimized ? 'translate-x-[calc(100%-3rem)]' : 'translate-x-0'"
         :style="'top: ' + topPosition + 'px'">

        <!-- Toggle Button -->
        <button
            @click="minimized = !minimized"
            class="absolute left-0 top-4 -translate-x-full bg-emerald-600 text-white p-2.5 rounded-l-xl shadow-lg hover:shadow-xl transition-all duration-300 z-10 hover:-translate-x-[calc(100%+2px)]"
            :class="minimized ? 'opacity-100' : 'opacity-0 hover:opacity-100'"
            :title="minimized ? 'Tampilkan Jadwal Sholat' : 'Sembunyikan Jadwal Sholat'"
            aria-label="Toggle prayer times widget">
            <svg class="w-5 h-5 transition-transform duration-300" :class="minimized ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>

        <!-- Close Button (Mobile) -->
        <button
            @click="show = false; $el.closest('[x-data]').style.display = 'none'"
            class="lg:hidden absolute right-2 top-2 bg-white/20 hover:bg-white/30 text-white p-1.5 rounded-lg transition-all z-10 backdrop-blur-sm"
            title="Close"
            aria-label="Close widget">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Widget Container -->
        <div class="w-80 sm:w-96 overflow-y-auto prayer-widget-container shadow-2xl rounded-l-2xl" style="max-height: inherit;">
            <x-prayer-time-widget />
        </div>
    </div>

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
