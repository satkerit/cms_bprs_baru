<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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

    {{-- Preload critical fonts --}}
    <link rel="preload" href="https://fonts.bunny.net/css?family=IBM+Plex+Sans:400,500,600,700&display=swap" as="style">
    <link href="https://fonts.bunny.net/css?family=IBM+Plex+Sans:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/js/sweetalert-global.js', 'resources/js/app.js', 'resources/css/app.css'])
    @livewireStyles(['nonce' => $nonce])
    @stack('head')
    <script src="https://analytics.ahrefs.com/analytics.js" data-key="EU80N6YBFCctbdfGZIb5gg" async nonce="{{ $nonce }}"></script>
</head>
<body>

    {{-- Skip to main content link for keyboard users --}}
    <a href="#main-content"
       class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:p-4 focus:bg-white focus:text-emerald-600 focus:rounded-xl focus:shadow-xl focus:outline-none focus:border-2 focus:border-emerald-600 focus:font-semibold">
        Langsung ke konten utama
    </a>

    <!-- Header -->
    <header class="border-b border-border sticky top-0 z-50 bg-white">
        @include('frontend.partials.navbar')
    </header>

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
         data-messages='{!! $__swalFlash !!}'
         aria-hidden="true"
         style="display:none"></div>

    <!-- Main Content -->
    <main id="main-content">
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
</body>
</html>
