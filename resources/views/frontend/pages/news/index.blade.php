<x-frontend-layout>
    <x-slot:title>Berita & Artikel - {{ config('app.name') }}</x-slot:title>

    <!-- Hero Section -->
    <section class="relative pt-24 sm:pt-28 md:pt-32 pb-12 sm:pb-16 overflow-hidden">
        <div class="absolute inset-0 gradient-primary-deep">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.04\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-40"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-flex items-center px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-full text-emerald-700 text-xs font-semibold border border-white/20 mb-4">
                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                Informasi Terkini
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-3 leading-tight tracking-tight">Berita & Artikel</h1>
            <p class="text-sm sm:text-lg text-emerald-700">Dapatkan wawasan terbaru seputar ekonomi syariah dan kegiatan BPRS Bangka Belitung.</p>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 md:py-16 bg-muted relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search & Filter Card -->
            <div class="mb-8 sm:mb-10 bg-white rounded-2xl border border-border p-4 sm:p-6 relative -mt-20 sm:-mt-24 z-10 shadow-sm">
                <form method="GET" class="flex flex-col gap-3 sm:gap-4">
                    <div class="flex-1">
                        <label class="form-label">Pencarian</label>
                        <div class="relative">
                            <svg class="absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 w-4 h-4 sm:w-5 sm:h-5 text-secondary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari berita..." class="form-input pl-10 sm:pl-12">
                        </div>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                        <div class="flex-1">
                            <label class="form-label">Kategori</label>
                            <select name="category" class="form-select">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full sm:w-auto px-6 sm:px-8 py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl transition-all duration-200 btn-press">
                                Cari
                            </button>
                        </div>
                    </div>
                </form>

                @if(request('search') || request('category'))
                <div class="flex flex-wrap items-center gap-2 pt-3 sm:pt-4 mt-3 sm:mt-4 border-t border-border">
                    <span class="text-xs text-secondary font-medium">Filter aktif:</span>
                    @if(request('search'))
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-muted text-foreground text-xs font-medium rounded-lg border border-border">
                            "{{ request('search') }}"
                            <a href="{{ route('news.index', request()->except('search')) }}" class="hover:text-foreground"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></a>
                        </span>
                    @endif
                    @if(request('category'))
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-muted text-foreground text-xs font-medium rounded-lg border border-border">
                            {{ request('category') }}
                            <a href="{{ route('news.index', request()->except('category')) }}" class="hover:text-foreground"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></a>
                        </span>
                    @endif
                    <a href="{{ route('news.index') }}" class="text-xs text-secondary hover:text-emerald-600 font-medium transition-colors">
                        Reset Filter
                    </a>
                </div>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                @forelse($news as $index => $item)
                <article class="group bg-white rounded-2xl overflow-hidden border border-border hover:border-emerald-100 card-hover flex flex-col h-full">
                    <!-- Image -->
                    <div class="relative h-48 sm:h-56 md:h-60 overflow-hidden bg-muted" style="aspect-ratio: 16/9">
                        @if($item->featured_image)
                        <x-optimized-image
                            :src="\App\Helpers\StorageHelper::url($item->featured_image)"
                            :alt="$item->title"
                            :priority="$index < 3"
                            :lazy="$index >= 3"
                            class="w-full h-full"
                            aspect-ratio="16/9" />
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-emerald-50 to-emerald-100 flex items-center justify-center">
                            <svg class="w-16 h-16 text-emerald-600/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        @endif
                        @if($item->category)
                        <span class="absolute top-4 left-4 px-2.5 py-1 text-xs font-semibold text-white bg-emerald-600 rounded-lg shadow-sm">
                            {{ $item->category }}
                        </span>
                        @endif
                    </div>

                    <div class="p-5 sm:p-6 flex flex-col flex-grow">
                        <div class="flex items-center gap-2 text-xs text-secondary mb-2">
                            <svg class="w-3.5 h-3.5 text-secondary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <time datetime="{{ $item->published_at->toISOString() }}">{{ $item->published_at->translatedFormat('d F Y') }}</time>
                        </div>

                        <h3 class="text-base sm:text-lg font-bold text-foreground mb-2 line-clamp-2 group-hover:text-emerald-600 transition-colors leading-snug">
                            <a href="{{ route('news.show', $item->slug) }}">
                                {{ $item->title }}
                            </a>
                        </h3>

                        <p class="text-secondary text-sm mb-4 line-clamp-3 leading-relaxed flex-grow">{{ $item->excerpt }}</p>

                        <div class="pt-3 sm:pt-4 border-t border-border">
                            <a href="{{ route('news.show', $item->slug) }}"
                               class="inline-flex items-center gap-1.5 text-emerald-600 font-semibold text-sm hover:text-emerald-600 transition-colors group/link">
                                Baca Selengkapnya
                                <svg class="w-4 h-4 group-hover/link:translate-x-1 transition-transform shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </article>
                @empty
                <div class="col-span-full">
                    <div class="text-center py-16 bg-white rounded-2xl border border-border px-4">
                        <div class="w-20 h-20 bg-muted rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                            </svg>
                            
                        </div>
                        <h3 class="text-xl font-bold text-foreground mb-2">Tidak Ada Berita</h3>
                        <p class="text-sm text-secondary mx-auto mb-6">Belum ada berita yang sesuai dengan kriteria pencarian Anda.</p>
                        <a href="{{ route('news.index') }}" class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl transition-colors shadow-sm btn-press">
                            Reset Pencarian
                        </a>
                    </div>
                </div>
                @endforelse
            </div>

            @if($news->hasPages())
            <div class="mt-10 flex justify-center">
                {{ $news->appends(request()->query())->links('pagination.custom') }}
            </div>
            @endif
        </div>
    </section>
</x-frontend-layout>
