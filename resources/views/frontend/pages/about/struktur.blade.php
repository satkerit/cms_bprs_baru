<x-frontend-layout>
    <x-slot name="title">Struktur Organisasi - BPRS Bangka Belitung</x-slot>

    @php
        $companyInfo = \App\Models\CompanyInfo::getInfo();
    @endphp

    {{-- ═══ HIGH-END v2: HERO — Ethereal Glass ═══ --}}
    <section class="relative pt-8 sm:pt-10 md:pt-12 pb-16 sm:pb-20 md:pb-28 overflow-hidden">
        <div class="absolute inset-0 hero-gradient">
            <div class="absolute inset-0 bg-grid-pattern opacity-30"></div>
            <div class="absolute top-10 left-1/4 w-80 h-80 bg-emerald-400/20 rounded-full blur-3xl animate-float-slow"></div>
            <div class="absolute bottom-10 right-1/4 w-96 h-96 bg-emerald-400/20 rounded-full blur-3xl animate-float-slow" style="animation-delay: 3s;"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center reveal-up">
            <span class="eyebrow-badge mb-5 inline-flex bg-white/20 text-white border-white/20">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                Tentang Kami
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-white mb-4 sm:mb-6 tracking-tight leading-tight">Struktur Organisasi</h1>
            <p class="text-base sm:text-lg md:text-xl text-white/80 w-full px-4 leading-relaxed">
                Struktur organisasi {{ $companyInfo?->name ?? 'BPRS Bangka Belitung' }}
            </p>
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-muted/30 to-transparent"></div>
    </section>

    {{-- ═══ STRUCTURE IMAGE — Double-Bezel ═══ --}}
    <section class="py-16 lg:py-24 -mt-6 sm:-mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="reveal-up" x-intersect="$el.classList.add('is-visible')">
                @if($companyInfo?->organization_structure)
                <div class="double-bezel">
                    <div class="double-bezel-inner p-4 sm:p-6 lg:p-8">
                        {{-- Image with zoom --}}
                        <div class="relative rounded-[calc(2rem-0.75rem)] overflow-hidden bg-muted/50 dark:bg-slate-800/50">
                            <img
                                src="{{ \App\Helpers\StorageHelper::url($companyInfo->organization_structure) }}"
                                alt="Struktur Organisasi {{ $companyInfo->name ?? 'BPRS Bangka Belitung' }}"
                                class="w-full h-auto object-contain transition-all duration-700 ease-[cubic-bezier(0.32,0.72,0,1)] hover:scale-105"
                                loading="lazy"
                                decoding="async"
                            >
                        </div>

                        {{-- Button-in-Button CTA --}}
                        <div class="mt-6 sm:mt-8 flex justify-center">
                            <a href="{{ \App\Helpers\StorageHelper::url($companyInfo->organization_structure) }}"
                               target="_blank"
                               class="group inline-flex items-center gap-3 px-7 py-3.5 rounded-full bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-bold shadow-xl shadow-emerald-500/20 hover:shadow-emerald-500/30 transition-all duration-500 ease-[cubic-bezier(0.32,0.72,0,1)] active:scale-[0.98]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                                <span>Lihat Ukuran Penuh</span>
                                <span class="flex items-center justify-center w-7 h-7 rounded-full bg-white/20 text-white transition-all duration-500 group-hover:translate-x-0.5 group-hover:-translate-y-0.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                @else
                {{-- Empty State --}}
                <div class="double-bezel">
                    <div class="double-bezel-inner p-10 sm:p-16 text-center">
                        <div class="w-20 h-20 rounded-full bg-muted flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/></svg>
                        </div>
                        <h3 class="text-lg font-bold text-foreground mb-2">Struktur Organisasi</h3>
                        <p class="text-sm text-secondary dark:text-slate-400 w-full">Gambar struktur organisasi sedang dalam proses pembaruan. Silakan hubungi kami untuk informasi lebih lanjut.</p>
                        <div class="mt-8">
                            <a href="{{ route('contact') }}"
                               class="group inline-flex items-center gap-3 px-7 py-3.5 rounded-full bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-bold shadow-xl shadow-emerald-500/20 hover:shadow-emerald-500/30 transition-all duration-500 ease-[cubic-bezier(0.32,0.72,0,1)] active:scale-[0.98]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <span>Hubungi Kami</span>
                            </a>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            {{-- Additional Info --}}
            <div class="mt-8 sm:mt-10 text-center reveal-up" x-intersect="$el.classList.add('is-visible')">
                <p class="text-secondary text-sm sm:text-base">
                    Untuk informasi lebih detail mengenai struktur organisasi, silakan
                    <a href="{{ route('contact') }}" class="text-emerald-600 hover:text-emerald-700 font-semibold transition-colors">hubungi kami</a>.
                </p>
            </div>
        </div>
    </section>
</x-frontend-layout>
