<x-frontend-layout>
    <x-slot name="title">Produk & Layanan - BPRS Bangka Belitung</x-slot>
    <x-slot name="meta_description">Produk pembiayaan syariah, simpanan, dan layanan perbankan dari BPRS Bangka Belitung yang sesuai dengan prinsip syariah.</x-slot>

    <!-- Hero -->
    <section class="relative pt-24 sm:pt-28 md:pt-32 pb-12 sm:pb-16 md:pb-20 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 via-emerald-500 to-emerald-600">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.03&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-2xl font-bold sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4 sm:mb-6 tracking-tight">Produk & Layanan</h1>
            <p class="text-sm sm:text-lg md:text-xl text-white/80 mx-auto px-4">Solusi perbankan syariah yang sesuai dengan kebutuhan Anda.</p>
        </div>
    </section>

    <!-- Products Section -->
    <section class="py-12 sm:py-16 md:py-20 bg-muted/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($categories->count() > 0)
                <div class="flex flex-wrap justify-center gap-2 sm:gap-3 mb-8 sm:mb-12 px-4" x-data="{ activeCategory: '{{ request('category', 'all') }}' }">
                    <a href="{{ route('products.index') }}"
                       @click="activeCategory = 'all'"
                       class="px-4 sm:px-6 py-2 sm:py-2.5 text-xs sm:text-sm font-bold rounded-lg sm:rounded-lg transition-all duration-300 {{ !request('category') ? 'bg-emerald-600 text-white shadow-emerald-500/30 ring-2 ring-emerald-600 ring-offset-2' : 'bg-card text-muted-foreground hover:bg-muted hover:text-emerald-600 border border-border' }}">
                        Semua
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                           @click="activeCategory = '{{ $category->slug }}'"
                           class="px-4 sm:px-6 py-2 sm:py-2.5 text-xs sm:text-sm font-bold rounded-lg sm:rounded-lg transition-all duration-300 btn-press {{ request('category') == $category->slug ? 'bg-emerald-600 text-white shadow-emerald-500/30 ring-2 ring-emerald-600 ring-offset-2' : 'bg-card text-muted-foreground hover:bg-muted hover:text-emerald-600 border border-border' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            @endif

            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 md:gap-8">
                    @foreach($products as $product)
                        <div class="group bg-card rounded-lg sm:rounded-lg shadow-gray-200/50 border border-border card-hover overflow-hidden flex flex-col h-full touch-manipulation">
                            <div class="relative h-44 sm:h-52 md:h-56 overflow-hidden bg-muted aspect-[4/3]">
                                @if($product->icon)
                                    <img src="{{ \App\Helpers\StorageHelper::url($product->icon) }}"
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                         loading="{{ $loop->first ? 'eager' : 'lazy' }}">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-emerald-50 via-emerald-50 to-emerald-50 flex items-center justify-center">
                                        <svg class="w-20 h-20 text-emerald-600 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                        </svg>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <div class="absolute top-3 left-3 sm:top-4 sm:left-4">
                                    @if($product->category)
                                        <span class="px-2.5 py-1 sm:px-3 text-xs sm:text-sm font-bold rounded-full bg-white/90 backdrop-blur-sm text-emerald-600 border border-white/50 shadow-sm">
                                            {{ $product->category->name }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="p-4 sm:p-5 md:p-6 flex flex-col flex-1">
                            <h3 class="text-base sm:text-lg md:text-xl font-bold text-foreground mb-2 group-hover:text-emerald-600 transition-colors leading-snug">
                                <a href="{{ route('products.show', $product->slug) }}" class="touch-manipulation">
                                    {{ $product->name }}
                                </a>
                            </h3>

                                @if($product->short_description)
                                    <p class="text-sm sm:text-base text-muted-foreground mb-4 line-clamp-2 leading-relaxed flex-1">{{ $product->short_description }}</p>
                                @endif

                                <div class="pt-3 sm:pt-4 border-t border-border flex items-center justify-between">
                                    <a href="{{ route('products.show', $product->slug) }}" class="inline-flex items-center gap-1.5 sm:gap-2 text-emerald-600 font-bold text-sm sm:text-base group/link hover:text-emerald-700 min-h-[44px] sm:min-h-0 -my-2 sm:my-0 touch-manipulation btn-press">
                                        Selengkapnya
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 group-hover/link:translate-x-1 transition-transform shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-16 sm:py-20 bg-card rounded-lg border border-border">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 bg-muted rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
                        <svg class="w-10 h-10 sm:w-12 sm:h-12 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold text-foreground mb-2">Belum Ada Produk</h3>
                    <p class="text-sm sm:text-base text-muted-foreground">Produk untuk kategori ini belum tersedia. Silakan cek kategori lain.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-14 sm:py-18 md:py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl font-bold sm:text-3xl md:text-4xl font-bold text-gray-900 mb-4 sm:mb-6">Butuh Informasi Lebih Lanjut?</h2>                            <p class="text-sm sm:text-lg text-muted-foreground mb-6 sm:mb-8">Konsultasikan kebutuhan perbankan syariah Anda dengan tim marketing kami.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-3 sm:gap-4">
                <a href="{{ route('about.offices') }}" class="inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-bold rounded-lg sm:rounded-lg hover:shadow-md hover:shadow-emerald-500/30 transition-all duration-300 min-h-[48px] touch-manipulation btn-press">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Kunjungi Kantor
                </a>
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center px-6 sm:px-8 py-3 sm:py-4 border-2 border-emerald-600 text-emerald-600 font-bold rounded-lg sm:rounded-lg hover:bg-emerald-50 transition-all duration-300 min-h-[48px] touch-manipulation btn-press">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>
</x-frontend-layout>
