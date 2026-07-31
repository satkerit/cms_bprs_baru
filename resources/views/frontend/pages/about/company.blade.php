<x-frontend-layout>
    <x-slot:title>Profil Perusahaan - {{ $info->company_name ?? 'BPRS Bangka Belitung' }}</x-slot:title>
    <x-slot:metaDescription>Profil BPRS Bangka Belitung — bank pembiayaan rakyat syariah yang berkomitmen memberikan layanan keuangan syariah terbaik untuk masyarakat Bangka Belitung.</x-slot:metaDescription>
    <x-slot:metaKeywords>BPRS Bangka Belitung, Profil Perusahaan, Bank Syariah, Visi Misi, Sejarah Perusahaan</x-slot:metaKeywords>

    @php
        // Gunakan fallback statis jika $companyInfo dari database belum tersedia
        $info = $companyInfo;
        $logo = isset($info) && $info?->logo ? \App\Helpers\StorageHelper::url($info->logo) : null;
        $companyName = $info?->company_name ?? 'BPRS Bangka Belitung';
        $establishedYear = $info?->established_year ?? '2010';
        $description = $info?->description ?? 'BPRS Bangka Belitung adalah bank pembiayaan rakyat syariah yang resmi beroperasi melayani masyarakat Bangka Belitung. Berkomitmen menghadirkan layanan keuangan yang transparan, adil, dan sesuai prinsip syariah. Dengan dukungan sumber daya profesional dan teknologi modern, BPRS Bangka Belitung terus berinovasi untuk memberikan solusi keuangan syariah yang terbaik bagi nasabah.';
        $vision = $info?->vision ?? 'Menjadi bank pembiayaan rakyat syariah terdepan dan terpercaya di Bangka Belitung yang memberikan solusi keuangan syariah yang inovatif dan berkelanjutan.';
        $missionText = $info?->mission ?? 'Memberikan layanan pembiayaan dan simpanan syariah yang berkualitas, Membangun kemitraan yang saling menguntungkan dengan nasabah dan stakeholder, Mengembangkan sumber daya manusia yang profesional dan berintegritas, Menerapkan tata kelola perusahaan yang baik (GCG) sesuai prinsip syariah.';
        $missions = collect(explode("\n", $missionText))->map(fn($m) => trim($m))->filter();
        $history = $info?->history ?? '';
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

                    <p class="text-white/80 text-base sm:text-lg leading-relaxed mb-8 w-full">
                        {{ $companyName }} — bank pembiayaan rakyat syariah yang berkomitmen menghadirkan layanan keuangan syariah terbaik, transparan, dan amanah untuk masyarakat Bangka Belitung.
                    </p>

                    {{-- Stats row --}}
                    <div class="grid grid-cols-3 gap-4 sm:gap-6">
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl px-4 py-4 text-center border border-white/15">
                            <div class="text-2xl sm:text-3xl font-bold text-white">{{ date('Y') - (int)$establishedYear }}+</div>
                            <div class="text-xs text-white/70 mt-1 leading-tight">Tahun<br>Beroperasi</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl px-4 py-4 text-center border border-white/15">
                            <div class="text-2xl sm:text-3xl font-bold text-emerald-300">OJK</div>
                            <div class="text-xs text-white/70 mt-1 leading-tight">Terdaftar &amp;<br>Diawasi</div>
                        </div>
                        <div class="bg-white/10 backdrop-blur-sm rounded-2xl px-4 py-4 text-center border border-white/15">
                            <div class="text-2xl sm:text-3xl font-bold text-amber-300">LPS</div>
                            <div class="text-xs text-white/70 mt-1 leading-tight">Dijamin<br>Pemerintah</div>
                        </div>
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
                <div class="grid grid-cols-2 gap-4 reveal-up" style="transition-delay:100ms">
                    <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl p-6 text-center border border-emerald-100 dark:border-emerald-800/30">
                        <div class="text-4xl font-bold text-emerald-600 dark:text-emerald-400 mb-1">{{ $info?->statistics['years_experience'] ?? number_format(now()->year - (int)$establishedYear) }}</div>
                        <div class="text-xs sm:text-sm text-emerald-700 dark:text-emerald-300 font-medium">Tahun Pengalaman</div>
                    </div>
                    <div class="bg-amber-50 dark:bg-amber-900/20 rounded-2xl p-6 text-center border border-amber-100 dark:border-amber-800/30">
                        <div class="text-4xl font-bold text-amber-600 dark:text-amber-400 mb-1">{{ $info?->statistics['branch_offices'] ?? '3' }}</div>
                        <div class="text-xs sm:text-sm text-amber-700 dark:text-amber-300 font-medium">Kantor Cabang</div>
                    </div>
                    <div class="bg-emerald-50 dark:bg-emerald-900/20 rounded-2xl p-6 text-center border border-emerald-100 dark:border-emerald-800/30">
                        <div class="text-4xl font-bold text-emerald-600 dark:text-emerald-400 mb-1">{{ $info?->statistics['total_assets'] ?? '100+' }}</div>
                        <div class="text-xs sm:text-sm text-emerald-700 dark:text-emerald-300 font-medium">Jumlah Karyawan</div>
                    </div>
                    <div class="bg-amber-50 dark:bg-amber-900/20 rounded-2xl p-6 text-center border border-amber-100 dark:border-amber-800/30">
                        <div class="text-4xl font-bold text-amber-600 dark:text-amber-400 mb-1">{{ $info?->statistics['cash_offices'] ?? '5000+' }}</div>
                        <div class="text-xs sm:text-sm text-amber-700 dark:text-amber-300 font-medium">Nasabah Terlayani</div>
                    </div>
                </div>
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

    {{-- ═══ SEJARAH (jika ada) ═══ --}}
    @if($history)
    <section class="py-16 sm:py-20 lg:py-24 bg-white dark:bg-slate-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14 reveal-up" x-intersect="$el.classList.add('is-visible')">
                <span class="eyebrow-badge mb-3 inline-flex">Perjalanan</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-foreground dark:text-slate-100 tracking-tight leading-tight">Sejarah Perusahaan</h2>
            </div>
            <div class="max-w-4xl mx-auto prose prose-lg dark:prose-invert reveal-up" x-intersect="$el.classList.add('is-visible')">
                {!! nl2br(e($history)) !!}
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
