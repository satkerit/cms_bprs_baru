{{-- ═══ NAVBAR — Floating Island Design v2 ═══ --}}
@php
$isHome     = request()->routeIs('home');
$isAbout    = request()->routeIs('about.*');
$isProducts = request()->routeIs('products.*') || request()->routeIs('financing-simulation');
$isInfo     = request()->routeIs('news.*') || request()->routeIs('auctions.*') || request()->routeIs('brochures.*') || request()->routeIs('careers.*');
$isReports  = request()->routeIs('reports.*');
$isComplain = request()->routeIs('pengaduan-nasabah') || request()->routeIs('whistleblowing');
$isContact  = request()->routeIs('contact');

try {
    $companyInfo = $companyInfo ?? \App\Models\CompanyInfo::getInfo();
} catch (\Throwable $e) {
    $companyInfo = null;
}

$menus = [
    [
        'label'  => 'Beranda',
        'route'  => 'home',
        'active' => $isHome,
    ],
    [
        'label'  => 'Tentang Kami',
        'active' => $isAbout,
        'children' => [
            ['route' => 'about.company',  'label' => 'Profil Perusahaan'],
            ['route' => 'about.struktur', 'label' => 'Struktur Organisasi'],
            ['route' => 'about.manajemen','label' => 'Manajemen'],
            ['route' => 'about.offices',  'label' => 'Kantor Kami'],
        ],
    ],
    [
        'label'  => 'Produk & Layanan',
        'active' => $isProducts,
        'children' => [
            ['route' => 'products.simpanan-syariah',   'label' => 'Simpanan Syariah'],
            ['route' => 'products.pembiayaan-syariah',  'label' => 'Pembiayaan Syariah'],
            ['route' => 'products.deposito-syariah',    'label' => 'Deposito Syariah'],
            ['route' => 'products.kas-keliling',        'label' => 'Kas Keliling'],
            ['route' => 'financing-simulation',         'label' => 'Simulasi Pembiayaan'],
        ],
    ],
    [
        'label'  => 'Informasi',
        'active' => $isInfo,
        'children' => [
            ['route' => 'news.index',     'label' => 'Berita & Artikel'],
            ['route' => 'auctions.index', 'label' => 'Lelang Agunan'],
            ['route' => 'brochures.index','label' => 'Brosur Pembiayaan'],
            ['route' => 'careers.index',  'label' => 'Karir'],
        ],
    ],
    [
        'label'  => 'Laporan',
        'active' => $isReports,
        'children' => [
            ['route' => 'reports.keuangan-publikasi',    'label' => 'Keuangan Publikasi'],
            ['route' => 'reports.tata-kelola',           'label' => 'Tata Kelola'],
            ['route' => 'reports.tahunan',               'label' => 'Laporan Tahunan'],
            ['route' => 'reports.tahunan-berkelanjutan', 'label' => 'Laporan Berkelanjutan'],
        ],
    ],
    [
        'label'  => 'Pengaduan',
        'active' => $isComplain,
        'children' => [
            ['route' => 'pengaduan-nasabah', 'label' => 'Pengaduan Nasabah'],
            ['route' => 'whistleblowing',    'label' => 'Whistleblowing System'],
        ],
    ],
];
@endphp

