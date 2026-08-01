<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth"
      x-data="adminTheme()"
      :class="darkMode ? 'dark' : ''"
      x-init="initTheme()">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csp-nonce" content="{{ request()->attributes->get('csp_nonce') }}">
    <meta name="theme-color" content="#0b1120" media="(prefers-color-scheme: dark)">
    <meta name="theme-color" content="#0b1120" media="(prefers-color-scheme: light)">

    {{-- Idle Timeout Configuration --}}
    @auth
    @php
        $securitySettings = \App\Models\SecuritySetting::getSettings();
        $idleTimeout = $securitySettings->idle_timeout ?: config('session.idle_timeout', 15);
        $idleWarning = $securitySettings->idle_warning ?: config('session.idle_warning', 5);
        $autoExtend = $securitySettings->auto_extend_session ?? true;
    @endphp
    <meta name="idle-timeout" content="{{ $idleTimeout }}">
    <meta name="idle-warning" content="{{ $idleWarning }}">
    <meta name="logout-url" content="{{ route('admin.logout') }}">
    <meta name="auto-extend" content="{{ $autoExtend ? 'true' : 'false' }}">
    @endauth

    <title>@yield('title', 'Dashboard') — {{ config('app.name') }}</title>

    @php $company = \App\Models\CompanyInfo::getInfo(); @endphp
    @if($company?->favicon)
        <link rel="icon" href="{{ \App\Helpers\StorageHelper::url($company->favicon) }}" type="image/x-icon">
        <link rel="shortcut icon" href="{{ \App\Helpers\StorageHelper::url($company->favicon) }}" type="image/x-icon">
    @endif

    {{-- DNS Prefetch & Preconnect --}}
    <link rel="dns-prefetch" href="https://fonts.bunny.net">
    <link rel="dns-prefetch" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    {{-- ═══ DARK MODE: Flash Prevention & Theme Remember — Runs BEFORE first paint ═══ --}}
    <script nonce="{{ request()->attributes->get('csp_nonce') }}">
        (function() {
            var stored = localStorage.getItem('admin_dark_mode');
            var prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            var isDark = stored === 'true' || (stored === null && prefersDark);

            if (isDark) {
                document.documentElement.classList.add('dark');
                document.documentElement.style.colorScheme = 'dark';
            } else {
                document.documentElement.style.colorScheme = 'light';
            }

            var meta = document.querySelector('meta[name="theme-color"]');
            if (meta) {
                meta.content = isDark ? '#0b1120' : '#0b1120';
            }
        })();
    </script>

    <link rel="preload" href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" as="style">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/js/sweetalert-global.js', 'resources/js/admin.js', 'resources/css/app.css'])
    @stack('styles')

    <style nonce="{{ $nonce }}">
        [x-cloak] { display: none !important; }

        .skip-to-content:focus {
            position: fixed;
            top: 1rem;
            left: 1rem;
            z-index: 9999;
            padding: 1rem;
            background: white;
            color: #059669;
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);
            outline: 2px solid #059669;
            font-weight: 600;
            width: auto;
            height: auto;
            margin: 0;
            clip: auto;
            overflow: visible;
            white-space: normal;
            text-decoration: none;
        }

        /* Sidebar scrollbar */
        .sidebar-scroll {
            scrollbar-width: thin;
            scrollbar-color: rgba(148,163,184,0.2) transparent;
        }
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: rgba(148,163,184,0.2); border-radius: 2px; }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover { background: rgba(148,163,184,0.4); }
    </style>

    <x-device-fingerprint />
</head>

