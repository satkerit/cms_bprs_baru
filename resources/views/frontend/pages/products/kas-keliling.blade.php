<x-frontend-layout>
    <x-slot name="title">Kas Keliling - {{ $product->name ?? 'BPRS Bangka Belitung' }}</x-slot>

    {{-- ═══ HIGH-END v2: HERO — Ethereal Glass ═══ --}}
    <section class="relative pt-8 sm:pt-10 md:pt-12 pb-16 sm:pb-20 md:pb-28 overflow-hidden">
        <div class="absolute inset-0 hero-gradient">
            <div class="absolute inset-0 bg-grid-pattern opacity-30"></div>
            <div class="absolute top-10 left-1/4 w-80 h-80 bg-emerald-400/20 rounded-full blur-3xl animate-float-slow"></div>
            <div class="absolute bottom-10 right-1/4 w-96 h-96 bg-amber-400/20 rounded-full blur-3xl animate-float-slow" style="animation-delay: 2.5s;"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="eyebrow-badge mb-5 inline-flex bg-white/20 text-white border-white/20">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                Layanan Jemput Tabungan
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-white mb-4 sm:mb-6 tracking-tight leading-tight">Layanan Kas Keliling</h1>
            <p class="text-base sm:text-lg md:text-xl text-white/80 w-full px-4 leading-relaxed">
                Layanan jemput tabungan dan pembiayaan syariah yang mendekatkan Anda dengan transaksi perbankan tanpa harus datang ke kantor.
            </p>
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-muted/30 dark:from-slate-900/30 to-transparent"></div>
    </section>

    {{-- ═══ SCHEDULE SECTION — Double-Bezel Cards ═══ --}}
    <section class="py-16 lg:py-24 -mt-6 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($schedules->count() > 0)
                {{-- Section Header --}}
                <div class="text-center mb-10 lg:mb-14 reveal-up" x-intersect="$el.classList.add('is-visible')">
                    <span class="eyebrow-badge inline-flex mb-4">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Jadwal Layanan
                    </span>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-foreground mb-3 tracking-tight">Jadwal Kas Keliling</h2>
                    <p class="text-sm sm:text-base text-secondary mx-auto">Berikut adalah jadwal dan lokasi layanan kas keliling BPRS Bangka Belitung.</p>
                </div>

                {{-- Schedule Cards Grid — Double-Bezel --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8"
                     x-intersect="$el.querySelectorAll('.schedule-card').forEach((el, i) => { setTimeout(() => el.classList.add('is-visible'), i * 100) })">
                    @foreach($schedules as $index => $schedule)
                    <div class="schedule-card reveal-up" style="transition-delay: {{ $index * 80 }}ms">
                        <div class="double-bezel h-full">
                            <div class="double-bezel-inner p-5 sm:p-6 h-full flex flex-col">
                                {{-- Header: Icon + Location --}}
                                <div class="flex items-start gap-3 sm:gap-4 mb-4">
                                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl bg-gradient-to-br from-emerald-50 dark:from-emerald-900/30 to-emerald-100 dark:to-emerald-900/10 flex items-center justify-center text-emerald-600 dark:text-emerald-400 shrink-0 shadow-sm dark:shadow-none">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm sm:text-base font-bold text-foreground leading-snug">{{ $schedule->location }}</h3>
                                    </div>
                                </div>

                                {{-- Details: Date, Day & Time --}}
                                <div class="space-y-2.5 text-xs sm:text-sm mb-4 flex-1">
                                    <div class="flex items-center gap-2.5">
                                        <span class="flex items-center justify-center w-7 h-7 rounded-lg bg-emerald-50 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400 shrink-0">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </span>
                                        <div class="min-w-0 leading-tight">
                                            <span class="block font-semibold text-foreground">{{ $schedule->day_name }}</span>
                                            <span class="block text-secondary dark:text-slate-400">{{ $schedule->schedule_date?->locale('id')->translatedFormat('d F Y') }}</span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2.5">
                                        <span class="flex items-center justify-center w-7 h-7 rounded-lg bg-amber-50 dark:bg-amber-900/50 text-amber-600 dark:text-amber-400 shrink-0">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                        </span>
                                        <span class="text-secondary dark:text-slate-400">{{ $schedule->start_time ? \Carbon\Carbon::parse($schedule->start_time)->format('H:i') : '-' }} — {{ $schedule->end_time ? \Carbon\Carbon::parse($schedule->end_time)->format('H:i') : '-' }} WIB</span>
                                    </div>

                                    {{-- Layanan / Fasilitas --}}
                                    @if(count($schedule->services_list) > 0)
                                    <div class="pt-2">
                                        <div class="flex flex-wrap gap-1.5">
                                            @foreach($schedule->services_list as $service)
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-50 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 text-[10px] sm:text-xs font-medium border border-emerald-100 dark:border-emerald-900/60">
                                                <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                {{ $service }}
                                            </span>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                {{-- PIC & Catatan --}}
                                @php
                                    $picName = $schedule->pic_name ?? $schedule->kasKeliling?->contact_person;
                                    $picPhone = $schedule->pic_phone ?? $schedule->kasKeliling?->contact_phone;
                                @endphp
                                @if($picName || $picPhone || $schedule->notes)
                                <div class="pt-3 mt-auto border-t border-border/50 dark:border-slate-700/50 space-y-3">
                                    @if($picName || $picPhone)
                                    <div class="flex items-center gap-2.5">
                                        <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-sky-50 dark:bg-sky-900/40 text-sky-600 dark:text-sky-400 shrink-0">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </span>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-[10px] sm:text-xs font-semibold text-secondary dark:text-slate-400 uppercase tracking-wide">PIC / Petugas</p>
                                            <p class="font-semibold text-foreground text-xs sm:text-sm leading-snug">{{ $picName }}</p>
                                        </div>
                                        @if($picPhone)
                                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $picPhone) }}"
                                           class="shrink-0 inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-lg bg-emerald-50 dark:bg-emerald-900/40 text-emerald-700 dark:text-emerald-300 text-xs font-semibold border border-emerald-100 dark:border-emerald-900/60 hover:bg-emerald-100 dark:hover:bg-emerald-900/60 transition-colors"
                                           title="Hubungi {{ $picName }}">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h.5a1.5 1.5 0 011.4 1l.9 2.7a1.5 1.5 0 01-.5 1.7l-1 .8a12.05 12.05 0 005.4 5.4l.8-1a1.5 1.5 0 011.7-.5l2.7.9a1.5 1.5 0 011 1.4V19a2 2 0 01-2 2h-1C8.7 21 3 15.3 3 8V5z"/>
                                            </svg>
                                            <span class="hidden sm:inline">{{ $picPhone }}</span>
                                        </a>
                                        @endif
                                    </div>
                                    @endif

                                    @if($schedule->notes)
                                    <div class="flex items-start gap-2">
                                        <svg class="w-3.5 h-3.5 text-secondary mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <p class="text-xs sm:text-sm text-secondary dark:text-slate-400 italic">{{ $schedule->notes }}</p>
                                    </div>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                {{-- Empty State — Double-Bezel --}}
                <div class="reveal-up" x-intersect="$el.classList.add('is-visible')">
                    <div class="double-bezel">
                        <div class="double-bezel-inner py-16 sm:py-20 px-6 text-center">
                            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-muted dark:bg-slate-800 flex items-center justify-center mx-auto mb-4 sm:mb-6">
                                <svg class="w-10 h-10 sm:w-12 sm:h-12 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg sm:text-xl font-bold text-foreground mb-2">Belum Ada Jadwal</h3>
                            <p class="text-sm text-secondary dark:text-slate-400 w-full mb-6">Jadwal kas keliling belum tersedia untuk saat ini. Silakan hubungi kami untuk informasi lebih lanjut.</p>
                            <a href="{{ route('contact') }}"
                               class="group inline-flex items-center gap-2 px-6 py-3 rounded-full bg-emerald-600 text-white font-bold shadow-lg shadow-emerald-500/15 hover:bg-emerald-700 transition-all duration-500 ease-[cubic-bezier(0.32,0.72,0,1)] active:scale-[0.98] text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <span>Hubungi Kami</span>
                                <span class="flex items-center justify-center w-5 h-5 rounded-full bg-white/20 text-white transition-all duration-500 group-hover:translate-x-0.5 group-hover:-translate-y-0.5">
                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- ═══ PRODUCT INFO SECTION — Double-Bezel ═══ --}}
    @if($product)
    <section class="pb-20 lg:pb-28 relative">
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
            <div class="absolute top-20 left-0 w-72 h-72 bg-emerald-50/50 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-20 right-0 w-72 h-72 bg-amber-50/30 rounded-full blur-[120px]"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-4xl mx-auto reveal-up" x-intersect="$el.classList.add('is-visible')">
                {{-- Section Header --}}
                <div class="text-center mb-10 lg:mb-12">
                    <span class="eyebrow-badge inline-flex mb-4">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Informasi Produk
                    </span>
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-foreground mb-3 tracking-tight">Informasi Kas Keliling</h2>
                </div>

                {{-- Info Card --}}
                <div class="double-bezel">
                    <div class="double-bezel-inner p-6 sm:p-8 md:p-10">
                        @if($product->description)
                        <div class="prose prose-sm sm:prose-base lg:prose-lg prose-emerald max-w-none text-foreground/80 leading-relaxed">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                        @else
                        <div class="text-center py-6">
                            <div class="w-14 h-14 rounded-full bg-muted dark:bg-slate-800 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-7 h-7 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <p class="text-sm text-secondary dark:text-slate-400">Informasi produk kas keliling belum tersedia.</p>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Brochure Download — Button-in-Button --}}
                @if($product->brochure)
                <div class="text-center mt-8 sm:mt-10 reveal-up" x-intersect="$el.classList.add('is-visible')">
                    <a href="{{ \App\Helpers\StorageHelper::url($product->brochure) }}"
                       target="_blank" rel="noopener"
                       class="group inline-flex items-center gap-3 px-8 py-4 rounded-full bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-bold shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/30 transition-all duration-500 ease-[cubic-bezier(0.32,0.72,0,1)] active:scale-[0.98] text-sm sm:text-base">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        <span>Download Brosur Kas Keliling</span>
                        <span class="flex items-center justify-center w-7 h-7 rounded-full bg-white/20 text-white transition-all duration-500 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 group-hover:scale-105">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        </span>
                    </a>
                </div>
                @endif

                {{-- CTA --}}
                <div class="text-center mt-10 sm:mt-12 reveal-up" x-intersect="$el.classList.add('is-visible')">
                    <div class="double-bezel bg-gradient-to-br from-emerald-600 to-emerald-700 text-white border-none">
                        <div class="double-bezel-inner p-6 sm:p-8 md:p-10 text-center relative overflow-hidden">
                            <div class="absolute inset-0 bg-grid-pattern"></div>
                            <div class="relative">
                                <div class="w-14 h-14 rounded-full bg-white/10 backdrop-blur-sm flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <h3 class="text-xl sm:text-2xl font-bold mb-2">Butuh Informasi Lebih?</h3>
                                <p class="text-sm sm:text-base text-white/80 mb-6 w-full">Hubungi tim marketing kami untuk info jadwal dan layanan kas keliling</p>
                                <a href="{{ route('contact') }}"
                                   class="group inline-flex items-center gap-2.5 px-6 py-3 rounded-full bg-white/20 backdrop-blur-sm text-white font-bold border border-white/30 hover:bg-white/30 transition-all duration-500 ease-[cubic-bezier(0.32,0.72,0,1)] active:scale-[0.97] shadow-lg text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    <span>Hubungi Kami</span>
                                    <span class="flex items-center justify-center w-5 h-5 rounded-full bg-white/20 text-white transition-all duration-500 group-hover:translate-x-0.5 group-hover:-translate-y-0.5">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
</x-frontend-layout>