{{-- ═══ FLOATING ISLAND NAVBAR ═══ --}}
<div x-data="{
        scrolled: false,
        mobileOpen: false,
        ready: false,
    }"
     x-init="$nextTick(() => { ready = true; scrolled = window.scrollY > 10 })"
     @scroll.window="scrolled = window.scrollY > 10"
     x-effect="if(ready) document.body.style.overflow = mobileOpen ? 'hidden' : ''"
     @keydown.escape.window="mobileOpen = false"
     class="fixed top-0 left-0 right-0 z-50 px-4 sm:px-6 lg:px-8 pt-4 lg:pt-5">

    {{-- ─── Island Container ─── --}}
    <nav role="navigation"
         aria-label="Navigasi utama"
         class="relative max-w-7xl mx-auto transition-all duration-500"
         :class="scrolled
            ? 'rounded-2xl bg-white/85 dark:bg-slate-950/85 backdrop-blur-3xl shadow-2xl shadow-black/15 border border-white/50 dark:border-slate-700/50 ring-1 ring-black/5 dark:ring-white/5'
            : 'rounded-2xl bg-white/70 dark:bg-slate-950/70 backdrop-blur-2xl shadow-xl shadow-black/8 border border-white/40 dark:border-slate-700/40'">

        <div class="flex items-center justify-between h-16 lg:h-[68px] px-5 lg:px-7">

            {{-- ─── Logo ─── --}}
            <a href="{{ route('home') }}"
               class="flex items-center gap-3 shrink-0 group"
               aria-label="{{ $companyInfo?->name ?? 'BPRS Bangka Belitung' }} - Beranda">
                @if(($companyInfo?->logo ?? false) && \Illuminate\Support\Facades\Storage::disk('public')->exists($companyInfo->logo))
                    <img src="{{ \Illuminate\Support\Facades\Storage::url($companyInfo->logo) }}"
                         alt="{{ $companyInfo->name }}"
                         class="h-9 lg:h-10 w-auto dark:brightness-0 dark:invert transition-all duration-300 group-hover:scale-105">
                @else
                    <div class="flex items-center justify-center w-9 h-9 lg:w-10 lg:h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-700 text-white shadow-md shadow-emerald-500/25 group-hover:shadow-emerald-500/40 transition-all duration-300 group-hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 21V10m0 0l-4.5 4.5M12 10l4.5 4.5M12 10V3m-4.5 4.5L12 3m0 0l4.5 4.5"/></svg>
                    </div>
                @endif

            </a>

            {{-- ─── Desktop Nav ─── --}}
            <div class="hidden lg:flex items-center gap-0.5 xl:gap-1">
                @foreach($menus as $menu)
                    @if(empty($menu['children']))
                        <a href="{{ route($menu['route']) }}"
                           class="relative px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 group
                                  {{ $menu['active']
                                    ? 'text-emerald-600 dark:text-emerald-400'
                                    : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white' }}">
                            {{ $menu['label'] }}
                            <span class="absolute bottom-1 left-3 right-3 h-0.5 rounded-full bg-emerald-500 transition-all duration-300
                                         {{ $menu['active'] ? 'opacity-100 scale-x-100' : 'opacity-0 scale-x-0 group-hover:opacity-60 group-hover:scale-x-100' }}"></span>
                        </a>
                    @else
                        <div x-data="{ open: false }"
                             @mouseenter="open = true"
                             @mouseleave="open = false"
                             class="relative">
                            <button class="flex items-center gap-1 px-3 py-2 text-sm font-medium rounded-xl transition-all duration-200 group
                                           {{ $menu['active']
                                             ? 'text-emerald-600 dark:text-emerald-400'
                                             : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white' }}">
                                <span class="relative">
                                    {{ $menu['label'] }}
                                    <span class="absolute -bottom-1 left-0 right-0 h-0.5 rounded-full bg-emerald-500 transition-all duration-300
                                                 {{ $menu['active'] ? 'opacity-100 scale-x-100' : 'opacity-0 scale-x-0 group-hover:opacity-60 group-hover:scale-x-100' }}"></span>
                                </span>
                                <svg class="w-3.5 h-3.5 transition-transform duration-200 shrink-0 opacity-60"
                                     :class="open ? '-rotate-180' : ''"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            {{-- Dropdown --}}
                            <div x-show="open" x-cloak
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
                                 class="absolute left-0 top-full mt-2 w-56 origin-top-left">
                                <div class="rounded-2xl bg-white/95 dark:bg-slate-900/95 backdrop-blur-2xl border border-slate-200/60 dark:border-slate-700/60 shadow-2xl shadow-black/15 overflow-hidden">
                                    <div class="p-1.5">
                                        @foreach($menu['children'] as $child)
                                            <a href="{{ route($child['route']) }}"
                                               class="flex items-center gap-2.5 px-3.5 py-2.5 rounded-xl text-sm text-slate-700 dark:text-slate-200
                                                      hover:bg-emerald-50 dark:hover:bg-emerald-900/30 hover:text-emerald-700 dark:hover:text-emerald-300
                                                      transition-all duration-150 font-medium group/item">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-300 dark:bg-slate-600 group-hover/item:bg-emerald-500 transition-colors duration-200 shrink-0"></span>
                                                {{ $child['label'] }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

                {{-- Divider --}}
                <div class="w-px h-6 bg-slate-200 dark:bg-slate-700 mx-2 shrink-0"></div>

                {{-- Hubungi Kami CTA --}}
                <a href="{{ route('contact') }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold
                          bg-gradient-to-r from-emerald-600 to-emerald-700 text-white
                          shadow-md shadow-emerald-500/25 hover:shadow-lg hover:shadow-emerald-500/35
                          hover:from-emerald-500 hover:to-emerald-600
                          transition-all duration-300 active:scale-[0.97] whitespace-nowrap">
                    Hubungi Kami
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>

                {{-- Dark Mode Toggle ─ always at end --}}
                <button @click="$store.theme.toggleDark()"
                        class="ml-1 w-10 h-10 rounded-xl flex items-center justify-center shrink-0 transition-all duration-300 active:scale-[0.92]
                               bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300
                               hover:bg-emerald-100 dark:hover:bg-emerald-900/50 hover:text-emerald-600 dark:hover:text-emerald-400
                               border border-transparent hover:border-emerald-200 dark:hover:border-emerald-800"
                        :aria-label="$store.theme.darkMode ? 'Aktifkan mode terang' : 'Aktifkan mode gelap'">
                    <template x-if="!$store.theme.darkMode">
                        <svg class="w-4.5 h-4.5 w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </template>
                    <template x-if="$store.theme.darkMode">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </template>
                </button>
            </div>

            {{-- ─── Mobile / Tablet Actions ─── --}}
            <div class="flex lg:hidden items-center gap-2">
                {{-- Hubungi (sm+) --}}
                <a href="{{ route('contact') }}"
                   class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold
                          bg-gradient-to-r from-emerald-600 to-emerald-700 text-white
                          shadow-sm shadow-emerald-500/20 hover:shadow-md hover:shadow-emerald-500/30
                          transition-all duration-300 active:scale-[0.97]">
                    Hubungi
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>

                {{-- Dark Mode --}}
                <button @click="$store.theme.toggleDark()"
                        class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 active:scale-[0.92]
                               bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300
                               hover:bg-emerald-100 dark:hover:bg-emerald-900/50 hover:text-emerald-600 dark:hover:text-emerald-400"
                        :aria-label="$store.theme.darkMode ? 'Mode terang' : 'Mode gelap'">
                    <template x-if="!$store.theme.darkMode">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </template>
                    <template x-if="$store.theme.darkMode">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </template>
                </button>

                {{-- Hamburger --}}
                <button @click="mobileOpen = !mobileOpen"
                        class="w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 active:scale-[0.92]
                               bg-emerald-600 hover:bg-emerald-700 text-white shadow-md shadow-emerald-500/30"
                        :aria-label="mobileOpen ? 'Tutup menu' : 'Buka menu'"
                        :aria-expanded="mobileOpen">
                    <svg x-show="!mobileOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="mobileOpen" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

        </div>
    </nav>

    {{-- ─── Mobile Overlay ─── --}}
    <div x-show="mobileOpen" x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-3"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-3"
         class="lg:hidden mt-2 max-w-7xl mx-auto rounded-2xl overflow-hidden
                bg-white/95 dark:bg-slate-950/95 backdrop-blur-3xl
                border border-white/50 dark:border-slate-700/50
                shadow-2xl shadow-black/20">

        <div class="overflow-y-auto overscroll-contain max-h-[calc(100dvh-140px)]">
            <div class="p-4 space-y-1">
                @foreach($menus as $idx => $menu)
                    <div x-data="{ open: false }">
                        @if(empty($menu['children']))
                            <a href="{{ route($menu['route']) }}"
                               @click="mobileOpen = false"
                               class="flex items-center gap-3 px-4 py-3 min-h-[48px] rounded-xl text-sm font-semibold transition-all duration-200
                                      {{ $menu['active']
                                        ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300'
                                        : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800/80' }}">
                                <span class="w-2 h-2 rounded-full {{ $menu['active'] ? 'bg-emerald-500' : 'bg-slate-300 dark:bg-slate-600' }} shrink-0"></span>
                                {{ $menu['label'] }}
                            </a>
                        @else
                            <button @click="open = !open"
                                    class="w-full flex items-center justify-between gap-3 px-4 py-3 min-h-[48px] rounded-xl text-sm font-semibold transition-all duration-200
                                           {{ $menu['active']
                                             ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300'
                                             : 'text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800/80' }}">
                                <span class="flex items-center gap-3">
                                    <span class="w-2 h-2 rounded-full {{ $menu['active'] ? 'bg-emerald-500' : 'bg-slate-300 dark:bg-slate-600' }} shrink-0"></span>
                                    {{ $menu['label'] }}
                                </span>
                                <svg class="w-4 h-4 transition-transform duration-300 opacity-60 shrink-0"
                                     :class="open ? 'rotate-180' : ''"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 -translate-y-2"
                                 x-cloak
                                 class="mt-1 ml-5 pl-4 border-l-2 border-emerald-200 dark:border-emerald-800/60 space-y-0.5">
                                @foreach($menu['children'] as $child)
                                    <a href="{{ route($child['route']) }}"
                                       @click="mobileOpen = false"
                                       class="block px-3 py-2.5 min-h-[44px] flex items-center text-sm text-slate-600 dark:text-slate-300
                                              hover:text-emerald-600 dark:hover:text-emerald-400 rounded-lg
                                              hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-all duration-150">
                                        {{ $child['label'] }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach

                {{-- Mobile CTA --}}
                <div class="pt-3 border-t border-slate-200/60 dark:border-slate-700/60">
                    <a href="{{ route('contact') }}"
                       @click="mobileOpen = false"
                       class="flex items-center justify-center gap-2 w-full px-4 py-3 rounded-xl text-sm font-bold
                              bg-gradient-to-r from-emerald-600 to-emerald-700 text-white
                              shadow-lg shadow-emerald-500/25 hover:shadow-emerald-500/40
                              hover:from-emerald-500 hover:to-emerald-600
                              transition-all duration-300 active:scale-[0.98]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
