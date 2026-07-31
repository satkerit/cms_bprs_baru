<x-frontend-layout>
    <x-slot name="title">{{ $product->name }} - Produk BPRS Bangka Belitung</x-slot>

    @push('meta')
    <meta property="og:title" content="{{ $product->name }}" />
    <meta property="og:description" content="{{ $product->short_description ?? 'Produk BPRS Bangka Belitung' }}" />
    @if($product->image)
    <meta property="og:image" content="{{ \App\Helpers\StorageHelper::url($product->image) }}" />
    @endif
    @endpush

    {{-- ═══ HIGH-END v2: HERO — Ethereal Glass ═══ --}}
    <section class="relative pt-8 sm:pt-10 md:pt-12 pb-12 sm:pb-16 overflow-hidden">
        <div class="absolute inset-0 hero-gradient">
            <div class="absolute inset-0 bg-grid-pattern opacity-30"></div>
            <div class="absolute top-10 left-1/4 w-80 h-80 bg-emerald-400/20 rounded-full blur-3xl animate-float-slow"></div>
            <div class="absolute bottom-10 right-1/4 w-96 h-96 bg-emerald-400/20 rounded-full blur-3xl animate-float-slow" style="animation-delay: 3s;"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Back link --}}
            <a href="{{ $product->type ? route('products.' . str_replace('_', '-', $product->type)) : route('products.simpanan-syariah') }}"
               class="group inline-flex items-center gap-2 text-white/70 hover:text-white mb-6 transition-all duration-300 text-sm font-medium">
                <svg class="w-4 h-4 transition-transform duration-300 group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Produk
            </a>

            <div class="reveal-up">
                @if($product->type)
                <span class="eyebrow-badge mb-4 inline-flex gap-1.5 bg-white/20 text-white border-white/20">
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
                @endif
                <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-white mb-3 tracking-tight leading-tight">{{ $product->name }}</h1>
                @if($product->short_description)
                <p class="text-base sm:text-lg text-white/80 leading-relaxed">{{ $product->short_description }}</p>
                @endif
            </div>
        </div>
        {{-- Decorative bottom wave --}}
        <div class="absolute bottom-0 left-0 right-0 h-12 bg-gradient-to-t from-muted/50 dark:from-slate-900/50 to-transparent"></div>
    </section>

    {{-- ═══ HIGH-END v2: MAIN CONTENT — Soft Structuralism ═══ --}}
    <section class="py-12 lg:py-20 bg-muted/30 dark:bg-slate-950/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Image Gallery with Double-Bezel --}}
            @if($product->image)
            <div class="mb-12 lg:mb-16 reveal-up" x-intersect="$el.classList.add('is-visible')" x-data="productGallery()">
                <div class="double-bezel">
                    <div class="double-bezel-inner">
                        {{-- Main Image --}}
                        <div class="relative group cursor-zoom-in"
                             @click="openLightbox()"
                             @mousemove="handleMouseMove($event)"
                             @mouseleave="zoomActive = false"
                             @mouseenter="zoomActive = true">
                            {{-- Skeleton --}}
                            <div x-show="!loaded" class="aspect-[4/3] product-image-skeleton"></div>
                            <div :class="{ 'hidden': !loaded }" class="overflow-hidden" style="border-radius: var(--radius-double-inner);">
                                <img x-ref="mainImage"
                                     src="{{ \App\Helpers\StorageHelper::url($product->image) }}"
                                     alt="{{ $product->image_alt ?? $product->name }}"
                                     class="w-full aspect-[4/3] object-cover transition-transform duration-300"
                                     width="800" height="600"
                                     loading="eager"
                                     @load="onImageLoad()"
                                     :style="zoomActive ? `transform-origin: ${zoomX}% ${zoomY}%; transform: scale(1.8)` : ''">
                            </div>

                            {{-- Overlay controls --}}
                            <div class="absolute bottom-4 right-4 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                                <span class="flex items-center gap-1.5 px-3 py-1.5 bg-black/50 backdrop-blur-sm text-white rounded-full text-xs font-medium">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                                    Zoom
                                </span>
                                <span class="flex items-center gap-1.5 px-3 py-1.5 bg-black/50 backdrop-blur-sm text-white rounded-full text-xs font-medium">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                                    Lihat Penuh
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Lightbox --}}
                <div x-show="lightboxOpen"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 backdrop-blur-sm"
                     @click.self="closeLightbox()"
                     @keydown.escape.window="closeLightbox()"
                     x-cloak>
                    <div class="relative max-w-[90vw] max-h-[90vh] flex items-center justify-center">
                        <img src="{{ \App\Helpers\StorageHelper::url($product->image) }}" alt="{{ $product->image_alt ?? $product->name }}" class="max-w-full max-h-[85vh] object-contain rounded-2xl shadow-2xl">
                        <button @click="closeLightbox()" class="absolute -top-12 right-0 sm:top-0 sm:-right-12 w-10 h-10 flex items-center justify-center bg-white/10 hover:bg-white/20 text-white rounded-full transition-colors" aria-label="Tutup">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>                                @if($product->image_alt)
                                <div class="absolute -bottom-10 left-1/2 -translate-x-1/2 text-white/70 text-sm font-medium whitespace-nowrap">{{ $product->image_alt }}</div>
                                @endif
                    </div>
                </div>
            </div>
            @endif

            {{-- Content Grid --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
                {{-- Main Content (2/3) --}}
                <div class="lg:col-span-2 space-y-8 lg:space-y-10">
                    @if($product->description)
                    <div class="reveal-up" x-intersect="$el.classList.add('is-visible')">
                        <div class="double-bezel">
                            <div class="double-bezel-inner p-6 sm:p-8">
                                <span class="eyebrow-badge mb-4 inline-flex">Deskripsi Produk</span>
                                <div class="prose prose-sm sm:prose-base lg:prose-lg prose-emerald max-w-none text-secondary">
                                    {!! $product->description !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($product->benefits)
                    <div class="reveal-up" x-intersect="$el.classList.add('is-visible')">
                        <div class="double-bezel">
                            <div class="double-bezel-inner p-6 sm:p-8">
                                <span class="eyebrow-badge mb-4 inline-flex bg-amber-50 dark:bg-amber-900/50 text-amber-700 dark:text-amber-400 border-amber-200/50 dark:border-amber-800/50">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    &nbsp;Keunggulan & Manfaat
                                </span>
                                <ul class="space-y-3">
                                    @foreach($product->benefits as $benefit)
                                    <li class="flex items-start gap-3 group/item">
                                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-emerald-50 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400 shrink-0 mt-0.5 group-hover/item:scale-110 transition-transform duration-300">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        </span>
                                        <span class="text-secondary dark:text-slate-400">{{ $benefit }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($product->requirements)
                    <div class="reveal-up" x-intersect="$el.classList.add('is-visible')">
                        <div class="double-bezel">
                            <div class="double-bezel-inner p-6 sm:p-8">
                                <span class="eyebrow-badge mb-4 inline-flex bg-sky-50 dark:bg-sky-900/50 text-sky-700 dark:text-sky-400 border-sky-200/50 dark:border-sky-800/50">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                    &nbsp;Persyaratan
                                </span>
                                <ul class="space-y-3">
                                    @foreach($product->requirements as $requirement)
                                    <li class="flex items-start gap-3 group/item">
                                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-sky-50 dark:bg-sky-900/50 text-sky-600 dark:text-sky-400 shrink-0 mt-0.5 group-hover/item:scale-110 transition-transform duration-300">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        </span>
                                        <span class="text-secondary dark:text-slate-400">{{ $requirement }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Sidebar (1/3) --}}
                <div class="space-y-6 lg:space-y-8">
                    {{-- Sticky Info Card --}}
                    <div class="lg:sticky lg:top-28 reveal-up" x-intersect="$el.classList.add('is-visible')">
                        <div class="double-bezel">
                            <div class="double-bezel-inner p-6">
                                <h3 class="text-base font-bold text-foreground mb-5 pb-4 border-b border-border/50">Informasi Produk</h3>
                                <div class="space-y-3">
                                    @if($product->type)
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-secondary">Kategori</span>
                                        <span class="text-sm font-semibold text-emerald-600">
                                            @switch($product->type)
                                                @case('simpanan_syariah') Simpanan @break
                                                @case('pembiayaan_syariah') Pembiayaan @break
                                                @case('deposito_syariah') Deposito @break
                                                @case('kas_keliling') Kas Keliling @break
                                                @default {{ ucwords(str_replace('_', ' ', $product->type)) }}
                                            @endswitch
                                        </span>
                                    </div>
                                    @endif
                                    @if($product->created_at)
                                    <div class="flex items-center justify-between pt-3 border-t border-border/50">
                                        <span class="text-sm text-secondary">Dipublikasikan</span>
                                        <span class="text-sm font-medium text-foreground">{{ $product->created_at->format('d M Y') }}</span>
                                    </div>
                                    @endif
                                </div>

                                {{-- CTA Buttons with Button-in-Button --}}
                                <div class="mt-6 pt-5 border-t border-border/50 space-y-3">
                                    <a href="{{ route('contact') }}"
                                       class="group w-full inline-flex items-center justify-center gap-3 px-6 py-3.5 rounded-full bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-bold shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/30 transition-all duration-500 ease-[cubic-bezier(0.32,0.72,0,1)] active:scale-[0.98]">
                                        <span>Ajukan Sekarang</span>
                                        <span class="flex items-center justify-center w-6 h-6 rounded-full bg-white/20 text-white transition-all duration-500 group-hover:translate-x-0.5 group-hover:-translate-y-0.5">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                        </span>
                                    </a>
                                    <a href="{{ route('about.offices') }}"
                                       class="group w-full inline-flex items-center justify-center gap-3 px-6 py-3.5 rounded-full border-2 border-emerald-100 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 font-bold hover:bg-emerald-50 dark:hover:bg-emerald-900/30 hover:border-emerald-200 dark:hover:border-emerald-700 transition-all duration-500 ease-[cubic-bezier(0.32,0.72,0,1)] active:scale-[0.98]">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span>Kunjungi Kantor</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Brochure Card --}}
                    @if($product->brochure)
                    <div class="reveal-up" x-intersect="$el.classList.add('is-visible')">
                        <div class="double-bezel">
                            <div class="double-bezel-inner p-6">
                                <h3 class="text-base font-bold text-foreground mb-4">Brosur Produk</h3>
                                <a href="{{ \App\Helpers\StorageHelper::url($product->brochure) }}"
                                   target="_blank"
                                   class="group w-full inline-flex items-center justify-center gap-3 px-6 py-3.5 rounded-full bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-bold shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/30 transition-all duration-500 ease-[cubic-bezier(0.32,0.72,0,1)] active:scale-[0.98]">
                                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    <span>Download Brosur</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Share Card --}}
                    <div class="reveal-up" x-intersect="$el.classList.add('is-visible')">
                        <div class="double-bezel">
                            <div class="double-bezel-inner p-6">
                                <h3 class="text-base font-bold text-foreground mb-4">Bagikan Produk</h3>
                                <div class="flex gap-2" x-data="{ copied: false }">
                                    <a href="https://wa.me/?text={{ urlencode($product->name . ' - ' . url()->current()) }}"
                                       target="_blank"
                                       class="flex-1 flex items-center justify-center gap-1.5 px-3 py-3 rounded-full bg-green-500 text-white hover:bg-green-600 transition-all duration-300 text-sm font-medium active:scale-[0.97]">
                                        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                       target="_blank"
                                       class="flex-1 flex items-center justify-center gap-1.5 px-3 py-3 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition-all duration-300 text-sm font-medium active:scale-[0.97]">
                                        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                    </a>
                                    <button @click.prevent="navigator.clipboard.writeText('{{ url()->current() }}').then(() => { copied = true; setTimeout(() => copied = false, 2000) }).catch(() => {})"
                                            class="flex-1 flex items-center justify-center gap-1.5 px-3 py-3 rounded-full bg-emerald-600 text-white hover:bg-emerald-700 transition-all duration-300 text-sm font-medium active:scale-[0.97]"
                                            aria-label="Salin link">
                                        <template x-if="!copied">
                                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                        </template>
                                        <template x-if="copied">
                                            <svg class="w-4 h-4 shrink-0 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        </template>
                                        <span x-text="copied ? 'Disalin!' : ''" class="text-xs"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-frontend-layout>
