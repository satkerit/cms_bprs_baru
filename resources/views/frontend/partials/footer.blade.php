@php
    $company = $company ?? \App\Models\CompanyInfo::getInfo();
@endphp

<footer class="bg-gradient-to-br from-emerald-950 via-emerald-900 to-[#022c22] text-white relative overflow-hidden">
    {{-- ─── Decorative Background Elements ─── --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        {{-- Subtle grid pattern overlay --}}
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: url(\"data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E\");"></div>

        {{-- Floating gradient orbs --}}
        <div class="absolute -top-20 -left-20 w-72 h-72 bg-emerald-500/10 rounded-full blur-3xl animate-float" style="animation-delay: 0s; animation-duration: 8s;"></div>
        <div class="absolute top-1/3 -right-16 w-80 h-80 bg-emerald-400/10 rounded-full blur-3xl animate-float" style="animation-delay: 2s; animation-duration: 10s;"></div>
        <div class="absolute -bottom-32 left-1/4 w-96 h-96 bg-emerald-300/8 rounded-full blur-3xl animate-float" style="animation-delay: 4s; animation-duration: 12s;"></div>
    </div>

    {{-- ─── Elegant Top Border ─── --}}
    <div class="relative h-1.5 w-full bg-gradient-to-r from-emerald-500 via-emerald-400 to-emerald-500 opacity-90"></div>

    {{-- ─── MAIN FOOTER CONTENT ─── --}}
    <div class="relative z-10 pt-20 pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 lg:gap-10">
                {{-- ═══ COLUMN 1: Company Info ═══ --}}
                <div class="fade-in-section" x-intersect="$el.classList.add('is-visible')">
                    <div class="mb-6">
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
                            @if($company?->logo)
                            <img src="{{ \App\Helpers\StorageHelper::url($company->logo) }}"
                                 alt="{{ $company->name }}"
                                 class="h-12 w-auto max-w-[180px] object-contain transition-all duration-300 group-hover:scale-105">
                            @else
                            <div class="w-11 h-11 bg-gradient-to-br from-emerald-600 to-emerald-800 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20 transition-transform duration-300 group-hover:scale-110">
                                <span class="text-white font-heading font-bold text-lg">B</span>
                            </div>
                            @endif
                        </a>
                    </div>

                    <p class="text-white/80 dark:text-slate-300 leading-relaxed text-sm mb-6">
                        {{ $company->footer_description ?? $company->short_description ?? 'Melayani dengan prinsip syariah untuk kesejahteraan masyarakat Negeri Serumpun Sebalai.' }}
                    </p>

                    {{-- Regulatory Info ── --}}
                    <div class="space-y-2 mb-6">
                        @if($company?->ojk_tagline)
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-500/10 rounded-lg border border-emerald-500/20">
                                <svg class="w-3.5 h-3.5 text-emerald-400 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                </svg>
                                <span class="text-sm text-emerald-300 font-medium">{{ $company->ojk_tagline }}</span>
                            </div>
                        @endif
                        @if($company?->lps_tagline)
                            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-sky-500/10 rounded-lg border border-sky-500/20">
                                <svg class="w-3.5 h-3.5 text-sky-400 shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4z"/>
                                </svg>
                                <span class="text-sm text-sky-300 font-medium">{{ $company->lps_tagline }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Badges ── --}}
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-500/15 text-emerald-400 rounded-full text-xs font-semibold border border-emerald-500/30 transition-all duration-300 hover:bg-emerald-500/25 hover:border-emerald-500/50">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            Terdaftar OJK
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-sky-500/15 text-sky-400 rounded-full text-xs font-semibold border border-sky-500/30 transition-all duration-300 hover:bg-sky-500/25 hover:border-sky-500/50">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            Peserta LPS
                        </span>
                    </div>

                    {{-- Social Media with refined hover --}}
                    <div>
                        <h4 class="text-sm font-heading font-bold text-white/80 dark:text-slate-300 mb-4 tracking-wide uppercase">
                            Ikuti Kami
                        </h4>
                        <div class="flex gap-2.5">
                            @php
                                $socialLinks = [
                                    'facebook' => ['url' => $company->facebook ?? null, 'path' => 'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z'],
                                    'instagram' => ['url' => $company->instagram ?? null, 'path' => 'M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z'],
                                    'youtube' => ['url' => $company->youtube ?? null, 'path' => 'M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z'],
                                    'twitter' => ['url' => $company->twitter ?? null, 'path' => 'M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z'],
                                    'tiktok' => ['url' => $company->tiktok ?? null, 'path' => 'M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z'],
                                    'linkedin' => ['url' => $company->linkedin ?? null, 'path' => 'M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z'],
                                ];
                            @endphp
                            @foreach($socialLinks as $name => $link)
                                @if($link['url'])
                                <a href="{{ $link['url'] }}" target="_blank"
                                   class="group relative w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-300 bg-white/5 border border-white/10 hover:-translate-y-1"
                                   aria-label="{{ ucfirst($name) }}">
                                    {{-- Glow on hover --}}
                                    <div class="absolute inset-0 rounded-xl bg-emerald-600/0 group-hover:bg-emerald-500/20 transition-all duration-300"></div>
                                    <svg class="relative w-4 h-4 text-white/70 group-hover:text-emerald-300 transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="{{ $link['path'] }}"/>
                                    </svg>
                                </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- ═══ COLUMN 2: Quick Links ═══ --}}
                <div class="fade-in-section" x-intersect="$el.classList.add('is-visible')" style="transition-delay: 100ms;">
                    <h4 class="text-base font-heading font-bold text-white mb-6 tracking-tight flex items-center gap-2">
                        <span class="w-1 h-5 bg-emerald-500 rounded-full inline-block"></span>
                        Navigasi Cepat
                    </h4>
                    <ul class="space-y-2.5">
                        @php
                            $quickLinks = [
                                ['label' => 'Profil Perusahaan', 'route' => 'about.company'],
                                ['label' => 'Produk & Layanan', 'route' => 'products.simpanan-syariah'],
                                ['label' => 'Berita & Artikel', 'route' => 'news.index'],
                                ['label' => 'Lelang Agunan', 'route' => 'auctions.index'],
                                ['label' => 'Karir', 'route' => 'careers.index'],
                                ['label' => 'Laporan Publikasi', 'route' => 'reports.keuangan-publikasi'],
                                ['label' => 'Hubungi Kami', 'route' => 'contact'],
                            ];
                        @endphp
                        @foreach($quickLinks as $link)
                        <li>
                            <a href="{{ route($link['route']) }}"
                               class="group flex items-center gap-2.5 text-white/80 hover:text-emerald-300 transition-all duration-200 text-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-white/50 group-hover:bg-emerald-400 transition-all duration-200"></span>
                                <span>{{ $link['label'] }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- ═══ COLUMN 3: Contact Info ═══ --}}
                <div class="fade-in-section" x-intersect="$el.classList.add('is-visible')" style="transition-delay: 200ms;">
                    <h4 class="text-base font-heading font-bold text-white mb-6 tracking-tight flex items-center gap-2">
                        <span class="w-1 h-5 bg-emerald-500 rounded-full inline-block"></span>
                        Hubungi Kami
                    </h4>

                    <div class="space-y-4">
                        @if($company?->address)
                        <div class="group flex gap-3.5 p-3 rounded-xl bg-white/5 border border-white/10 hover:bg-white/[0.07] hover:border-emerald-400/30 transition-all duration-300">
                            <div class="w-10 h-10 rounded-lg bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center shrink-0 group-hover:bg-emerald-500/20 transition-all duration-300">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[11px] text-white/60 font-medium uppercase tracking-wider mb-0.5">Alamat</p>
                                <p class="text-sm text-white/80 leading-relaxed">{{ $company->address }}</p>
                            </div>
                        </div>
                        @endif

                        @if($company?->phone)
                        <div class="group flex gap-3.5 p-3 rounded-xl bg-white/5 border border-white/10 hover:bg-white/[0.07] hover:border-emerald-400/30 transition-all duration-300">
                            <div class="w-10 h-10 rounded-lg bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center shrink-0 group-hover:bg-emerald-500/20 transition-all duration-300">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[11px] text-white/60 font-medium uppercase tracking-wider mb-0.5">Telepon</p>
                                <a href="tel:{{ $company->phone }}" class="text-sm text-white/80 font-semibold hover:text-emerald-300 transition-colors">{{ $company->phone }}</a>
                            </div>
                        </div>
                        @endif

                        @if($company?->email)
                        <div class="group flex gap-3.5 p-3 rounded-xl bg-white/5 border border-white/10 hover:bg-white/[0.07] hover:border-emerald-400/30 transition-all duration-300">
                            <div class="w-10 h-10 rounded-lg bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center shrink-0 group-hover:bg-emerald-500/20 transition-all duration-300">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[11px] text-white/60 font-medium uppercase tracking-wider mb-0.5">Email</p>
                                <a href="mailto:{{ $company->email }}" class="text-sm text-white/80 font-semibold hover:text-emerald-300 transition-colors">{{ $company->email }}</a>
                            </div>
                        </div>
                        @endif

                        @if($company?->fax)
                        <div class="group flex gap-3.5 p-3 rounded-xl bg-white/5 border border-white/10 hover:bg-white/[0.07] hover:border-emerald-400/30 transition-all duration-300">
                            <div class="w-10 h-10 rounded-lg bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center shrink-0 group-hover:bg-emerald-500/20 transition-all duration-300">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-[11px] text-white/60 font-medium uppercase tracking-wider mb-0.5">Fax</p>
                                <p class="text-sm text-white/80">{{ $company->fax }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ─── BOTTOM BAR ─── --}}
    <div class="relative z-10">
        {{-- Elegant gradient divider --}}
        <div class="h-px mx-auto max-w-7xl bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-white/60 text-xs leading-relaxed text-center sm:text-left">
                    &copy; {{ date('Y') }} {{ $company->name ?? 'BPRS Bangka Belitung' }}. All rights reserved.
                    <br class="sm:hidden">
                    <span class="hidden sm:inline">—</span>
                    <span class="text-white/50">Bank Perekonomian Rakyat Syariah (BPRS) Bangka Belitung.</span>
                </p>
                <div class="flex items-center gap-4 text-xs">
                    <span class="text-white/50">v{{ config('app.version', '1.1') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ─── BACK TO TOP ─── --}}
    <button x-data="{ show: false }"
            @scroll.window="show = window.scrollY > 300"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-95"
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            class="fixed bottom-6 right-6 w-12 h-12 bg-gradient-to-br from-emerald-600 to-emerald-800 hover:from-emerald-700 hover:to-emerald-700 text-white rounded-2xl shadow-xl shadow-emerald-500/25 hover:shadow-emerald-500/40 flex items-center justify-center z-50 border-0 cursor-pointer btn-press transition-all duration-300"
            aria-label="Kembali ke atas"
            x-cloak>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
        </svg>
    </button>
</footer>
