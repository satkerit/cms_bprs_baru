<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data x-init="$store.theme.init()">
@php
    try {
        $company = \App\Models\CompanyInfo::getInfo();
    } catch (\Throwable $e) {
        $company = null;
    }
@endphp
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="google-site-verification" content="0OtvQgB_NIsFOhRnDVRlMnKnunQZOerEvZ4RHNY7wbM" />
    <meta name="msvalidate.01" content="BB8861008F4F5E77171E76B1E6F93151" />
    <meta name="theme-color" content="#059669" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#0b1120" media="(prefers-color-scheme: dark)">

    <meta name="csp-nonce" content="{{ $nonce }}">

    {{-- SEO Meta Tags --}}
    {!! \App\Services\Seo\SeoMeta::generate() !!}

    {{-- DNS Prefetch & Preconnect for performance --}}
    <link rel="dns-prefetch" href="https://fonts.bunny.net">
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>

    @if($company?->favicon)
    <link rel="icon" href="{{ \App\Helpers\StorageHelper::url($company->favicon) }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ \App\Helpers\StorageHelper::url($company->favicon) }}" type="image/x-icon">
    @endif

    {{-- Fonts — loaded non-blocking (media=print + swap) so first paint is never held by the font CDN --}}
    <link id="fonts-css" rel="stylesheet" href="https://fonts.bunny.net/css?family=plus-jakarta-sans:300,400,500,600,700,800&display=swap" media="print" />
    <script nonce="{{ $nonce }}">
        var fontsCss = document.getElementById('fonts-css');
        if (fontsCss) fontsCss.addEventListener('load', function () { this.media = 'all'; });
    </script>

    {{-- ═══ DARK MODE: Flash Prevention & Theme Remember — Runs BEFORE first paint ═══ --}}
    <script nonce="{{ $nonce }}">
        (function() {
            var stored = localStorage.getItem('theme');
            var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            var isDark = stored === 'dark' || (!stored && prefersDark);

            if (isDark) {
                document.documentElement.classList.add('dark');
                document.documentElement.style.colorScheme = 'dark';
            } else {
                document.documentElement.style.colorScheme = 'light';
            }

            // Update theme-color meta tag to match — prevents browser chrome flash
            var meta = document.querySelector('meta[name="theme-color"]');
            if (meta) {
                meta.content = isDark ? '#0b1120' : '#059669';
            }
        })();
    </script>

    {{-- sweetalert-global.js: event handlers for flash messages + confirmations --}}
    {{-- SweetAlert2 library itself is lazy-loaded inside sweetalert-global.js --}}
    @vite(['resources/js/sweetalert-global.js', 'resources/js/app.js', 'resources/css/app.css'])
    @livewireStyles(['nonce' => $nonce])
    @stack('head')
    <script src="https://analytics.ahrefs.com/analytics.js" data-key="EU80N6YBFCctbdfGZIb5gg" async nonce="{{ $nonce }}"></script>
</head>
<body class="font-sans antialiased bg-background text-foreground selection:bg-emerald-200/60 selection:text-emerald-900 dark:bg-slate-950 dark:text-slate-100 dark:selection:bg-emerald-500/30 dark:selection:text-emerald-200">

    {{-- Skip to main content link for keyboard users --}}
    <a href="#main-content"
       class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:p-4 focus:bg-white focus:text-emerald-600 focus:rounded-xl focus:shadow-xl focus:outline-none focus:border-2 focus:border-emerald-600 focus:font-semibold dark:focus:bg-slate-900 dark:focus:text-emerald-400 dark:focus:border-emerald-400">
        Langsung ke konten utama
    </a>

    <!-- Navbar: floating island, positioned via fixed inside navbar partial -->
    @include('frontend.partials.navbar')

    {{-- Flash Messages — otomatis tampil sebagai SweetAlert2 toast via sweetalert-global.js --}}
    @php
        $__swalFlash = json_encode(array_filter([
            session('success') ? ['type' => 'success', 'title' => 'Berhasil!', 'text' => session('success')] : null,
            session('error') ? ['type' => 'error', 'title' => 'Gagal!', 'text' => session('error')] : null,
            session('warning') ? ['type' => 'warning', 'title' => 'Peringatan!', 'text' => session('warning')] : null,
            session('info') ? ['type' => 'info', 'title' => 'Informasi', 'text' => session('info')] : null,
        ]));
    @endphp
    <div id="swal-flash"
         data-messages='{{ $__swalFlash }}'
         aria-hidden="true"
         style="display:none"></div>

    <!-- Main Content -->
    {{-- pt-28 lg:pt-32 = ruang untuk floating island navbar (pt-4/5 + h-16/h-[68px] + margin) --}}
    <main id="main-content" class="pt-28 lg:pt-32">
        @if(isset($slot) && $slot->isNotEmpty())
            {{ $slot }}
        @else
            @yield('content')
        @endif
    </main>

    <!-- Footer -->
    @php
        $__footerKey = 'frontend_footer';
        $__footerTtl = now()->addHour();
    @endphp
    @if(!\Illuminate\Support\Facades\Cache::has($__footerKey))
        @php ob_start(); @endphp
    @endif
        @include('frontend.partials.footer')
    @if(!\Illuminate\Support\Facades\Cache::has($__footerKey))
        @php
            $__footerContent = ob_get_clean();
            echo $__footerContent;
            \Illuminate\Support\Facades\Cache::put($__footerKey, $__footerContent, $__footerTtl);
        @endphp
    @endif

    @livewireScripts(['nonce' => $nonce])
    @stack('scripts')

    {{-- ═══ DARK MODE: Alpine Store — shared single source (frontend + admin) ═══ --}}
    @include('components.theme-store')
</body>
</html>
