<x-frontend-layout>
    <x-slot:title>Berita & Artikel - {{ config('app.name') }}</x-slot:title>

    {{-- ═══ HIGH-END v2: HERO — Ethereal Glass ═══ --}}
    <section class="relative pt-8 sm:pt-10 md:pt-12 pb-16 sm:pb-20 md:pb-28 overflow-hidden">
        <div class="absolute inset-0 hero-gradient">
            <div class="absolute inset-0 bg-grid-pattern opacity-30"></div>
            <div class="absolute top-10 left-1/4 w-80 h-80 bg-emerald-400/20 rounded-full blur-3xl animate-float-slow"></div>
            <div class="absolute bottom-10 right-1/4 w-96 h-96 bg-emerald-400/20 rounded-full blur-3xl animate-float-slow" style="animation-delay: 3s;"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="eyebrow-badge mb-5 inline-flex bg-white/20 text-white border-white/20">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                Informasi Terkini
            </span>
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-white mb-4 sm:mb-6 tracking-tight leading-tight">Berita & Artikel</h1>
            <p class="text-base sm:text-lg md:text-xl text-white/80 w-full px-4 leading-relaxed">
                Dapatkan wawasan terbaru seputar ekonomi syariah dan kegiatan BPRS Bangka Belitung.
            </p>
        </div>                        <div class="absolute bottom-0 left-0 right-0 h-16 bg-gradient-to-t from-muted/30 dark:from-slate-900/30 to-transparent"></div>
    </section>

    {{-- ═══ SEARCH & FILTER — Premium Glass Card ═══ --}}
    <section class="py-16 lg:py-20 -mt-10 sm:-mt-12 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="reveal-up" x-intersect="$el.classList.add('is-visible')">
                <div class="double-bezel">
                    <div class="double-bezel-inner p-4 sm:p-6 lg:p-8">
                        <form method="GET" class="flex flex-col gap-4 sm:gap-5">
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
                                <div class="sm:col-span-2">
                                    <div class="relative">
                                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-4 h-4 sm:w-5 sm:h-5 text-secondary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berita..." class="w-full pl-12 pr-4 py-3 rounded-full border border-border bg-white dark:bg-slate-800/90 text-foreground text-sm placeholder:text-secondary dark:placeholder:text-slate-500 hover:border-emerald-200 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition-all duration-200">
                                    </div>
                                </div>
                                <div>
                                    <select name="category" class="w-full px-4 py-3 rounded-full border border-border bg-white dark:bg-slate-800/90 text-foreground text-sm hover:border-emerald-200 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 transition-all duration-200 appearance-none">
                                        <option value="">Semua Kategori</option>
                                        @foreach($categories as $cat)
                                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="flex justify-center sm:justify-end">
                                <button type="submit" class="group inline-flex items-center gap-3 px-6 py-3 rounded-full bg-emerald-600 text-white font-bold shadow-lg shadow-emerald-500/15 hover:bg-emerald-700 hover:shadow-emerald-500/25 transition-all duration-500 ease-[cubic-bezier(0.32,0.72,0,1)] active:scale-[0.98] text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                    <span>Cari</span>
                                </button>
                            </div>
                        </form>

                        @if(request('search') || request('category'))
                        <div class="flex flex-wrap items-center gap-2 pt-4 mt-4 border-t border-border/50 dark:border-slate-700/50">
                            <span class="text-xs text-secondary dark:text-slate-400 font-medium">Filter aktif:</span>
                            @if(request('search'))
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-muted dark:bg-slate-800 text-foreground text-xs font-medium border border-border dark:border-slate-700">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                "{{ request('search') }}"
                                <a href="{{ route('news.index', request()->except('search')) }}" class="hover:text-foreground ml-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></a>
                            </span>
                            @endif
                            @if(request('category'))
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-muted dark:bg-slate-800 text-foreground text-xs font-medium border border-border dark:border-slate-700">
                                {{ request('category') }}
                                <a href="{{ route('news.index', request()->except('category')) }}" class="hover:text-foreground ml-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></a>
                            </span>
                            @endif
                            <a href="{{ route('news.index') }}" class="text-xs text-secondary dark:text-slate-400 hover:text-emerald-600 font-medium transition-colors ml-1">Reset</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ NEWS GRID — Masonry Layout + Interactive Cards ═══ --}}
    <section class="pb-20 lg:pb-28 bg-muted/30 dark:bg-slate-950/50 relative">
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
            <div class="absolute top-20 left-0 w-64 h-64 bg-emerald-50 rounded-full blur-[100px]"></div>
            <div class="absolute bottom-20 right-0 w-64 h-64 bg-emerald-50 rounded-full blur-[100px]"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8"
                 x-intersect="$el.querySelectorAll('.news-card').forEach((el, i) => { setTimeout(() => el.classList.add('is-visible'), i * 80) })">
                @forelse($news as $index => $item)
                <article class="news-card reveal-up" style="transition-delay: {{ $index * 60 }}ms">
                    <div class="group relative h-full">
                        <div class="double-bezel h-full">
                            <div class="double-bezel-inner h-full flex flex-col min-h-[400px]">
                                {{-- Image Area dengan Parallax Hover + Skeleton --}}
                                <a href="{{ route('news.show', $item->slug) }}" class="block relative overflow-hidden shrink-0" style="border-radius: var(--radius-double-inner) var(--radius-double-inner) 0 0;">
                                    @if($item->featured_image)
                                    <div class="aspect-[16/9] bg-muted dark:bg-slate-800 overflow-hidden relative">
                                        {{-- Loading Skeleton --}}
                                        <div class="absolute inset-0 bg-gradient-to-r from-muted via-muted/50 to-muted animate-pulse"></div>
                                        <x-optimized-image
                                            :src="\App\Helpers\StorageHelper::url($item->featured_image)"
                                            :alt="$item->title"
                                            :priority="$index < 3"
                                            :lazy="$index >= 3"
                                            class="w-full h-full transition-all duration-700 ease-[cubic-bezier(0.32,0.72,0,1)] group-hover:scale-110 group-hover:rotate-1 relative z-10"
                                            aspect-ratio="16/9" />
                                    </div>
                                    @else
                                    <div class="aspect-[16/9] bg-gradient-to-br from-emerald-50 dark:from-emerald-900/30 to-emerald-100/50 dark:to-emerald-900/10 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-emerald-300 group-hover:scale-110 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    @endif
                                    
                                    {{-- Category Badge --}}
                                    @if($item->category)
                                    <div class="absolute top-3 left-3 z-10">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-white/90 dark:bg-slate-900/90 backdrop-blur-sm text-emerald-700 dark:text-emerald-400 border border-white/50 dark:border-slate-700/50 shadow-sm">
                                            {{ $item->category }}
                                        </span>
                                    </div>
                                    @endif

                                    {{-- Gradient Overlay Bottom --}}
                                    <div class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    
                                    {{-- Quick View Icon --}}
                                    <div class="absolute bottom-3 right-3 flex items-center justify-center w-10 h-10 rounded-full bg-white/90 dark:bg-slate-900/90 backdrop-blur-sm text-emerald-600 dark:text-emerald-400 opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300 shadow-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </div>
                                </a>

                                {{-- Content --}}
                                <div class="p-5 sm:p-6 flex-1 flex flex-col">
                                    <div class="flex items-center gap-2 text-xs text-secondary dark:text-slate-400 mb-3">
                                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <time datetime="{{ $item->published_at->toISOString() }}">{{ $item->published_at->translatedFormat('d F Y') }}</time>
                                        <span class="text-border dark:text-slate-700">•</span>
                                        <div class="flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            {{ number_format($item->views ?? 0) }}
                                        </div>
                                    </div>

                                    <a href="{{ route('news.show', $item->slug) }}" class="block mb-3 group/title">
                                        <h3 class="text-base sm:text-lg font-bold text-foreground line-clamp-2 group-hover/title:text-emerald-600 transition-colors duration-300 leading-snug">
                                            {{ $item->title }}
                                        </h3>
                                    </a>

                                    @php
                                        $excerpt = $item->excerpt ?: Str::limit(strip_tags($item->content ?? ''), 120);
                                    @endphp
                                    <p class="text-secondary dark:text-slate-400 text-sm mb-4 line-clamp-2 leading-relaxed">{{ $excerpt }}</p>

                                    {{-- Footer: Author/Meta + CTA --}}
                                    <div class="flex items-center justify-between pt-4 border-t border-border/50 dark:border-slate-700/50 mt-auto">
                                        {{-- Reading Time --}}
                                        <div class="flex items-center gap-1.5 text-xs text-secondary dark:text-slate-400">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2"/><circle cx="12" cy="12" r="10"/></svg>
                                            <span>{{ ceil(str_word_count(strip_tags($item->content)) / 200) }} mnt</span>
                                        </div>

                                        {{-- Button-in-Button CTA --}}
                                        <a href="{{ route('news.show', $item->slug) }}" class="inline-flex items-center gap-1.5 text-emerald-600 font-semibold text-sm group-hover:gap-2.5 transition-all duration-300">
                                            <span>Baca</span>
                                            <span class="flex items-center justify-center w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-900/50 text-emerald-600 dark:text-emerald-400 transition-all duration-500 group-hover:translate-x-0.5 group-hover:-translate-y-0.5 group-hover:scale-110 group-hover:shadow-md group-hover:shadow-emerald-500/30">
                                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Glow Effect on Hover --}}
                        <div class="absolute -inset-[1px] rounded-[calc(var(--radius-double)+2px)] bg-gradient-to-br from-emerald-400/0 via-emerald-400/0 to-emerald-400/0 group-hover:from-emerald-400/20 group-hover:via-transparent group-hover:to-emerald-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-500 -z-10 blur-xl"></div>
                    </div>
                </article>
                @empty
                <div class="col-span-full reveal-up break-inside-avoid" x-intersect="$el.classList.add('is-visible')">
                    <div class="double-bezel">
                        <div class="double-bezel-inner py-16 px-6 text-center">
                            <div class="w-16 h-16 rounded-full bg-muted dark:bg-slate-800 flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-foreground mb-2">Tidak Ada Berita</h3>
                            <p class="text-sm text-secondary dark:text-slate-400 w-full mb-6">Belum ada berita yang sesuai dengan kriteria pencarian Anda.</p>
                            <a href="{{ route('news.index') }}" class="group inline-flex items-center gap-2 px-6 py-3 rounded-full bg-emerald-600 text-white font-bold shadow-lg shadow-emerald-500/15 hover:bg-emerald-700 transition-all duration-500 ease-[cubic-bezier(0.32,0.72,0,1)] active:scale-[0.98] text-sm">
                                Reset Pencarian
                            </a>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>

            @if($news->hasPages())
            <div class="mt-12 flex justify-center reveal-up" x-intersect="$el.classList.add('is-visible')">
                {{ $news->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
    </section>
</x-frontend-layout>
