<x-frontend-layout>
    <x-slot:title>Profil Perusahaan - {{ $info->name ?? config('app.name') }}</x-slot:title>
    <x-slot:metaDescription>{{ $info->tagline ?? 'Profil perusahaan — visi, misi, sejarah, dan informasi lengkap.' }}</x-slot:metaDescription>
    <x-slot:metaKeywords>Profil Perusahaan, {{ $info->name ?? config('app.name') }}, Visi Misi, Sejarah Perusahaan, OJK, LPS</x-slot:metaKeywords>

    @php
        $info          = $companyInfo;
        $logo          = $info?->logo          ? \App\Helpers\StorageHelper::url($info->logo)          : null;
        $profileImage  = $info?->profile_image ? \App\Helpers\StorageHelper::url($info->profile_image) : $logo;
        $companyName   = $info?->name          ?? config('app.name');
        $establishedYear = (int) ($info?->established_year ?? 0);
        $tagline       = $info?->tagline       ?? '';
        $description   = $info?->description   ?? '';
        $vision        = $info?->vision        ?? '';
        $missions      = $info?->mission
                            ? collect(explode("\n", $info->mission))->map(fn($m) => trim($m))->filter()
                            : collect();
        $history       = $info?->history       ?? '';

        // Statistik dari DB — tidak ada hardcode
        $statYears     = (int) ($info?->stat_years_experience    ?? 0);
        $statBranch    = (int) ($info?->stat_branch_offices      ?? 0);
        $statCash      = (int) ($info?->stat_cash_offices        ?? 0);
        $statMobile    = (int) ($info?->stat_mobile_cash_offices ?? 0);

        // Hitung tahun beroperasi: gunakan stat_years_experience jika ada, fallback kalkulasi
        $yearsDisplay  = $statYears > 0
                            ? $statYears
                            : ($establishedYear > 0 ? (date('Y') - $establishedYear) : null);

        // Apakah ada data regulasi
        $hasRegulasi   = $info?->ojk_license || $info?->ojk_tagline || $info?->lps_tagline;

        // Jam operasional
        $operationalHours = is_array($info?->operational_hours) ? $info->operational_hours : [];

        $nonce = request()->attributes->get('csp_nonce');
    @endphp

    {{-- ═══ HERO ═══ --}}
    <section class="relative pt-8 sm:pt-10 md:pt-12 pb-20 sm:pb-24 md:pb-32 overflow-hidden">
        {{-- Background --}}
        <div class="absolute inset-0 hero-gradient">
            <div class="absolute inset-0 bg-grid-pattern opacity-30"></div>
            <div class="absolute top-0 right-0 w-[600px] h-[600px] bg-emerald-300/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-amber-300/10 rounded-full blur-3xl translate-y-1/3"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-center">

                {{-- Kiri: Teks --}}
                <div class="reveal-up" x-intersect="$el.classList.add('is-visible')">
                    <span class="eyebrow-badge mb-5 inline-flex bg-white/20 text-white border-white/25">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Tentang Kami
                    </span>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight tracking-tight mb-5">
                        Profil<br>
                        <span class="text-emerald-300">Perusahaan</span>
                    </h1>

                    @if($tagline)
                    <p class="text-white/80 text-base sm:text-lg leading-relaxed mb-8 w-full">
                        {{ $tagline }}
                    </p>
                    @endif

                    {{-- Badge stats: hanya tampil jika ada data --}}
                    <div class="flex flex-wrap gap-3">
                        @if($yearsDisplay)
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl px-4 py-3 text-center border border-white/15">
                            <div class="text-2xl sm:text-3xl font-bold text-white">{{ $yearsDisplay }}+</div>
                            <div class="text-xs text-white/70 mt-1 leading-tight">Tahun<br>Beroperasi</div>
                        </div>
                        @endif
                        @if($info?->ojk_license || $info?->ojk_tagline)
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl px-4 py-3 text-center border border-white/15">
                            <div class="text-2xl sm:text-3xl font-bold text-emerald-300">OJK</div>
                            <div class="text-xs text-white/70 mt-1 leading-tight">Terdaftar &amp;<br>Diawasi</div>
                        </div>
                        @endif
                        @if($info?->lps_tagline || $info?->lps_guarantee_amount)
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl px-4 py-3 text-center border border-white/15">
                            <div class="text-2xl sm:text-3xl font-bold text-amber-300">LPS</div>
                            <div class="text-xs text-white/70 mt-1 leading-tight">Dijamin<br>Pemerintah</div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Kanan: Card info --}}
                <div class="reveal-up" x-intersect="$el.classList.add('is-visible')" style="animation-delay:.15s">
                    <div class="bg-white/10 backdrop-blur-md rounded-3xl border border-white/20 p-6 sm:p-8 space-y-5">
                        {{-- Logo --}}
                        @if($logo)
                            <div class="flex justify-center">
                                <img src="{{ $logo }}" alt="{{ $companyName }}"
                                     class="h-16 sm:h-20 object-contain rounded-xl bg-white/90 px-4 py-2 shadow-lg">
                            </div>
                        @else
                            <div class="flex justify-center">
                                <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                            </div>
                        @endif

                        <h2 class="text-white font-bold text-lg sm:text-xl text-center leading-snug">{{ $companyName }}</h2>

                        <div class="space-y-3 pt-2 border-t border-white/15">
                            @if($info?->address)
                            <div class="flex items-start gap-3 text-sm text-white/80">
                                <svg class="w-4 h-4 mt-0.5 text-emerald-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span>{{ $info->address }}</span>
                            </div>
                            @endif
                            @if($info?->phone)
                            <div class="flex items-center gap-3 text-sm text-white/80">
                                <svg class="w-4 h-4 text-emerald-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                <span>{{ $info->phone }}</span>
                            </div>
                            @endif
                            @if($info?->email)
                            <div class="flex items-center gap-3 text-sm text-white/80">
                                <svg class="w-4 h-4 text-emerald-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <span>{{ $info->email }}</span>
                            </div>
                            @endif
                            @if($info?->website)
                            <div class="flex items-center gap-3 text-sm text-white/80">
                                <svg class="w-4 h-4 text-emerald-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9"/></svg>
                                <span>{{ $info->website }}</span>
                            </div>
                            @endif
                        </div>

                        @if($establishedYear)
                        <div class="flex items-center justify-center gap-2 text-xs text-white/60 pt-2 border-t border-white/15">
                            <svg class="w-3.5 h-3.5 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Berdiri sejak {{ $establishedYear }}
                        </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ═══ TENTANG KAMI ═══ --}}
    <section class="py-16 sm:py-20 lg:py-24 bg-white dark:bg-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-intersect="$el.classList.add('is-visible')">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                <div class="reveal-up">
                    <span class="eyebrow-badge mb-3 inline-flex">Tentang Kami</span>
                    <h2 class="text-3xl sm:text-4xl font-bold text-foreground dark:text-slate-100 tracking-tight leading-tight mb-6">
                        Sekilas {{ $companyName }}
                    </h2>
                    <div class="space-y-4 text-secondary dark:text-slate-400 leading-relaxed">
                        <p>{{ $description }}</p>
                        @if($establishedYear)
                            <p class="flex items-center gap-2 text-foreground dark:text-slate-200 font-medium">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Berdiri sejak {{ $establishedYear }}
                            </p>
                        @endif
                    </div>
                </div>
                {{-- Grid statistik: hanya tampilkan card yang > 0 --}}
                @php
                    $statsGrid = array_filter([
                        ['val' => $yearsDisplay,  'label' => 'Tahun Pengalaman', 'color' => 'emerald'],
                        ['val' => $statBranch,    'label' => 'Kantor Cabang',    'color' => 'amber'],
                        ['val' => $statCash,      'label' => 'Kantor Kas',       'color' => 'emerald'],
                        ['val' => $statMobile,    'label' => 'Kas Mobil/Keliling','color' => 'amber'],
                    ], fn($s) => $s['val'] > 0);
                @endphp
                @if(count($statsGrid) > 0 || $profileImage)
                <div class="space-y-6 reveal-up" style="transition-delay:100ms">
                    @if($profileImage)
                    <div class="rounded-2xl overflow-hidden shadow-lg">
                        <img src="{{ $profileImage }}" alt="{{ $companyName }}"
                             class="w-full h-48 sm:h-56 object-cover">
                    </div>
                    @endif
                    @if(count($statsGrid) > 0)
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($statsGrid as $stat)
                        <div class="bg-{{ $stat['color'] }}-50 dark:bg-{{ $stat['color'] }}-900/20 rounded-2xl p-5 text-center border border-{{ $stat['color'] }}-100 dark:border-{{ $stat['color'] }}-800/30">
                            <div class="text-3xl sm:text-4xl font-bold text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400 mb-1">{{ $stat['val'] }}</div>
                            <div class="text-xs sm:text-sm text-{{ $stat['color'] }}-700 dark:text-{{ $stat['color'] }}-300 font-medium">{{ $stat['label'] }}</div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </section>

    {{-- ═══ VISI & MISI ═══ --}}
    @if($vision || $missions->isNotEmpty())
    <section class="py-16 sm:py-20 lg:py-24 bg-muted dark:bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-intersect="$el.classList.add('is-visible')">
            <div class="text-center mb-14 reveal-up">
                <span class="eyebrow-badge mb-3 inline-flex">Arah & Tujuan</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-foreground dark:text-slate-100 tracking-tight leading-tight">
                    Visi & Misi
                </h2>
            </div>
            <div class="grid lg:grid-cols-2 gap-10 lg:gap-14">
                {{-- Visi --}}
                <div class="reveal-up bg-white dark:bg-slate-800 rounded-2xl p-8 sm:p-10 border border-border dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex items-center justify-center w-14 h-14 rounded-xl bg-emerald-50 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400 shrink-0">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-foreground dark:text-slate-100">Visi</h3>
                    </div>
                    <p class="text-secondary dark:text-slate-400 leading-relaxed text-base italic border-l-4 border-emerald-400 pl-4">
                        "{{ $vision }}"
                    </p>
                </div>

                {{-- Misi --}}
                <div class="reveal-up bg-white dark:bg-slate-800 rounded-2xl p-8 sm:p-10 border border-border dark:border-slate-700 shadow-sm hover:shadow-md transition-shadow" style="transition-delay:100ms">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex items-center justify-center w-14 h-14 rounded-xl bg-amber-50 dark:bg-amber-900/50 text-amber-600 dark:text-amber-400 shrink-0">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold text-foreground dark:text-slate-100">Misi</h3>
                    </div>
                    <ul class="space-y-3">
                        @foreach($missions as $mission)
                        <li class="flex items-start gap-3 text-secondary dark:text-slate-400">
                            <svg class="w-5 h-5 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-base leading-relaxed">{{ $mission }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ REGULASI & KEAMANAN ═══ --}}
    @if($hasRegulasi)
    <section class="py-16 sm:py-20 lg:py-24 bg-slate-50 dark:bg-slate-950">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="text-center mb-12">
                <span class="eyebrow-badge mb-3 inline-flex">Legalitas & Keamanan</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-foreground dark:text-slate-100 tracking-tight">
                    Regulasi & Keamanan
                </h2>
                <p class="mt-4 text-secondary dark:text-slate-400 text-base">
                    Dana Anda aman dan diawasi oleh otoritas resmi pemerintah Republik Indonesia.
                </p>
            </div>

            {{-- Cards stacked vertical — tidak ada grid yang bisa overlap --}}
            <div class="flex flex-col gap-6">

                {{-- OJK --}}
                @if($info?->ojk_license || $info?->ojk_tagline)
                <div class="bg-white dark:bg-slate-800 rounded-2xl border border-emerald-100 dark:border-emerald-900/40 shadow-sm p-6 sm:p-8">
                    <div class="flex items-start gap-5">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center shrink-0">
                            <svg class="w-8 h-8 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest bg-emerald-50 dark:bg-emerald-900/40 px-2.5 py-1 rounded-full">OJK</span>
                                <h3 class="text-base sm:text-lg font-bold text-foreground dark:text-slate-100">Terdaftar &amp; Diawasi OJK</h3>
                            </div>
                            @if($info?->ojk_license)
                            <p class="text-sm text-secondary dark:text-slate-400 font-mono mb-2">No. {{ $info->ojk_license }}</p>
                            @endif
                            @if($info?->ojk_tagline)
                            <p class="text-sm text-secondary dark:text-slate-400 leading-relaxed">{{ $info->ojk_tagline }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                {{-- LPS --}}
                @if($info?->lps_tagline || $info?->lps_guarantee_amount)
                <div class="bg-white dark:bg-slate-800 rounded-2xl border border-amber-100 dark:border-amber-900/40 shadow-sm p-6 sm:p-8">
                    <div class="flex items-start gap-5">
                        <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center shrink-0">
                            <svg class="w-8 h-8 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                <span class="text-xs font-bold text-amber-600 dark:text-amber-400 uppercase tracking-widest bg-amber-50 dark:bg-amber-900/40 px-2.5 py-1 rounded-full">LPS</span>
                                <h3 class="text-base sm:text-lg font-bold text-foreground dark:text-slate-100">Dijamin LPS</h3>
                            </div>
                            @if($info?->lps_guarantee_amount)
                            <p class="text-sm font-semibold text-amber-600 dark:text-amber-400 mb-2">
                                Dijamin s.d. {{ is_numeric($info->lps_guarantee_amount) ? 'Rp ' . number_format($info->lps_guarantee_amount, 0, ',', '.') : $info->lps_guarantee_amount }}
                            </p>
                            @endif
                            @if($info?->lps_tagline)
                            <p class="text-sm text-secondary dark:text-slate-400 leading-relaxed">{{ $info->lps_tagline }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </section>
    @endif

    {{-- ═══ JAM OPERASIONAL ═══ --}}
    @if(count($operationalHours) > 0)
    <section class="py-16 sm:py-20 lg:py-24 bg-slate-50 dark:bg-slate-950">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 reveal-up" x-intersect="$el.classList.add('is-visible')">
                <span class="eyebrow-badge mb-3 inline-flex">Layanan</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-foreground dark:text-slate-100 tracking-tight leading-tight">
                    Jam Operasional
                </h2>
            </div>
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-border dark:border-slate-700 shadow-sm overflow-hidden reveal-up"
                 x-intersect="$el.classList.add('is-visible')">
                @foreach($operationalHours as $i => $schedule)
                <div class="flex items-center justify-between px-6 py-4 {{ !$loop->last ? 'border-b border-border dark:border-slate-700' : '' }} {{ $loop->even ? 'bg-slate-50/60 dark:bg-slate-700/20' : '' }}">
                    <span class="font-medium text-foreground dark:text-slate-200 text-sm sm:text-base">
                        {{ $schedule['day'] ?? $schedule[0] ?? '' }}
                    </span>
                    <span class="text-sm sm:text-base text-secondary dark:text-slate-400 font-mono">
                        @if(isset($schedule['open']) && isset($schedule['close']))
                            {{ $schedule['open'] }} &ndash; {{ $schedule['close'] }}
                        @elseif(isset($schedule[1]))
                            {{ $schedule[1] }}
                        @else
                            Tutup
                        @endif
                    </span>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ SEJARAH ═══ --}}
    @if($history)
    <section class="py-16 sm:py-20 lg:py-24 bg-white dark:bg-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14 reveal-up" x-intersect="$el.classList.add('is-visible')">
                <span class="eyebrow-badge mb-3 inline-flex">Perjalanan</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-foreground dark:text-slate-100 tracking-tight leading-tight">Sejarah Perusahaan</h2>
            </div>
            <div class="max-w-4xl mx-auto prose prose-lg dark:prose-invert reveal-up"
                 x-intersect="$el.classList.add('is-visible')">
                {!! $history !!}
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ CTA ═══ --}}
    <section class="py-16 sm:py-20 lg:py-24 bg-muted dark:bg-slate-950" x-intersect="$el.classList.add('is-visible')">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center reveal-up">
            <div class="bg-gradient-to-br from-emerald-600 to-emerald-800 dark:from-emerald-700 dark:to-emerald-900 rounded-3xl p-10 sm:p-14 shadow-xl">
                <h2 class="text-2xl sm:text-3xl font-bold text-white mb-3 leading-tight tracking-tight">
                    Bergabung dengan {{ $companyName }}
                </h2>
                <p class="text-emerald-50/80 text-base sm:text-lg mb-8 mx-auto leading-relaxed">
                    Jadilah bagian dari keluarga besar {{ $companyName }}. Nikmati layanan keuangan syariah yang aman, nyaman, dan sesuai prinsip.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('products.simpanan-syariah') }}"
                       class="inline-flex items-center gap-2 bg-white dark:bg-slate-800 text-emerald-700 dark:text-emerald-400 font-semibold px-8 py-3.5 rounded-xl hover:bg-emerald-50 dark:hover:bg-emerald-900/50 hover:-translate-y-0.5 transition-all duration-300 shadow-lg">
                        Lihat Produk
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a href="{{ route('contact') }}"
                       class="inline-flex items-center gap-2 bg-emerald-500/20 text-white border border-emerald-400/30 font-semibold px-8 py-3.5 rounded-xl hover:bg-emerald-500/30 hover:-translate-y-0.5 transition-all duration-300">
                        Hubungi Kami
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-frontend-layout>
