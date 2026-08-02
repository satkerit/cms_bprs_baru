<x-frontend-layout>
    <x-slot:title>{{ $news->title }} - Berita & Artikel</x-slot:title>

    @push('meta')
    <meta property="og:title" content="{{ $news->title }}" />
    <meta property="og:description" content="{{ $news->excerpt }}" />
    @if($news->featured_image)
    <meta property="og:image" content="{{ storage_url($news->featured_image) }}" />
    @endif
    <meta property="og:type" content="article" />
    <meta property="article:published_time" content="{{ $news->published_at->toISOString() }}" />
    @endpush

    {{-- ═══ HIGH-END v2: HERO — Ethereal Glass ═══ --}}
    <section class="relative pt-8 sm:pt-10 md:pt-12 pb-12 sm:pb-16 overflow-hidden">
        <div class="absolute inset-0 hero-gradient">
            <div class="absolute inset-0 bg-grid-pattern opacity-40"></div>
            <div class="absolute top-10 left-1/4 w-72 h-72 bg-emerald-400/20 rounded-full blur-3xl animate-float-slow"></div>
            <div class="absolute bottom-10 right-1/4 w-80 h-80 bg-emerald-400/20 rounded-full blur-3xl animate-float-slow" style="animation-delay: 3s;"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Back link --}}
            <a href="{{ route('news.index') }}" class="group inline-flex items-center gap-1.5 text-white/70 hover:text-white mb-6 transition-all duration-300 text-sm">
                <span class="flex items-center justify-center w-6 h-6 rounded-full bg-white/10 backdrop-blur-sm group-hover:bg-white/20 transition-all duration-300">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                    </svg>
                </span>
                <span class="font-medium">Kembali ke Berita</span>
            </a>

            {{-- Category badge & reading time --}}
            <div class="flex flex-wrap items-center gap-3 sm:gap-4 mb-4">
                @if($news->category)
                <span class="eyebrow-badge inline-flex bg-white/20 text-white border-white/20">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    {{ $news->category }}
                </span>
                @endif
                <span class="flex items-center gap-1.5 text-white/60 text-xs sm:text-sm">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2"/>
                        <circle cx="12" cy="12" r="10"/>
                    </svg>
                    {{ ceil(str_word_count(strip_tags($news->content)) / 200) }} menit baca
                </span>
            </div>

            {{-- Title --}}
            <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-4 sm:mb-6 leading-tight tracking-tight">
                {{ $news->title }}
            </h1>

            {{-- Meta info --}}
            <div class="flex flex-wrap items-center gap-3 sm:gap-5 text-xs sm:text-sm text-white/60">
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <time datetime="{{ $news->published_at->toISOString() }}">{{ $news->published_at->translatedFormat('d F Y') }}</time>
                </div>
                <span class="text-white/30 hidden sm:inline">|</span>
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    {{ number_format($news->views ?? 0) }} dilihat
                </div>
            </div>

            {{-- Excerpt / Description --}}
            @php
                $heroExcerpt = trim((string) $news->excerpt) ?: Str::limit(strip_tags($news->content ?? ''), 200);
            @endphp
            @if($heroExcerpt)
            <p class="text-base sm:text-lg text-white/75 leading-relaxed mt-4 sm:mt-5">
                {{ $heroExcerpt }}
            </p>
            @endif
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-white dark:from-slate-900 to-transparent"></div>
    </section>

    {{-- ═══ CONTENT SECTION — Double-Bezel Core + Premium Sidebar ═══ --}}
    <section class="py-10 sm:py-14 md:py-16 lg:py-20 bg-white dark:bg-slate-900 relative">
        {{-- Subtle background texture --}}
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
            <div class="absolute top-40 left-0 w-72 h-72 bg-emerald-50/60 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-40 right-0 w-72 h-72 bg-amber-50/40 rounded-full blur-[120px]"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
                {{-- ═══ Main Content — Double-Bezel ═══ --}}
                <div class="lg:col-span-8 reveal-up" x-intersect="$el.classList.add('is-visible')">
                    <div class="double-bezel">
                        <div class="double-bezel-inner divide-y divide-border/50">
                            {{-- Featured Image --}}
                            @if($news->featured_image)
                            <div class="relative overflow-hidden" style="border-radius: var(--radius-double-inner) var(--radius-double-inner) 0 0;">
                                <div class="aspect-[16/9] bg-muted dark:bg-slate-800">
                                    <x-optimized-image
                                        :src="storage_url($news->featured_image)"
                                        :alt="$news->title"
                                        :priority="true"
                                        :lazy="false"
                                        class="w-full h-full transition-all duration-700 hover:scale-[1.02]"
                                        aspect-ratio="16/9" />
                                </div>
                            </div>
                            @endif

                            {{-- Content Body --}}
                            <div class="p-6 sm:p-8 md:p-10 lg:p-12">
                                {{-- Excerpt — Styled pull quote --}}
                                @if($news->excerpt)
                                <div class="relative mb-8 sm:mb-10 pl-5 sm:pl-7 border-l-[3px] border-emerald-500">
                                    <div class="absolute -left-2 -top-2 text-emerald-100">
                                        <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H14.017zM0 21v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151C7.563 6.068 6 8.789 6 11h4v10H0z"/></svg>
                                    </div>
                                    <p class="text-base sm:text-lg md:text-xl text-emerald-700 font-medium leading-relaxed italic">
                                        {{ $news->excerpt }}
                                    </p>
                                </div>
                                @endif

                                {{-- Main content — Prose --}}
                                <div class="prose prose-sm sm:prose-base lg:prose-lg prose-emerald max-w-none prose-headings:font-bold prose-headings:text-foreground prose-a:text-emerald-600 prose-a:no-underline hover:prose-a:underline prose-img:rounded-2xl prose-img:shadow-md">
                                    {!! $news->content !!}
                                </div>

                                {{-- Share Section — Premium Button-in-Button --}}
                                <div class="flex flex-wrap items-center gap-3 pt-8 sm:pt-10 mt-8 sm:mt-10 border-t border-border/70 dark:border-slate-700/70" x-data="{ copied: false }">
                                    <span class="text-sm font-semibold text-secondary tracking-wide uppercase text-[11px]">Bagikan:</span>

                                    {{-- WhatsApp --}}
                                    <a href="https://wa.me/?text={{ urlencode($news->title . ' - ' . url()->current()) }}"
                                       target="_blank"
                                       class="group inline-flex items-center justify-center w-10 h-10 rounded-full bg-white dark:bg-slate-800 text-foreground border border-border dark:border-slate-700 hover:bg-green-50 dark:hover:bg-green-900/30 hover:text-green-600 hover:border-green-200 transition-all duration-300 active:scale-[0.93]"
                                       aria-label="Bagikan via WhatsApp">
                                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    </a>

                                    {{-- Facebook --}}
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                       target="_blank"
                                       class="group inline-flex items-center justify-center w-10 h-10 rounded-full bg-white dark:bg-slate-800 text-foreground border border-border dark:border-slate-700 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 hover:border-blue-200 transition-all duration-300 active:scale-[0.93]"
                                       aria-label="Bagikan via Facebook">
                                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                    </a>

                                    {{-- Twitter/X --}}
                                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($news->title) }}&url={{ urlencode(url()->current()) }}"
                                       target="_blank"
                                       class="group inline-flex items-center justify-center w-10 h-10 rounded-full bg-white dark:bg-slate-800 text-foreground border border-border dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-gray-800/50 hover:text-gray-900 hover:border-gray-300 transition-all duration-300 active:scale-[0.93]"
                                       aria-label="Bagikan via Twitter">
                                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                    </a>

                                    {{-- LinkedIn --}}
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                                       target="_blank"
                                       class="group inline-flex items-center justify-center w-10 h-10 rounded-full bg-white dark:bg-slate-800 text-foreground border border-border dark:border-slate-700 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-700 hover:border-blue-200 transition-all duration-300 active:scale-[0.93]"
                                       aria-label="Bagikan via LinkedIn">
                                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                    </a>

                                    {{-- Copy Link — Button-in-Button --}}
                                    <button @click.prevent="navigator.clipboard.writeText('{{ url()->current() }}').then(() => { copied = true; setTimeout(() => copied = false, 2000) })"
                                            class="group inline-flex items-center justify-center w-10 h-10 rounded-full bg-white dark:bg-slate-800 text-foreground border border-border dark:border-slate-700 hover:bg-muted dark:hover:bg-slate-700 hover:border-border transition-all duration-300 active:scale-[0.93] relative"
                                            aria-label="Salin link"
                                            x-data="{ tooltip: false }"
                                            @mouseenter="tooltip = true"
                                            @mouseleave="tooltip = false">
                                        <template x-if="!copied">
                                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                        </template>
                                        <template x-if="copied">
                                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        </template>
                                        {{-- Tooltip --}}
                                        <span x-show="tooltip && !copied"
                                              x-cloak
                                              x-transition:enter="transition ease-out duration-200"
                                              x-transition:enter-start="opacity-0 translate-y-1"
                                              x-transition:enter-end="opacity-100 translate-y-0"
                                              class="absolute -top-8 left-1/2 -translate-x-1/2 px-2 py-1 rounded-md bg-foreground text-white text-[10px] font-medium whitespace-nowrap shadow-lg">
                                            Salin link
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ═══ Sidebar — Premium Double-Bezel Cards ═══ --}}
                <aside class="lg:col-span-4 space-y-6 lg:space-y-8 reveal-up relative z-10" style="transition-delay: 150ms" x-intersect="$el.classList.add('is-visible')">
                    {{-- Category Card --}}
                    @if($news->category)
                    <div class="double-bezel">
                        <div class="double-bezel-inner p-5 sm:p-6">
                            <span class="eyebrow-badge inline-flex mb-3">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                Kategori
                            </span>
                            <a href="{{ route('news.index', ['category' => $news->category]) }}"
                               class="group inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-emerald-600 text-white text-sm font-bold hover:bg-emerald-700 transition-all duration-500 ease-[cubic-bezier(0.32,0.72,0,1)] active:scale-[0.97] shadow-lg shadow-emerald-500/15">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                <span>{{ $news->category }}</span>
                                <span class="flex items-center justify-center w-5 h-5 rounded-full bg-emerald-500 text-white transition-all duration-300 group-hover:translate-x-0.5">
                                    <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                </span>
                            </a>
                        </div>
                    </div>
                    @endif

                    {{-- Related News Card --}}
                    @if($relatedNews->count() > 0)
                    <div class="double-bezel">
                        <div class="double-bezel-inner p-5 sm:p-6">
                            <span class="eyebrow-badge inline-flex mb-4">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                Berita Terkait
                            </span>
                            <div class="space-y-3 sm:space-y-4">
                                @foreach($relatedNews as $related)
                                <a href="{{ route('news.show', $related->slug) }}"
                                   class="group flex gap-3 sm:gap-4 p-2.5 -mx-2 rounded-xl hover:bg-muted/50 dark:hover:bg-slate-800 transition-all duration-300">
                                    @if($related->featured_image)
                                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl overflow-hidden shrink-0 bg-muted dark:bg-slate-800 ring-1 ring-border/30 dark:ring-slate-700/50 group-hover:ring-emerald-200/50 transition-all duration-300">
                                        <x-optimized-image
                                            :src="storage_url($related->featured_image)"
                                            :alt="$related->title"
                                            :lazy="true"
                                            class="w-full h-full transition-all duration-500 group-hover:scale-105"
                                            aspect-ratio="1/1" />
                                    </div>
                                    @else
                                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl shrink-0 bg-gradient-to-br from-muted dark:from-slate-800 to-muted/70 dark:to-slate-800/70 flex items-center justify-center ring-1 ring-border/30 dark:ring-slate-700/50">
                                        <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <p class="text-[11px] text-secondary font-medium mb-1 uppercase tracking-wider">{{ $related->published_at->translatedFormat('d M Y') }}</p>
                                        <p class="text-sm font-semibold text-foreground group-hover:text-emerald-600 transition-colors line-clamp-2 leading-snug">{{ $related->title }}</p>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Follow Us Card --}}
                    <div class="double-bezel">
                        <div class="double-bezel-inner p-5 sm:p-6 text-center relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-br from-emerald-50/50 dark:from-emerald-950/30 to-transparent pointer-events-none"></div>
                            <div class="relative">
                                <span class="eyebrow-badge inline-flex mb-3">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/></svg>
                                    Ikuti Kami
                                </span>
                                <p class="text-sm text-secondary dark:text-slate-400 mb-5 w-full">Dapatkan informasi terkini dari BPRS Bangka Belitung</p>
                                <div class="flex justify-center gap-2.5">
                                    <a href="#" class="group inline-flex items-center justify-center w-10 h-10 rounded-full bg-white dark:bg-slate-800 text-foreground border border-border dark:border-slate-700 hover:bg-gradient-to-br hover:from-pink-500 hover:via-purple-500 hover:to-orange-400 hover:text-white hover:border-transparent transition-all duration-300 active:scale-[0.93] shadow-sm" aria-label="Instagram">
                                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                                    </a>
                                    <a href="#" class="group inline-flex items-center justify-center w-10 h-10 rounded-full bg-white dark:bg-slate-800 text-foreground border border-border dark:border-slate-700 hover:bg-gradient-to-br hover:from-sky-400 hover:to-blue-500 hover:text-white hover:border-transparent transition-all duration-300 active:scale-[0.93] shadow-sm" aria-label="Twitter">
                                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                    </a>
                                    <a href="#" class="group inline-flex items-center justify-center w-10 h-10 rounded-full bg-white dark:bg-slate-800 text-foreground border border-border dark:border-slate-700 hover:bg-gradient-to-br hover:from-blue-600 hover:to-blue-700 hover:text-white hover:border-transparent transition-all duration-300 active:scale-[0.93] shadow-sm" aria-label="Facebook">
                                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                    </a>
                                    <a href="#" class="group inline-flex items-center justify-center w-10 h-10 rounded-full bg-white dark:bg-slate-800 text-foreground border border-border dark:border-slate-700 hover:bg-gradient-to-br hover:from-blue-500 hover:to-blue-600 hover:text-white hover:border-transparent transition-all duration-300 active:scale-[0.93] shadow-sm" aria-label="LinkedIn">
                                        <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- CTA Card --}}
                    <div class="double-bezel bg-gradient-to-br from-emerald-600 to-emerald-700 text-white border-none">
                        <div class="double-bezel-inner p-5 sm:p-6 text-center relative overflow-hidden">
                            <div class="absolute inset-0 bg-grid-pattern"></div>
                            <div class="relative">
                                <div class="w-12 h-12 rounded-full bg-white/10 backdrop-blur-sm flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                </div>
                                <h3 class="text-base font-bold mb-2">Butuh Informasi Lebih?</h3>
                                <p class="text-sm text-white/80 mb-5 w-full">Hubungi tim marketing kami untuk konsultasi gratis</p>
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
                </aside>
            </div>
        </div>
    </section>
</x-frontend-layout>