<body class="bg-gradient-to-br from-slate-50 via-white to-slate-50/80 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950/80 text-slate-900 dark:text-slate-100 antialiased min-h-screen">

    {{-- Skip to main content (accessibility) --}}
    <a href="#admin-main-content"
       class="skip-to-content"
       style="position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0;">
        Langsung ke konten utama
    </a>

    <div x-data="adminLayout()" x-init="init()">

        {{-- Mobile Overlay --}}
        <div x-show="sidebarOpen" @click="closeSidebar()"
             x-transition:enter="transition-opacity ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 lg:hidden"
             x-cloak></div>

        {{-- ═══ SIDEBAR — Premium Dark with Emerald + Gold ═══ --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed top-0 left-0 bottom-0 z-50 w-72 flex flex-col bg-[#0b1120] border-r border-white/[0.06] transition-transform duration-300 ease-[cubic-bezier(0.32,0.72,0,1)] lg:translate-x-0 shadow-2xl shadow-black/50">

            {{-- Top ambient glow --}}
            <div class="absolute top-0 left-0 right-0 h-48 bg-gradient-to-b from-emerald-500/[0.07] via-emerald-500/[0.03] to-transparent pointer-events-none" aria-hidden="true"></div>

            {{-- Logo Area --}}
            <div class="relative h-16 flex items-center justify-between px-4 shrink-0 border-b border-white/[0.05]">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 no-underline group" @click="closeSidebarOnMobile()">
                    {{-- Logo icon with emerald + gold gradient --}}
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center shrink-0 shadow-lg shadow-emerald-600/30 group-hover:shadow-emerald-500/40 transition-all duration-300">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div class="flex flex-col">
                        <div class="flex items-baseline gap-1">
                            <span class="text-white font-bold text-[15px] leading-tight tracking-tight">Admin</span>
                            <span class="text-emerald-400 font-bold text-[15px] leading-tight tracking-tight">Panel</span>
                        </div>
                        <span class="text-[10px] text-slate-500 leading-tight mt-0.5 font-medium tracking-wide">{{ config('app.name') }}</span>
                    </div>
                </a>
                <button @click="closeSidebar()" aria-label="Tutup sidebar"
                    class="lg:hidden text-slate-500 hover:text-white p-1.5 rounded-lg hover:bg-white/10 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Navigation --}}
            @php
                $__navKey = 'admin_sidebar_nav';
                $__navTtl = now()->addHour();
            @endphp
            @if(!\Illuminate\Support\Facades\Cache::has($__navKey))
                @php ob_start(); @endphp
            @endif
            <nav class="sidebar-scroll relative flex-1 overflow-y-auto px-2.5 py-4 space-y-0.5" @click="closeSidebarOnMobile()">
                @include('layouts.admin.menu')
            </nav>
            @if(!\Illuminate\Support\Facades\Cache::has($__navKey))
                @php
                    $__navContent = ob_get_clean();
                    echo $__navContent;
                    \Illuminate\Support\Facades\Cache::put($__navKey, $__navContent, $__navTtl);
                @endphp
            @endif

            {{-- User Info Footer --}}
            <div class="relative p-3 shrink-0 border-t border-white/[0.05]">
                <div class="flex items-center gap-3 p-2.5 rounded-xl bg-white/[0.03] hover:bg-white/[0.06] transition-colors duration-200 cursor-default">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-emerald-500/20 to-emerald-600/20 flex items-center justify-center text-emerald-400 font-bold text-sm shrink-0 ring-1 ring-emerald-500/20">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[13px] font-semibold text-slate-200 truncate leading-tight">{{ auth()->user()->name }}</p>
                        <p class="text-[11px] text-slate-500 truncate mt-0.5">{{ auth()->user()->getRoleDisplayName() }}</p>
                    </div>
                    <div class="w-2 h-2 rounded-full bg-emerald-500/60 shadow-sm shadow-emerald-500/30 shrink-0"></div>
                </div>
            </div>
        </aside>

        {{-- ═══ MAIN CONTENT AREA ═══ --}}
        <div class="min-h-screen lg:ml-72 flex flex-col transition-all duration-300">

            {{-- Header / Top Navigation --}}
            <header class="sticky top-0 z-30 bg-white/80 dark:bg-slate-900/80 backdrop-blur-xl border-b border-slate-200/60 dark:border-slate-800/60 shadow-sm shadow-slate-900/5">
                <div class="h-16 px-4 sm:px-6 lg:px-8 flex items-center justify-between w-full">
                    <div class="flex items-center gap-4">
                        {{-- Hamburger (mobile only) --}}
                        <button @click="openSidebar()" aria-label="Buka sidebar"
                            class="lg:hidden p-2 text-slate-500 hover:text-slate-900 rounded-xl hover:bg-slate-100 transition-all duration-150">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                        {{-- Page Title --}}
                        <div>
                            <h1 class="text-[15px] font-semibold text-slate-900 tracking-tight">
                                @yield('title', 'Dashboard')
                            </h1>
                        </div>
                    </div>

                    {{-- Header Actions --}}
                    <div class="flex items-center gap-2">
                        {{-- Dark Mode Toggle — Enhanced Indicator --}}
                        <div class="relative group">
                            <button @click="toggleTheme()"
                                class="theme-toggle-btn p-2 rounded-xl text-slate-500 dark:text-slate-400
                                       hover:bg-slate-100 dark:hover:bg-slate-800 transition-all duration-150
                                       active:scale-90 relative"
                                aria-label="Toggle dark mode">
                                <template x-if="!darkMode">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"/>
                                    </svg>
                                </template>
                                <template x-if="darkMode">
                                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/>
                                    </svg>
                                </template>
                            </button>
                            {{-- Tooltip --}}
                            <div class="absolute -bottom-10 left-1/2 -translate-x-1/2 opacity-0 group-hover:opacity-100
                                        transition-all duration-300 pointer-events-none translate-y-1 group-hover:translate-y-0 z-50">
                                <div class="px-2 py-1 rounded-lg text-[10px] font-semibold whitespace-nowrap
                                            bg-slate-900 dark:bg-slate-100 text-white dark:text-slate-900
                                            shadow-lg shadow-black/20">
                                    <span x-text="darkMode ? '🌙 Mode Gelap' : '☀️ Mode Terang'"></span>
                                </div>
                                <div class="absolute -top-1 left-1/2 -translate-x-1/2 w-2 h-2 rotate-45
                                            bg-slate-900 dark:bg-slate-100"></div>
                            </div>
                        </div>

                        <div class="hidden sm:block h-5 w-px bg-slate-200 dark:bg-slate-700"></div>

                        {{-- View Website --}}
                        {{-- View Website --}}
                        <a href="{{ route('home') }}" target="_blank"
                            class="hidden sm:inline-flex items-center gap-2 h-9 px-4 rounded-xl text-[13px] font-medium border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 hover:text-emerald-600 hover:border-emerald-200 no-underline transition-all duration-150 group">
                            <svg class="w-3.5 h-3.5 group-hover:scale-110 transition-transform duration-150" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            <span class="hidden md:inline">Website</span>
                        </a>

                        <div class="hidden sm:block h-5 w-px bg-slate-200 dark:hidden"></div>

                        {{-- User Dropdown --}}
                        <div x-data="{ open: false }" class="relative">
                            <button @click.stop="open = !open"
                                class="flex items-center gap-2.5 p-1.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-all duration-150 border border-transparent dark:border-slate-700 hover:border-slate-200 dark:hover:border-slate-600 bg-transparent cursor-pointer">
                                <div class="w-8 h-8 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center text-white font-semibold text-xs shrink-0 shadow-sm">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div class="hidden lg:block text-left mr-1">
                                    <p class="text-[13px] font-semibold text-slate-900 dark:text-slate-100 leading-tight">{{ auth()->user()->name }}</p>
                                    <p class="text-[11px] text-slate-500 mt-0.5">{{ auth()->user()->getRoleDisplayName() }}</p>
                                </div>
                                <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200" :style="open ? 'transform:rotate(180deg)' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            {{-- Dropdown Menu --}}
                            <div x-show="open" @click.away="open = false" x-cloak
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                                 class="absolute right-0 top-full mt-2 w-64 bg-white dark:bg-slate-900 rounded-2xl shadow-xl shadow-slate-900/10 dark:shadow-black/50 ring-1 ring-slate-900/5 dark:ring-slate-700/50 py-1.5 z-50 origin-top-right overflow-hidden">
                                <div class="px-4 py-3.5 border-b border-slate-100 dark:border-slate-800">
                                    <p class="text-sm font-semibold text-slate-900 dark:text-slate-100">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 truncate mt-0.5">{{ auth()->user()->email }}</p>
                                </div>
                                <div class="py-1.5">
                                    <a href="{{ route('admin.profile.edit') }}"
                                       class="group flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-emerald-950/50 hover:text-emerald-700 dark:hover:text-emerald-400 no-underline transition-all duration-150 mx-2 rounded-xl">
                                        <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        Profil Saya
                                    </a>
                                    <a href="{{ route('home') }}" target="_blank"
                                       class="group lg:hidden flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-emerald-950/50 hover:text-emerald-700 dark:hover:text-emerald-400 no-underline transition-all duration-150 mx-2 rounded-xl">
                                        <svg class="w-4 h-4 text-slate-400 group-hover:text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                        Lihat Website
                                    </a>
                                </div>
                                <div class="border-t border-slate-100 dark:border-slate-800 py-1.5">
                                    <form method="POST" action="{{ route('admin.logout') }}" id="logout-form">
                                        @csrf
                                        <button type="submit"
                                            class="group flex items-center gap-3 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-950/50 no-underline transition-all duration-150 cursor-pointer border-none bg-transparent text-left mx-2 rounded-xl w-[calc(100%-16px)]">
                                            <svg class="w-4 h-4 text-red-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- ═══ PAGE CONTENT ═══ --}}
            <main id="admin-main-content" class="flex-1 p-4 sm:p-6 lg:p-8 w-full max-w-full">
                {{-- SweetAlert Flash Notifications --}}
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

                {{-- Page content with enter animation --}}
                <div class="page-enter">
                    @yield('content')
                </div>
            </main>

            {{-- Dark Mode Floating Indicator Badge --}}
            <div class="dark-mode-indicator" aria-hidden="true">
                <div class="dark-mode-indicator-inner">
                    <span class="flex items-center justify-center w-5 h-5 rounded-full bg-emerald-500/20 text-emerald-400">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </span>
                    <span>Mode Gelap</span>
                </div>
            </div>

            {{-- Footer --}}
            <footer class="mt-auto border-t border-slate-200/60 dark:border-slate-800/60 bg-white/50 dark:bg-slate-900/50 backdrop-blur-sm px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-slate-400 dark:text-slate-500">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Hak Cipta Dilindungi.</p>
                <p class="hidden sm:block">Versi 1.0.0</p>
            </footer>
        </div>
    </div>

    <script nonce="{{ $nonce }}">
        window.adminLogoutUrl = "{{ route('admin.logout') }}";

        function adminTheme() {
            return {
                darkMode: false,
                _transitionTimer: null,

                initTheme() {
                    var saved = localStorage.getItem('admin_dark_mode');
                    if (saved !== null) {
                        this.darkMode = saved === 'true';
                    } else {
                        this.darkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
                    }

                    // Sync class (flash prevention already ran, but we need Alpine in sync)
                    document.documentElement.classList.toggle('dark', this.darkMode);

                    // Listen for OS scheme changes (only when no explicit choice)
                    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
                        if (!localStorage.getItem('admin_dark_mode')) {
                            this.darkMode = e.matches;
                            this._applyAdminTheme(e.matches, true);
                        }
                    });
                },

                _applyAdminTheme(isDark, animate) {
                    if (animate) {
                        document.documentElement.classList.add('dark-transitioning');
                    }
                    // Note: `dark` class is handled reactively by Alpine :class binding on <html>
                    // Only manage color-scheme and theme-color here
                    document.documentElement.style.colorScheme = isDark ? 'dark' : 'light';

                    // Update theme-color meta for browser chrome
                    var meta = document.querySelector('meta[name="theme-color"]');
                    if (meta) {
                        meta.content = isDark ? '#0b1120' : '#0b1120';
                    }

                    if (animate) {
                        clearTimeout(this._transitionTimer);
                        this._transitionTimer = setTimeout(() => {
                            document.documentElement.classList.remove('dark-transitioning');
                        }, 400);
                    }
                },

                toggleTheme() {
                    this.darkMode = !this.darkMode;
                    localStorage.setItem('admin_dark_mode', this.darkMode);
                    this._applyAdminTheme(this.darkMode, true);
                }
            }
        }
    </script>
    @stack('scripts')

    {{-- Fallback untuk browser lama --}}
    <noscript>
        <style nonce="{{ $nonce }}">
            .no-js-alert { display: block !important; }
        </style>
        <div class="fixed bottom-4 right-4 z-50 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl shadow-lg text-sm">
            JavaScript diperlukan untuk menjalankan aplikasi ini.
        </div>
    </noscript>
</body>
</html>
