<x-frontend-layout>
    <x-slot name="title">{{ $title ?? 'Produk & Layanan' }} - BPRS Bangka Belitung</x-slot>
    <x-slot name="meta_description">{{ $subtitle ?? 'Produk pembiayaan syariah, simpanan, dan layanan perbankan dari BPRS Bangka Belitung.' }}</x-slot>

    {{-- ═══ HIGH-END v2: HERO — Ethereal Glass ═══ --}}
    <section class="relative pt-8 sm:pt-10 md:pt-12 pb-12 sm:pb-14 md:pb-16 overflow-hidden">
        <div class="absolute inset-0 hero-gradient">
            <div class="absolute inset-0 bg-grid-pattern opacity-30"></div>
            <div class="absolute top-10 left-1/4 w-80 h-80 bg-emerald-400/20 rounded-full blur-3xl animate-float-slow"></div>
            <div class="absolute bottom-10 right-1/4 w-96 h-96 bg-emerald-400/20 rounded-full blur-3xl animate-float-slow" style="animation-delay: 3s;"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            @if(isset($title))
            <span class="eyebrow-badge mb-5 inline-flex bg-white/20 text-white border-white/20">{{ $title }}</span>
            @endif
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-white mb-4 sm:mb-6 tracking-tight leading-tight">
                {{ $title ?? 'Produk & Layanan' }}
            </h1>
            <p class="text-base sm:text-lg md:text-xl text-white/80 w-full px-4 leading-relaxed">
                {{ $subtitle ?? 'Solusi perbankan syariah yang sesuai dengan kebutuhan Anda.' }}
            </p>
        </div>
        {{-- Decorative bottom wave --}}
        <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-muted/50 dark:from-slate-900/50 to-transparent"></div>
    </section>

    {{-- ═══ HIGH-END v2: PRODUCTS GRID — Soft Structuralism + Double-Bezel ═══ --}}
    <section class="py-20 lg:py-28 bg-muted/30 dark:bg-slate-950/50 relative">
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
            <div class="absolute top-20 left-0 w-64 h-64 bg-emerald-50 rounded-full blur-[100px]"></div>
            <div class="absolute bottom-20 right-0 w-64 h-64 bg-emerald-50 rounded-full blur-[100px]"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Category Filter Pills --}}
            @if(isset($categories) && $categories->count() > 0)
            <div class="flex flex-wrap justify-center gap-2 sm:gap-3 mb-12 lg:mb-16 reveal-up" x-intersect="$el.classList.add('is-visible')">
                <a href="{{ request()->url() }}"
                   class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-500 ease-[cubic-bezier(0.32,0.72,0,1)] {{ !request('category') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/20' : 'bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm text-foreground hover:text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 border border-border' }}">
                    Semua
                </a>
                @foreach($categories as $category)
                <a href="{{ request()->url() . '?category=' . $category->slug }}"
                   class="px-5 py-2.5 rounded-full text-sm font-semibold transition-all duration-500 ease-[cubic-bezier(0.32,0.72,0,1)] {{ request('category') == $category->slug ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/20' : 'bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm text-foreground hover:text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 border border-border' }}">
                    {{ $category->name }}
                </a>
                @endforeach
            </div>
            @endif

            @if($products->count() > 0)
            {{-- Asymmetrical Bento Grid — HIGH-END v2 --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8"
                 x-intersect="$el.querySelectorAll('.product-card').forEach((el, i) => { setTimeout(() => el.classList.add('is-visible'), i * 100) })">
                @foreach($products as $index => $product)
                <div class="product-card reveal-up h-full flex">
                    {{-- Double-Bezel Card --}}
                    <a href="{{ route('products.show', $product->slug) }}" class="block group no-underline w-full h-full">
                        <div class="double-bezel h-full flex">
                            <div class="double-bezel-inner w-full flex flex-col">
                                {{-- Image Area --}}
                                <div class="relative overflow-hidden flex-shrink-0" style="border-radius: var(--radius-double-inner) var(--radius-double-inner) 0 0;">
                                    <div class="aspect-[4/3] bg-muted">
                                        @if($product->image)
                                        <img src="{{ \App\Helpers\StorageHelper::url($product->image) }}"
                                             alt="{{ $product->name }}"
                                             class="w-full h-full object-cover transition-all duration-700 ease-[cubic-bezier(0.32,0.72,0,1)] group-hover:scale-105"
                                             width="800" height="600"
                                             loading="{{ $index < 3 ? 'eager' : 'lazy' }}"
                                             decoding="async">
                                        @else
                                        <div class="w-full h-full bg-gradient-to-br from-emerald-50 dark:from-emerald-900/30 to-emerald-100/50 dark:to-emerald-900/10 flex items-center justify-center">
                                            <svg class="w-16 h-16 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                            </svg>
                                        </div>
                                        @endif
                                    </div>

                                    {{-- Type Badge --}}
                                    @if($product->type)
                                    <div class="absolute top-3 left-3 z-10">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold bg-white/90 dark:bg-slate-900/90 backdrop-blur-sm text-emerald-700 dark:text-emerald-400 border border-white/50 dark:border-slate-700/50 shadow-sm">
                                            @switch($product->type)
                                                @case('simpanan_syariah')
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                                    Simpanan @break
                                                @case('pembiayaan_syariah')
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                    Pembiayaan @break
                                                @case('deposito_syariah')
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                    Deposito @break
                                                @default {{ ucwords(str_replace('_', ' ', $product->type)) }}
                                            @endswitch
                                        </span>
                                    </div>
                                    @endif

                                    {{-- Hover overlay --}}
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                </div>

                                {{-- Content Area --}}
                                <div class="p-5 sm:p-6 flex flex-col flex-1">
                                    <h3 class="text-lg sm:text-xl font-bold text-foreground group-hover:text-emerald-600 transition-colors duration-300 leading-tight mb-2">
                                        {{ $product->name }}
                                    </h3>

                                    @if($product->short_description)
                                    <p class="text-sm text-secondary dark:text-slate-400 leading-relaxed line-clamp-2 mb-4">
                                        {{ $product->short_description }}
                                    </p>
                                    @endif

                                    {{-- Button-in-Button CTA --}}
                                    <div class="mt-auto pt-4 flex items-center gap-1.5 text-emerald-600 font-semibold text-sm group-hover:gap-2.5 transition-all duration-300">
                                        <span>Selengkapnya</span>                                            <span class="flex items-center justify-center w-6 h-6 rounded-full bg-emerald-100 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400 transition-all duration-500 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 group-hover:scale-105">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            @else
            {{-- Empty State --}}
            <div class="text-center py-20 reveal-up" x-intersect="$el.classList.add('is-visible')">
                <div class="double-bezel inline-flex">
                    <div class="double-bezel-inner px-10 py-8">
                        <div class="w-16 h-16 rounded-full bg-muted flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-foreground mb-2">Belum Ada Produk</h3>
                        <p class="text-sm text-secondary">Produk untuk kategori ini belum tersedia. Silakan cek kategori lain.</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>

    {{-- ═══ HIGH-END v2: CTA — Ethereal Glass ═══ --}}
    <section class="py-24 lg:py-32 bg-white dark:bg-slate-900 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-emerald-50/30 to-transparent pointer-events-none"></div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center reveal-up" x-intersect="$el.classList.add('is-visible')">
            <span class="eyebrow-badge mb-5 inline-flex">Butuh Bantuan?</span>
            <h2 class="text-4xl sm:text-5xl font-bold text-foreground mb-4 sm:mb-6 tracking-tight leading-tight">
                Konsultasi <span class="text-emerald-600">Gratis</span>
            </h2>
            <p class="text-lg text-secondary mb-10 leading-relaxed mx-auto">
                Konsultasikan kebutuhan perbankan syariah Anda dengan tim marketing kami. Kami siap membantu.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('about.offices') }}"
                   class="group inline-flex items-center justify-center gap-3 px-8 py-4 rounded-full bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-bold shadow-xl shadow-emerald-500/20 hover:shadow-emerald-500/30 transition-all duration-500 ease-[cubic-bezier(0.32,0.72,0,1)] active:scale-[0.98]">
                    <span>Kunjungi Kantor</span>
                    <span class="flex items-center justify-center w-7 h-7 rounded-full bg-white/20 text-white transition-all duration-500 group-hover:translate-x-0.5 group-hover:-translate-y-0.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </span>
                </a>
                <a href="{{ route('contact') }}"
                   class="group inline-flex items-center justify-center gap-3 px-8 py-4 rounded-full border-2 border-emerald-200 text-emerald-700 font-bold hover:bg-emerald-50 hover:border-emerald-300 transition-all duration-500 ease-[cubic-bezier(0.32,0.72,0,1)] active:scale-[0.98]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span>Hubungi Kami</span>
                </a>
            </div>
        </div>
    </section>
</x-frontend-layout>
