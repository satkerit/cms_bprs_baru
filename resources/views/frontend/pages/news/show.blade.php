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

    <!-- Hero Section -->
    <section class="relative pt-24 sm:pt-28 md:pt-32 pb-12 sm:pb-14 md:pb-16 overflow-hidden">
        <div class="absolute inset-0 gradient-primary-deep">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.04\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-40"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="max-w-5xl mx-auto">
                <a href="{{ route('news.index') }}" class="inline-flex items-center gap-1.5 text-white/70 hover:text-white mb-4 transition-colors text-sm group">
                    <svg class="w-4 h-4 shrink-0 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke Berita
                </a>

                <div class="flex flex-wrap items-center gap-2 sm:gap-3 mb-3 sm:mb-4">
                    @if($news->category)
                    <span class="px-3 py-1.5 text-xs font-semibold bg-white/15 backdrop-blur-sm rounded-lg text-emerald-700 border border-white/20">
                        {{ $news->category }}
                    </span>
                    @endif
                    <span class="flex items-center gap-1.5 text-white/60 text-xs">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2"/>
                            <circle cx="12" cy="12" r="10"/>
                        </svg>
                        {{ ceil(str_word_count(strip_tags($news->content)) / 200) }} menit baca
                    </span>
                </div>

                <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 sm:mb-6 leading-tight tracking-tight">
                    {{ $news->title }}
                </h1>

                <div class="flex items-center gap-3 sm:gap-4 text-xs sm:text-sm text-white/60">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <time datetime="{{ $news->published_at->toISOString() }}">{{ $news->published_at->translatedFormat('d F Y') }}</time>
                    </div>
                    <span class="text-white/30">|</span>
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        {{ number_format($news->views ?? 0) }} dilihat
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Content -->
    <section class="py-10 sm:py-14 md:py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
                <!-- Main Content -->
                <div class="lg:col-span-8">
                    <div class="bg-white rounded-2xl border border-border overflow-hidden">
                        @if($news->featured_image)
                        <div class="relative overflow-hidden aspect-video">
                            <img src="{{ storage_url($news->featured_image) }}"
                                 alt="{{ $news->title }}"
                                 class="w-full h-full object-cover"
                                 loading="eager"
                                 fetchpriority="high">
                        </div>
                        @endif
                        <div class="p-6 sm:p-8 md:p-10">
                            @if($news->excerpt)
                            <div class="text-base sm:text-lg md:text-xl font-medium text-emerald-600 mb-6 sm:mb-8 leading-relaxed border-l-4 border-emerald-600 pl-4 sm:pl-6 bg-emerald-50 -mx-6 sm:-mx-8 md:-mx-10 px-6 sm:px-8 md:px-10 py-4 sm:py-6">
                                {{ $news->excerpt }}
                            </div>
                            @endif

                            <div class="prose prose-sm sm:prose-base lg:prose-lg prose-emerald max-w-none mb-6 sm:mb-8">
                                {!! $news->content !!}
                            </div>

                            <div class="flex flex-wrap items-center gap-3 pt-6 sm:pt-8 border-t border-border" x-data="{ copied: false }">
                                <span class="text-sm font-medium text-secondary">Bagikan:</span>
                                <a href="https://wa.me/?text={{ urlencode($news->title . ' - ' . url()->current()) }}"
                                   target="_blank"
                                   class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white text-foreground border border-border hover:bg-green-50 hover:text-green-600 hover:border-green-200 transition-all duration-200"
                                   aria-label="Bagikan via WhatsApp">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                   target="_blank"
                                   class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white text-foreground border border-border hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition-all duration-200"
                                   aria-label="Bagikan via Facebook">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                                <button @click.prevent="navigator.clipboard.writeText('{{ url()->current() }}').then(() => { copied = true; setTimeout(() => copied = false, 2000) }).catch(() => { alert('Gagal menyalin link') })"
                                        class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white text-foreground border border-border hover:bg-muted transition-all duration-200"
                                        aria-label="Salin link">
                                    <template x-if="!copied">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                    </template>
                                    <template x-if="copied">
                                        <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </template>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-4 space-y-6">
                    @if($news->category)
                    <div class="bg-white rounded-2xl border border-border p-5 sm:p-6 shadow-sm">
                        <h3 class="text-base font-bold text-foreground mb-4">Kategori</h3>
                        <a href="{{ route('news.index', ['category' => $news->category]) }}"
                           class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-xl hover:bg-emerald-700 transition-colors shadow-sm btn-press">
                            {{ $news->category }}
                        </a>
                    </div>
                    @endif

                    @if($relatedNews->count() > 0)
                    <div class="bg-white rounded-2xl border border-border p-5 sm:p-6 shadow-sm">
                        <h3 class="text-base font-bold text-foreground mb-4">Berita Terkait</h3>
                        <div class="space-y-4">
                            @foreach($relatedNews as $related)
                            <a href="{{ route('news.show', $related->slug) }}"
                               class="group flex gap-3 sm:gap-4 p-2 -mx-2 rounded-xl hover:bg-muted transition-all duration-200">
                                @if($related->featured_image)
                                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl overflow-hidden shrink-0 bg-muted">
                                    <img src="{{ storage_url($related->featured_image) }}" alt="{{ $related->title }}" class="w-full h-full object-cover" loading="lazy">
                                </div>
                                @else
                                <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-xl shrink-0 bg-muted flex items-center justify-center">
                                    <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs text-secondary mb-1">{{ $related->published_at->translatedFormat('d M Y') }}</p>
                                    <p class="text-sm font-semibold text-foreground group-hover:text-emerald-600 transition-colors line-clamp-2">{{ $related->title }}</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="bg-gradient-to-br from-emerald-50 to-emerald-50 rounded-2xl border border-emerald-100 p-5 sm:p-6 text-center">
                        <h3 class="text-base font-bold text-foreground mb-2">Ikuti Kami</h3>
                        <p class="text-sm text-secondary mb-4">Dapatkan informasi terkini dari BPRS Bangka Belitung</p>
                        <div class="flex justify-center gap-2">
                            <a href="#" class="w-10 h-10 rounded-xl bg-white text-foreground border border-border hover:bg-white hover:text-emerald-600 hover:border-emerald-100 flex items-center justify-center transition-all duration-200 shadow-sm" aria-label="Instagram">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069z"/></svg>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-xl bg-white text-foreground border border-border hover:bg-white hover:text-emerald-600 hover:border-emerald-100 flex items-center justify-center transition-all duration-200 shadow-sm" aria-label="Twitter">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </a>
                            <a href="#" class="w-10 h-10 rounded-xl bg-white text-foreground border border-border hover:bg-white hover:text-emerald-600 hover:border-emerald-100 flex items-center justify-center transition-all duration-200 shadow-sm" aria-label="LinkedIn">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-frontend-layout>
