<x-frontend-layout>
    <x-slot name="title">Manajemen - BPRS Bangka Belitung</x-slot>

    @php
        $companyInfo = \App\Models\CompanyInfo::getInfo();
        $hasAny = $komisaris->isNotEmpty() || $direksi->isNotEmpty() || $pengawasSyariah->isNotEmpty();
    @endphp

    {{-- ═══ HERO — Ethereal Glass ═══ --}}
    <section class="relative pt-6 sm:pt-8 md:pt-10 pb-16 sm:pb-20 md:pb-24 overflow-hidden">
        <div class="absolute inset-0 hero-gradient">
            <div class="absolute inset-0 bg-grid-pattern opacity-30"></div>
            <div class="absolute top-10 left-1/4 w-80 h-80 bg-emerald-400/20 rounded-full blur-3xl animate-float-slow"></div>
            <div class="absolute bottom-10 right-1/4 w-96 h-96 bg-emerald-400/20 rounded-full blur-3xl animate-float-slow" style="animation-delay: 3s;"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center reveal-up" x-intersect="$el.classList.add('is-visible')">
            <span class="eyebrow-badge mb-5 inline-flex bg-white/20 text-white border-white/25">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Tentang Kami
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-white mb-4 sm:mb-6 tracking-tight leading-tight">Manajemen</h1>
            <p class="text-base sm:text-lg md:text-xl text-white/85 w-full px-4 leading-relaxed">
                Dewan Komisaris, Dewan Direksi &amp; Dewan Pengawas Syariah {{ $companyInfo?->name ?? 'BPRS Bangka Belitung' }}
            </p>
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-muted/30 to-transparent"></div>
    </section>

    {{-- ═══ ORG STRUCTURE ═══ --}}
    <section class="py-16 lg:py-24 -mt-4">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="reveal-up" x-intersect="$el.classList.add('is-visible')">

                @if($hasAny)

                {{-- ── RUPS / Pemegang Saham (decorative top node) ── --}}
                <div class="hidden md:flex flex-col items-center mb-0">
                    <div class="flex items-center gap-3 px-6 py-3.5 rounded-2xl bg-card dark:bg-slate-800/90 border border-border dark:border-slate-700 shadow-xl shadow-emerald-500/5 hover:shadow-emerald-500/15 hover:-translate-y-0.5 transition-all duration-500">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gold-400 to-gold-600 text-white flex items-center justify-center shadow-md shadow-gold-500/30">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-6h6v6M12 10h.01"/></svg>
                        </div>
                        <div class="text-left">
                            <p class="text-sm font-bold text-foreground dark:text-slate-100 leading-tight">{{ $companyInfo?->name ?? 'BPRS Bangka Belitung' }}</p>
                            <p class="text-[11px] font-medium text-muted-foreground uppercase tracking-wider">Rapat Umum Pemegang Saham</p>
                        </div>
                    </div>
                    <div class="org-connector-v"></div>
                </div>

                {{-- ── Middle level: Komisaris | DPS ── --}}
                <div class="relative hidden md:block" aria-hidden="true">
                    <div class="org-connector-h absolute top-0 left-[25%] right-[25%]"></div>
                </div>

                <div class="relative grid grid-cols-1 md:grid-cols-2 gap-14 md:gap-8 lg:gap-12">
                    {{-- Spine kontinu: dari cabang menembus celah antar kolom ke bawah --}}
                    <div class="org-spine absolute top-0 bottom-0 left-1/2 -translate-x-1/2 hidden md:block" aria-hidden="true"></div>

                    {{-- ══ DEWAN KOMISARIS ══ --}}
                    <div class="flex flex-col items-center text-center">
                        <div class="org-connector-v hidden md:block"></div>

                        <div class="relative">
                            <div class="absolute -inset-2 bg-emerald-500/20 blur-xl rounded-2xl opacity-70"></div>
                            <div class="relative w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-500 to-emerald-700 text-white flex items-center justify-center shadow-lg shadow-emerald-500/25 rotate-3 hover:rotate-0 transition-transform duration-500">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                        </div>
                        <h2 class="mt-4 text-xl sm:text-2xl font-bold text-foreground dark:text-slate-100">Dewan Komisaris</h2>
                        <p class="mt-1 text-sm text-muted-foreground">Fungsi pengawasan &amp; pemberian nasihat kepada Direksi</p>

                        <div class="flex flex-wrap justify-center gap-5 sm:gap-6 mt-8 w-full">
                            @forelse($komisaris as $index => $member)
                                @include('frontend.pages.about.partials.board-member-card', ['member' => $member, 'index' => $index])
                            @empty
                                <p class="text-sm text-muted-foreground py-6">Data Dewan Komisaris belum tersedia.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- ══ DEWAN PENGAWAS SYARIAH ══ --}}
                    <div class="flex flex-col items-center text-center">
                        <div class="org-connector-v hidden md:block"></div>

                        <div class="relative">
                            <div class="absolute -inset-2 bg-gold-400/20 blur-xl rounded-2xl opacity-70"></div>
                            <div class="relative w-16 h-16 rounded-2xl bg-gradient-to-br from-gold-400 to-gold-600 text-white flex items-center justify-center shadow-lg shadow-gold-500/25 rotate-3 hover:rotate-0 transition-transform duration-500">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                        </div>
                        <h2 class="mt-4 text-xl sm:text-2xl font-bold text-foreground dark:text-slate-100">Dewan Pengawas Syariah</h2>
                        <p class="mt-1 text-sm text-muted-foreground">Pengawasan kepatuhan terhadap prinsip syariah</p>

                        <div class="flex flex-wrap justify-center gap-5 sm:gap-6 mt-8 w-full">
                            @forelse($pengawasSyariah as $index => $member)
                                @include('frontend.pages.about.partials.board-member-card', ['member' => $member, 'index' => $index])
                            @empty
                                <p class="text-sm text-muted-foreground py-6">Data Dewan Pengawas Syariah belum tersedia.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- ══ DEWAN DIREKSI ══ --}}
                <div class="flex flex-col items-center text-center">
                    <div class="org-connector-v hidden md:block"></div>

                    <div class="relative">
                        <div class="absolute -inset-2 bg-emerald-500/20 blur-xl rounded-2xl opacity-70"></div>
                        <div class="relative w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-600 to-emerald-800 text-white flex items-center justify-center shadow-lg shadow-emerald-600/25 rotate-3 hover:rotate-0 transition-transform duration-500">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                    </div>
                    <h2 class="mt-4 text-xl sm:text-2xl font-bold text-foreground dark:text-slate-100">Dewan Direksi</h2>
                    <p class="mt-1 text-sm text-muted-foreground">Pengelolaan operasional &amp; pengembangan bisnis</p>

                    <div class="flex flex-wrap justify-center gap-5 sm:gap-6 mt-8 w-full">
                        @forelse($direksi as $index => $member)
                            @include('frontend.pages.about.partials.board-member-card', ['member' => $member, 'index' => $index])
                        @empty
                            <p class="text-sm text-muted-foreground py-6">Data Dewan Direksi belum tersedia.</p>
                        @endforelse
                    </div>
                </div>

                @else
                {{-- Empty state --}}
                <div class="max-w-xl mx-auto text-center py-16">
                    <div class="w-20 h-20 rounded-full bg-muted dark:bg-slate-800 flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <h2 class="text-xl font-bold text-foreground mb-2">Data Manajemen Belum Tersedia</h2>
                    <p class="text-sm text-muted-foreground">Informasi dewan dan direksi akan segera kami tampilkan.</p>
                </div>
                @endif

            </div>

            {{-- CTA — Hubungi kami --}}
            <div class="mt-14 sm:mt-16 text-center reveal-up" x-intersect="$el.classList.add('is-visible')">
                <p class="text-secondary dark:text-slate-400 text-sm sm:text-base">
                    Ingin mengetahui lebih lanjut tentang perusahaan kami? Silakan
                    <a href="{{ route('contact') }}" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 font-semibold transition-colors">hubungi kami</a>.
                </p>
            </div>
        </div>
    </section>

    {{-- ═══ MODAL PROFIL ═══ --}}
    <div
        x-data="{ open: false, member: null }"
        @open-modal.window="open = true; member = $event.detail.member; document.body.style.overflow = 'hidden'"
        x-init="$watch('open', value => { if(!value) document.body.style.overflow = '' })"
        x-show="open"
        x-cloak
        class="relative z-50"
        aria-labelledby="modal-title"
        role="dialog"
        aria-modal="true"
    >
        <div
            x-show="open"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/75 backdrop-blur-sm transition-opacity"
            @click="open = false"
        ></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div
                    x-show="open"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="relative transform rounded-2xl bg-card text-left transition-all sm:my-8 sm:w-full sm:max-w-3xl border border-border max-h-[90vh] overflow-y-auto"
                    @click.stop
                >
                    <div class="absolute right-3 top-3 sm:right-4 sm:top-4 z-10">
                        <button
                            @click="open = false"
                            type="button"
                            class="rounded-full bg-card/80 p-2 text-muted-foreground hover:bg-muted focus:outline-none transition-all duration-200 touch-manipulation active:scale-95"
                        >
                            <span class="sr-only">Tutup</span>
                            <svg class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="bg-card px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="flex flex-col sm:flex-row gap-6 sm:gap-8">
                            <div class="shrink-0 mx-auto sm:mx-0">
                                <template x-if="member && member.photo">
                                    <img :src="member.photo_url || '/storage/' + member.photo" :alt="member.name" class="w-40 h-52 sm:w-48 sm:h-64 object-cover object-top rounded-xl">
                                </template>
                                <template x-if="!member || !member.photo">
                                    <div class="w-40 h-52 sm:w-48 sm:h-64 bg-muted dark:bg-slate-800 rounded-xl flex items-center justify-center">
                                        <svg class="w-12 h-12 sm:w-16 sm:h-16 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                </template>
                            </div>

                            <div class="flex-1 mt-2 sm:mt-0 text-left">
                                <h3 class="text-lg sm:text-2xl font-bold text-foreground leading-tight" x-text="member?.name"></h3>
                                <p class="text-emerald-600 dark:text-emerald-400 font-semibold text-sm sm:text-lg mb-4 sm:mb-6" x-text="member?.position"></p>

                                <div class="prose prose-sm prose-accent max-w-none text-muted-foreground">
                                    <template x-if="member && member.biography">
                                        <p x-html="member.biography.replace(/\n/g, '<br>')" class="whitespace-pre-line leading-relaxed text-xs sm:text-base"></p>
                                    </template>
                                </div>

                                <template x-if="member && member.education && member.education.length > 0">
                                    <div class="mt-6 sm:mt-8 bg-muted/50 dark:bg-slate-800/50 rounded-xl p-4 sm:p-5 border border-border dark:border-slate-700">
                                        <h4 class="font-bold text-foreground mb-2 sm:mb-3 flex items-center text-xs sm:text-base">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1.5 sm:mr-2 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/></svg>
                                            Riwayat Pendidikan
                                        </h4>
                                        <ul class="space-y-1.5 sm:space-y-2">
                                            <template x-for="edu in member.education" :key="edu">
                                                <li class="flex items-start text-xs sm:text-sm text-muted-foreground">
                                                    <span class="mr-2 mt-1.5 w-1.5 h-1.5 bg-emerald-600 dark:bg-emerald-400 rounded-full shrink-0"></span>
                                                    <span x-text="edu"></span>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                </template>

                                <template x-if="member && member.experience && member.experience.length > 0">
                                    <div class="mt-3 sm:mt-4 bg-muted/50 dark:bg-slate-800/50 rounded-xl p-4 sm:p-5 border border-border dark:border-slate-700">
                                        <h4 class="font-bold text-foreground mb-2 sm:mb-3 flex items-center text-xs sm:text-base">
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1.5 sm:mr-2 text-emerald-600 dark:text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                            Pengalaman Kerja
                                        </h4>
                                        <ul class="space-y-1.5 sm:space-y-2">
                                            <template x-for="exp in member.experience" :key="exp">
                                                <li class="flex items-start text-xs sm:text-sm text-muted-foreground">
                                                    <span class="mr-2 mt-1.5 w-1.5 h-1.5 bg-emerald-600 dark:bg-emerald-400 rounded-full shrink-0"></span>
                                                    <span x-text="exp"></span>
                                                </li>
                                            </template>
                                        </ul>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="bg-muted/50 dark:bg-slate-800/50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 border-t border-border dark:border-slate-700 rounded-b-xl">
                        <button
                            type="button"
                            class="inline-flex w-full justify-center min-h-[48px] rounded-xl bg-card px-3 py-2 text-xs font-semibold text-foreground ring-1 ring-inset ring-gray-300 hover:bg-muted/50 sm:mt-0 sm:w-auto transition-colors touch-manipulation active:scale-95"
                            @click="open = false"
                        >
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-frontend-layout>
