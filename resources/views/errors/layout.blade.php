<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ config('app.name', 'BPRS Bangka Belitung') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0f172a;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated gradient background */
        .bg-gradient {
            position: fixed; inset: 0; z-index: 0;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
        }

        .bg-orb {
            position: absolute; border-radius: 50%; pointer-events: none;
            animation: orbFloat 20s ease-in-out infinite;
        }
        .bg-orb-1 {
            width: 500px; height: 500px;
            background: radial-gradient(circle, @yield('orb-color', 'rgba(99,102,241,0.08)') 0%, transparent 70%);
            top: -150px; right: -100px;
        }
        .bg-orb-2 {
            width: 400px; height: 400px;
            background: radial-gradient(circle, @yield('orb-color-2', 'rgba(139,92,246,0.06)') 0%, transparent 70%);
            bottom: -120px; left: -80px;
            animation-delay: -8s;
        }
        .bg-orb-3 {
            width: 250px; height: 250px;
            background: radial-gradient(circle, @yield('orb-color-3', 'rgba(59,130,246,0.05)') 0%, transparent 70%);
            top: 30%; left: 15%;
            animation-delay: -15s;
        }
        @keyframes orbFloat {
            0%, 100% { transform: translate(0,0) scale(1); }
            33% { transform: translate(30px,-30px) scale(1.08); }
            66% { transform: translate(-20px,20px) scale(0.92); }
        }

        .grid-overlay {
            position: fixed; inset: 0; z-index: 1; pointer-events: none;
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 48px 48px;
        }

        .noise-overlay {
            position: fixed; inset: 0; z-index: 1; pointer-events: none;
            opacity: 0.02;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
            background-repeat: repeat; background-size: 256px 256px;
        }

        /* Card */
        .error-card {
            position: relative; z-index: 10;
            width: 100%; max-width: 480px;
            margin: 1.5rem; padding: 2.5rem 2rem;
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(24px) saturate(1.4);
            -webkit-backdrop-filter: blur(24px) saturate(1.4);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 24px;
            text-align: center;
            animation: cardIn 0.6s cubic-bezier(0.16,1,0.3,1) both;
        }
        @keyframes cardIn {
            from { opacity:0; transform:translateY(16px) scale(0.97); }
            to { opacity:1; transform:translateY(0) scale(1); }
        }

        /* Illustration */
        .error-ill {
            margin: 0 auto 1.5rem;
            width: 200px; height: 160px;
            display: flex; align-items: center; justify-content: center;
        }
        .error-ill svg { width: 100%; height: 100%; }
        .error-ill svg * { animation: illBounce 4s ease-in-out infinite; transform-origin: center; }
        @keyframes illBounce {
            0%,100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }

        /* Code */
        .error-code {
            font-size: clamp(4.5rem, 14vw, 7.5rem);
            font-weight: 800;
            line-height: 1;
            letter-spacing: -0.04em;
            background: @yield('code-grad', 'linear-gradient(135deg, #818cf8, #a78bfa)');
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 0.25rem;
        }

        /* Typography */
        .error-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #f1f5f9;
            margin-bottom: 0.5rem;
        }
        .error-message {
            font-size: 0.95rem;
            line-height: 1.7;
            color: rgba(255,255,255,0.65);
            margin-bottom: 1.75rem;
            max-width: 360px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Divider */
        .error-divider {
            width: 40px; height: 3px;
            margin: 0 auto 1rem;
            border-radius: 4px;
            background: @yield('divider-color', 'linear-gradient(90deg, #818cf8, transparent)');
        }

        /* Buttons */
        .error-actions { display: flex; flex-wrap: wrap; gap: 0.625rem; justify-content: center; }
        .btn-primary, .btn-secondary {
            display: inline-flex; align-items: center; gap: 0.5rem;
            padding: 0.75rem 1.5rem; border-radius: 12px;
            font-size: 0.875rem; font-weight: 600;
            text-decoration: none; cursor: pointer;
            border: none; outline: none;
            transition: all 0.2s cubic-bezier(0.23,1,0.32,1);
        }
        .btn-primary {
            background: @yield('btn-primary', 'linear-gradient(135deg, #6366f1, #8b5cf6)');
            color: #fff;
            box-shadow: 0 4px 12px @yield('btn-shadow', 'rgba(99,102,241,0.25)');
        }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 6px 20px @yield('btn-shadow', 'rgba(99,102,241,0.35)'); }
        .btn-secondary {
            background: rgba(255,255,255,0.06);
            color: rgba(255,255,255,0.7);
            border: 1px solid rgba(255,255,255,0.1);
        }
        .btn-secondary:hover { background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.9); transform: translateY(-1px); }
        .btn-primary:active, .btn-secondary:active { transform: scale(0.97); }

        .footer-note {
            margin-top: 1.5rem;
            font-size: 0.75rem;
            color: rgba(255,255,255,0.2);
        }

        @media (max-width: 480px) {
            .error-card { padding: 2rem 1.5rem; margin: 1rem; border-radius: 20px; }
            .error-ill { width: 160px; height: 130px; }
        }
    </style>
</head>
<body>
    <div class="bg-gradient"></div>
    <div class="bg-orb bg-orb-1"></div>
    <div class="bg-orb bg-orb-2"></div>
    <div class="bg-orb bg-orb-3"></div>
    <div class="grid-overlay"></div>
    <div class="noise-overlay"></div>

    <div class="error-card" role="main">
        {{-- Illustration --}}
        <div class="error-ill">@yield('illustration')</div>

        {{-- Code --}}
        <div class="error-code">@yield('code')</div>

        {{-- Divider --}}
        <div class="error-divider"></div>

        {{-- Title --}}
        <h1 class="error-title">@yield('page-title')</h1>

        {{-- Message --}}
        <p class="error-message">@yield('message')</p>

        {{-- Actions --}}
        <div class="error-actions">
            <a href="{{ url('/') }}" class="btn-primary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Beranda
            </a>
            <a href="javascript:history.back()" class="btn-secondary">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="16" height="16"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali
            </a>
        </div>

        <p class="footer-note">@yield('code') &middot; {{ config('app.name', 'BPRS Bangka Belitung') }}</p>
    </div>
</body>
</html>
