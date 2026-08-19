<x-frontend-layout>
    <x-slot name="title">Manajemen - {{ $companyInfo?->name ?? 'BPRS Bangka Belitung' }}</x-slot>
    <x-slot name="metaDescription">{{ $metaDescription ?? 'Dewan Komisaris, Dewan Direksi, dan Dewan Pengawas Syariah BPRS Bangka Belitung.' }}</x-slot>

    @php
        $companyInfo = \App\Models\CompanyInfo::getInfo();
        $hasAny = $komisaris->isNotEmpty() || $direksi->isNotEmpty() || $pengawasSyariah->isNotEmpty();
    @endphp

    {{-- ═══ HERO ═══ --}}
    <section class="relative pt-8 sm:pt-10 md:pt-12 pb-12 sm:pb-14 md:pb-16 overflow-hidden">
        <div class="absolute inset-0 hero-gradient">
            <div class="absolute inset-0 bg-grid-pattern opacity-30"></div>
            <div class="absolute top-10 left-1/4 w-80 h-80 bg-emerald-400/20 rounded-full blur-3xl animate-float-slow"></div>
            <div class="absolute bottom-10 right-1/4 w-96 h-96 bg-emerald-400/20 rounded-full blur-3xl animate-float-slow" style="animation-delay: 3s;"></div>
        </div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="eyebrow-badge mb-5 inline-flex bg-white/20 text-white border-white/20">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Tentang Kami
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-white mb-4 sm:mb-6 tracking-tight leading-tight">Tentang Manajemen</h1>
            <p class="text-base sm:text-lg md:text-xl text-white/90 mx-auto px-4 leading-relaxed">
                {{ $companyInfo?->name ?? 'BPRS Bangka Belitung' }} yang memastikan tata kelola bank berjalan transparan, akuntabel, dan sesuai prinsip syariah.
            </p>
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-muted/30 to-transparent"></div>
    </section>

    {{-- ═══ BOARD SECTIONS ═══ --}}
    <section class="pb-20 lg:pb-28">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($hasAny)

                {{-- ══ DEWAN KOMISARIS ══ --}}
                @if($komisaris->isNotEmpty())
                <div class="mb-20 lg:mb-28">
                    <div class="text-center mb-12">
                        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200/50 dark:border-emerald-800/50 text-[10px] font-bold uppercase tracking-widest shadow-sm mb-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                            Struktur Kepemimpinan
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-bold text-foreground dark:text-slate-100">Dewan Komisaris</h2>
                    </div>
                    <div class="flex flex-wrap justify-center gap-6 sm:gap-8">
                        @foreach($komisaris as $index => $member)
                            <div class="w-40 sm:w-48 md:w-52">
                                @include('frontend.pages.about.partials.board-member-card', ['member' => $member, 'index' => $index, 'accent' => 'emerald'])
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- ══ DEWAN PENGAWAS SYARIAH ══ --}}
                @if($pengawasSyariah->isNotEmpty())
                <div class="mb-20 lg:mb-28">
                    <div class="text-center mb-12">
                        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 border border-amber-200/50 dark:border-amber-800/50 text-[10px] font-bold uppercase tracking-widest shadow-sm">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 inline-block"></span>
                            Kepatuhan Syariah
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-bold text-foreground dark:text-slate-100">Dewan Pengawas Syariah</h2>
                    </div>
                    <div class="flex flex-wrap justify-center gap-6 sm:gap-8">
                        @foreach($pengawasSyariah as $index => $member)
                            <div class="w-40 sm:w-48 md:w-52">
                                @include('frontend.pages.about.partials.board-member-card', ['member' => $member, 'index' => $index, 'accent' => 'amber'])
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- ══ DEWAN DIREKSI ══ --}}
                @if($direksi->isNotEmpty())
                <div class="mb-12">
                    <div class="text-center mb-12">
                        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200/50 dark:border-emerald-800/50 text-[10px] font-bold uppercase tracking-widest shadow-sm mb-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 inline-block"></span>
                            Kepemimpinan Eksekutif
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-bold text-foreground dark:text-slate-100">Dewan Direksi</h2>
                    </div>
                    <div class="flex flex-wrap justify-center gap-6 sm:gap-8">
                        @foreach($direksi as $index => $member)
                            <div class="w-40 sm:w-48 md:w-52">
                                @include('frontend.pages.about.partials.board-member-card', ['member' => $member, 'index' => $index, 'accent' => 'emerald'])
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

            @else
            {{-- Empty state --}}
            <div class="flex flex-col items-center text-center py-24 gap-4">
                <div class="w-20 h-20 rounded-2xl bg-muted dark:bg-slate-800 flex items-center justify-center shadow-inner">
                    <svg class="w-10 h-10 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h2 class="text-xl font-bold text-foreground">Data Manajemen Belum Tersedia</h2>
                <p class="text-sm text-muted-foreground">Informasi dewan dan direksi akan segera kami tampilkan.</p>
            </div>
            @endif

        </div>
    </section>

</x-frontend-layout>
