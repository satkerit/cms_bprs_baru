<x-frontend-layout>
    <x-slot name="title">{{ $product->name }} - Produk BPRS Bangka Belitung</x-slot>

    @push('meta')
    <meta property="og:title" content="{{ $product->name }}" />
    <meta property="og:description" content="{{ $product->short_description ?? 'Produk BPRS Bangka Belitung' }}" />
    @if($product->icon)
    <meta property="og:image" content="{{ \App\Helpers\StorageHelper::url($product->icon) }}" />
    @endif
    @endpush

    <!-- Hero -->
    <section class="relative pt-24 sm:pt-28 md:pt-32 pb-12 sm:pb-16 overflow-hidden">
        <div class="absolute inset-0 gradient-primary-deep">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.04\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-40"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-5xl mx-auto">
                <a href="{{ route('products.simpanan-syariah') }}" class="inline-flex items-center gap-1.5 text-white/70 hover:text-white mb-4 transition-colors text-sm group">
                    <svg class="w-4 h-4 shrink-0 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke Produk
                </a>

                <div class="flex flex-col md:flex-row md:items-center gap-6 md:gap-10">
                    <div class="flex-1 text-center md:text-left fade-in-section" x-intersect="$el.classList.add('is-visible')">
                        @if($product->category)
                        <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-white/20 text-white border border-white/30 mb-3">
                            {{ $product->category->name }}
                        </span>
                        @endif
                        <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-3 tracking-tight">{{ $product->name }}</h1>
                        @if($product->short_description)
                        <p class="text-base sm:text-lg text-white/80 leading-relaxed">{{ $product->short_description }}</p>
                        @endif
                    </div>
                    @if($product->icon)
                    <div class="shrink-0 mx-auto md:mx-0 fade-in-section" x-intersect="$el.classList.add('is-visible')">
                        <div class="w-24 h-24 sm:w-28 sm:h-28 md:w-32 md:h-32 bg-white/15 backdrop-blur-sm rounded-2xl flex items-center justify-center ring-1 ring-white/30 overflow-hidden">
                            <img src="{{ \App\Helpers\StorageHelper::url($product->icon) }}" alt="{{ $product->name }}" class="w-full h-full object-contain p-3 sm:p-4">
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Content -->
    <section class="py-12 sm:py-16 md:py-20 bg-muted">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6 sm:space-y-8">
                    @if($product->description)
                    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-border card-hover">
                        <h2 class="text-xl font-bold text-foreground mb-4 sm:mb-6 flex items-center gap-3">
                            <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            Deskripsi Produk
                        </h2>
                        <div class="prose prose-sm sm:prose-base lg:prose-lg prose-amber max-w-none text-muted-foreground">
                            {!! $product->description !!}
                        </div>
                    </div>
                    @endif

                    @if($product->benefits)
                    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-border card-hover">
                        <h2 class="text-xl font-bold text-foreground mb-4 sm:mb-6 flex items-center gap-3">
                            <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-amber-100 text-amber-600 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            Keunggulan & Manfaat
                        </h2>
                        <div class="prose prose-sm sm:prose-base lg:prose-lg prose-amber max-w-none text-muted-foreground">
                            {!! $product->benefits !!}
                        </div>
                    </div>
                    @endif

                    @if($product->requirements)
                    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-border card-hover">
                        <h2 class="text-xl font-bold text-foreground mb-4 sm:mb-6 flex items-center gap-3">
                            <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-blue-100 text-blue-600 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            </div>
                            Persyaratan
                        </h2>
                        <div class="prose prose-sm sm:prose-base lg:prose-lg prose-amber max-w-none text-muted-foreground">
                            {!! $product->requirements !!}
                        </div>
                    </div>
                    @endif

                    @if($product->procedure)
                    <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-border card-hover">
                        <h2 class="text-xl font-bold text-foreground mb-4 sm:mb-6 flex items-center gap-3">
                            <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-purple-100 text-purple-600 shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                            </div>
                            Prosedur Pengajuan
                        </h2>
                        <div class="prose prose-sm sm:prose-base lg:prose-lg prose-amber max-w-none text-muted-foreground">
                            {!! $product->procedure !!}
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl border border-border p-6 sticky top-24 shadow-sm">
                        <h3 class="text-base font-bold text-foreground mb-4 pb-3 border-b border-border">Informasi Produk</h3>
                        <div class="space-y-3">
                            @if($product->category)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-muted-foreground">Kategori</span>
                                <span class="text-sm font-semibold text-emerald-600">{{ $product->category->name }}</span>
                            </div>
                            @endif
                            @if($product->created_at)
                            <div class="flex items-center justify-between pt-3 border-t border-border">
                                <span class="text-sm text-muted-foreground">Dipublikasikan</span>
                                <span class="text-sm font-medium text-foreground">{{ $product->created_at->format('d M Y') }}</span>
                            </div>
                            @endif
                        </div>

                        <div class="mt-6 pt-4 border-t border-border space-y-3">
                            <a href="{{ route('contact') }}"
                               class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 gradient-primary text-white font-bold rounded-xl hover:shadow-lg hover:shadow-emerald-500/20 transition-all duration-300 btn-press">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                Ajukan Sekarang
                            </a>
                            <a href="{{ route('about.offices') }}"
                               class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-emerald-600 font-bold rounded-xl border-2 border-emerald-100 hover:bg-emerald-50 transition-all duration-300 btn-press">
                                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Kunjungi Kantor
                            </a>
                        </div>
                    </div>

                    @if($product->brochure_file)
                    <div class="bg-white rounded-2xl border border-border p-6 shadow-sm">
                        <h3 class="text-base font-bold text-foreground mb-4">Brosur Produk</h3>
                        <a href="{{ \App\Helpers\StorageHelper::url($product->brochure_file) }}"
                           target="_blank"
                           class="w-full inline-flex items-center justify-center gap-2 px-6 py-3 bg-gradient-to-r from-red-600 to-rose-600 text-white font-bold rounded-xl hover:shadow-lg hover:shadow-red-500/20 transition-all duration-300 btn-press">
                            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            Download Brosur
                        </a>
                    </div>
                    @endif

                    <div class="bg-white rounded-2xl border border-border p-6 shadow-sm">
                        <h3 class="text-base font-bold text-foreground mb-4">Bagikan Produk</h3>
                        <div class="flex gap-2" x-data="{ copied: false }">
                            <a href="https://wa.me/?text={{ urlencode($product->name . ' - ' . url()->current()) }}"
                               target="_blank"
                               class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2.5 bg-green-500 text-white rounded-xl hover:bg-green-600 transition-colors text-sm font-medium btn-press">
                                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                               target="_blank"
                               class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2.5 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors text-sm font-medium btn-press">
                                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                            <button @click.prevent="navigator.clipboard.writeText('{{ url()->current() }}').then(() => { copied = true; setTimeout(() => copied = false, 2000) }).catch(() => { alert('Gagal menyalin link. Silakan salin manual.') })"
                                    class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2.5 bg-emerald-600 text-white rounded-xl hover:bg-emerald-700 transition-colors text-sm font-medium btn-press"
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
    </section>
</x-frontend-layout>
