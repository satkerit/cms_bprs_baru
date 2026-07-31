<x-frontend-layout>
    <x-slot name="title">{{ $auction->title }} - Lelang Agunan</x-slot>

    @push('head')
    <meta name="description" content="{{ Str::limit(strip_tags($auction->description), 160) }}">
    <meta property="og:title" content="{{ $auction->title }} - Lelang Agunan">
    <meta property="og:description" content="{{ Str::limit(strip_tags($auction->description), 160) }}">
    @if($auction->main_image)
    <meta property="og:image" content="{{ \App\Helpers\StorageHelper::url($auction->main_image) }}">
    @endif
    @endpush

    <!-- Hero / Banner -->
    <section class="relative pt-8 sm:pt-10 md:pt-12 pb-16 sm:pb-20 overflow-hidden">
        <div class="absolute inset-0 hero-gradient">
            <div class="absolute inset-0 bg-grid-pattern opacity-50"></div>
            <div class="absolute top-20 left-10 w-72 h-72 bg-emerald-400/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-emerald-400/20 rounded-full blur-3xl"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                <a href="{{ route('auctions.index') }}" class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 bg-white/20 backdrop-blur-md rounded-full text-white text-xs sm:text-sm font-medium hover:bg-white/30 transition-all duration-200">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Kembali
                </a>
                <span class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 bg-white/20 backdrop-blur-md rounded-full text-white text-xs sm:text-sm font-medium">
                    <svg class="w-3 h-3 sm:w-4 sm:h-4 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    {{ $auction->asset_type_label }}
                </span>
                @if($auction->is_featured)
                <span class="inline-flex items-center px-3 sm:px-4 py-1.5 sm:py-2 bg-gradient-to-r from-amber-400 to-orange-500 text-white text-xs sm:text-sm font-bold rounded-full">⭐ Featured</span>
                @endif
            </div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl xl:text-5xl font-bold text-white mb-4 sm:mb-6 tracking-tight drop-shadow-sm">{{ $auction->title }}</h1>
            <div class="flex flex-wrap items-center gap-3 sm:gap-6 text-white/80">
                <div class="flex items-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span class="text-sm sm:text-base font-medium">{{ $auction->city ?? 'Lokasi tidak tersedia' }}</span>
                </div>
                @if($auction->auction_date)
                <div class="flex items-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1.5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span class="text-sm sm:text-base font-medium">{{ $auction->auction_date->format('l, d F Y - H:i') }} WIB</span>
                </div>
                @endif
            </div>
        </div>
    </section>

    <section class="py-8 md:py-12 bg-muted/50 -mt-10 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6 lg:space-y-8">
                    <!-- Image Gallery -->
                    @php
                        $allImages = collect((array)($auction->images ?? []));
                        $mainImage = $auction->main_image;
                    @endphp
                    <div class="bg-white dark:bg-slate-900 rounded-lg sm:rounded-lg shadow-sm overflow-hidden border border-border" x-data="{ activeImage: 0 }">
                        <div class="relative bg-muted aspect-[16/9] flex items-center justify-center overflow-hidden">
                            @if($mainImage)
                                <img src="{{ \App\Helpers\StorageHelper::url($mainImage) }}" alt="{{ $auction->title }}" class="w-full h-full object-contain p-4 transition-opacity duration-500" x-show="activeImage === 0">
                            @endif
                            @foreach($allImages as $idx => $img)
                                @if(is_string($img) && $img !== $mainImage)
                                <img src="{{ \App\Helpers\StorageHelper::url($img) }}" alt="{{ $auction->title }} - Gambar {{ $idx + 1 }}" class="w-full h-full object-contain p-4 transition-opacity duration-500" x-show="activeImage === {{ $idx + 1 }}" x-cloak>
                                @endif
                            @endforeach
                            @if(!$mainImage && $allImages->isEmpty())
                                <div class="text-center p-8 sm:p-16">
                                    <svg class="mx-auto h-20 w-20 sm:h-32 sm:w-32 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <p class="mt-2 sm:mt-4 text-sm sm:text-base text-secondary">Belum ada gambar</p>
                                </div>
                            @endif
                            @if($auction->status === 'sold')
                            <div class="absolute inset-0 flex items-center justify-center bg-black/30 z-20 pointer-events-none">
                                <div class="transform -rotate-12 bg-red-600/90 text-white px-8 sm:px-12 py-3 sm:py-4 text-2xl sm:text-4xl font-black tracking-widest border-4 border-white uppercase backdrop-blur-sm">TERJUAL</div>
                            </div>
                            @endif
                        </div>
                        @if($mainImage || $allImages->isNotEmpty())
                        <div class="p-3 sm:p-4 border-t border-border">
                            <div class="grid grid-cols-6 sm:grid-cols-8 gap-2 sm:gap-3">
                                @if($mainImage)
                                <button @click="activeImage = 0" :class="activeImage === 0 ? 'ring-2 ring-emerald-500 ring-offset-2' : 'opacity-60 hover:opacity-100'" class="aspect-square rounded-lg sm:rounded-lg overflow-hidden border-2 border-transparent transition-all duration-200 focus:outline-none touch-manipulation">
                                    <img src="{{ \App\Helpers\StorageHelper::url($mainImage) }}" alt="Main" class="w-full h-full object-cover">
                                </button>
                                @endif
                                @foreach($allImages as $idx => $img)
                                    @if(is_string($img) && $img !== $mainImage)
                                    <button @click="activeImage = {{ $idx + 1 }}" :class="activeImage === {{ $idx + 1 }} ? 'ring-2 ring-emerald-500 ring-offset-2' : 'opacity-60 hover:opacity-100'" class="aspect-square rounded-lg sm:rounded-lg overflow-hidden border-2 border-transparent transition-all duration-200 focus:outline-none touch-manipulation">
                                        <img src="{{ \App\Helpers\StorageHelper::url($img) }}" alt="Thumb {{ $idx + 1 }}" class="w-full h-full object-cover">
                                    </button>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Description -->
                    <div class="bg-white dark:bg-slate-900 rounded-lg sm:rounded-lg p-4 sm:p-6 md:p-8 shadow-sm border border-border">
                        <h2 class="text-xl sm:text-2xl font-bold text-foreground dark:text-slate-100 mb-4 sm:mb-6 flex items-center gap-3">
                            <span class="w-8 h-8 bg-emerald-50 dark:bg-emerald-900/50 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </span>
                            Deskripsi Agunan
                        </h2>
                        <div class="text-secondary leading-relaxed">
                            {!! nl2br(e($auction->description)) !!}
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="bg-white dark:bg-slate-900 rounded-lg sm:rounded-lg p-4 sm:p-6 md:p-8 shadow-sm border border-border">
                        <h2 class="text-xl sm:text-2xl font-bold text-foreground dark:text-slate-100 mb-4 sm:mb-6 flex items-center gap-3">
                            <span class="w-8 h-8 bg-emerald-50 dark:bg-emerald-900/50 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </span>
                            Lokasi
                        </h2>
                        <div class="space-y-2 text-secondary">
                            @if($auction->address)<p class="leading-relaxed"><span class="font-semibold text-foreground">Alamat:</span> {{ $auction->address }}</p>@endif
                            @if($auction->city)<p><span class="font-semibold text-foreground">Kota:</span> {{ $auction->city }}</p>@endif
                        </div>
                    </div>

                    <!-- Documents -->
                    @php
                        $docs = collect((array)($auction->documents ?? []));
                    @endphp
                    @if($docs->isNotEmpty())
                    <div class="bg-white dark:bg-slate-900 rounded-lg sm:rounded-lg p-4 sm:p-6 md:p-8 shadow-sm border border-border">
                        <h2 class="text-xl sm:text-2xl font-bold text-foreground dark:text-slate-100 mb-4 sm:mb-6 flex items-center gap-3">
                            <span class="w-8 h-8 bg-emerald-50 dark:bg-emerald-900/50 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </span>
                            Dokumen
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            @foreach($docs as $doc)
                            @php $doc = (object) $doc; @endphp
                            <a href="{{ \App\Helpers\StorageHelper::url($doc->file_path ?? '') }}" target="_blank" class="flex items-center p-3 sm:p-4 bg-muted rounded-lg sm:rounded-lg hover:bg-emerald-50 transition-colors border border-border hover:border-emerald-100 group touch-manipulation active:scale-95">
                                <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center mr-3 shrink-0 group-hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="font-medium text-foreground truncate text-sm sm:text-base">{{ $doc->original_name ?? 'Dokumen' }}</p>
                                    <p class="text-sm text-secondary">{{ $doc->human_file_size ?? '' }}</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Registration -->
                    @if($auction->status === 'registration_open')
                    <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-lg sm:rounded-lg p-6 sm:p-8 text-white shadow-emerald-500/30">
                        <h2 class="text-2xl sm:text-2xl font-bold mb-4">Daftar Lelang</h2>
                        <p class="text-white/80 mb-6 leading-relaxed">Daftarkan diri Anda untuk mengikuti lelang agunan ini. Proses pendaftaran mudah dan cepat.</p>
                        <livewire:frontend.auction.registration-form :auction="$auction" />
                    </div>
                    @endif

                    <!-- Related Auctions -->
                    @if($relatedAuctions->isNotEmpty())
                    <div class="bg-white dark:bg-slate-900 rounded-lg sm:rounded-lg p-4 sm:p-6 md:p-8 shadow-sm border border-border">
                        <h2 class="text-xl sm:text-2xl font-bold text-foreground dark:text-slate-100 mb-4 sm:mb-6 flex items-center gap-3">
                            <span class="w-8 h-8 bg-emerald-50 dark:bg-emerald-900/50 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            </span>
                            Lelang Terkait
                        </h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($relatedAuctions as $related)
                            <a href="{{ route('auctions.show', $related->slug) }}" class="flex items-start gap-3 p-3 rounded-lg hover:bg-emerald-50 transition-colors border border-border hover:border-emerald-100 no-underline">
                                <div class="w-16 h-16 rounded-lg overflow-hidden bg-muted shrink-0">
                                    @if($related->main_image)
                                    <img src="{{ \App\Helpers\StorageHelper::url($related->main_image) }}" alt="{{ $related->title }}" class="w-full h-full object-cover">
                                    @else
                                    <div class="w-full h-full bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    </div>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-semibold text-foreground mb-1 line-clamp-2 leading-tight">{{ $related->title }}</p>
                                    <div class="flex items-center gap-2 text-xs text-secondary">
                                        <span>{{ $related->city ?? 'N/A' }}</span>
                                        <span>•</span>
                                        <span class="font-semibold">{{ $related->formatted_limit_price }}</span>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Organizer Auctions -->
                    @if($organizerAuctions->isNotEmpty())
                    <div class="bg-white dark:bg-slate-900 rounded-lg sm:rounded-lg p-4 sm:p-6 md:p-8 shadow-sm border border-border">
                        <h2 class="text-xl sm:text-2xl font-bold text-foreground dark:text-slate-100 mb-4 sm:mb-6 flex items-center gap-3">
                            <span class="w-8 h-8 bg-emerald-50 dark:bg-emerald-900/50 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </span>
                            Lelang Lainnya dari {{ $auction->organizer_name ?? 'Penyelenggara' }}
                        </h2>
                        <div class="space-y-3">
                            @foreach($organizerAuctions as $orgAuction)
                            <a href="{{ route('auctions.show', $orgAuction->slug) }}" class="flex items-start gap-3 p-2 sm:p-3 -mx-2 sm:-mx-3 rounded-lg hover:bg-emerald-50 transition-colors no-underline">
                                <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-lg overflow-hidden bg-muted shrink-0">
                                    @if($orgAuction->main_image)
                                    <img src="{{ \App\Helpers\StorageHelper::url($orgAuction->main_image) }}" alt="{{ $orgAuction->title }}" class="w-full h-full object-cover">
                                    @else
                                    <div class="w-full h-full bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    </div>
                                    @endif
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="text-sm font-semibold text-foreground mb-1 line-clamp-2 leading-tight">{{ $orgAuction->title }}</p>
                                    <div class="flex items-center gap-2 text-xs text-secondary">
                                        <span>{{ $orgAuction->city ?? 'N/A' }}</span>
                                        <span>•</span>
                                        <span class="font-semibold">{{ $orgAuction->formatted_limit_price }}</span>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                <!-- End Main Content Column -->

                <!-- Sidebar -->
                <div class="space-y-6 lg:space-y-8">
                    <!-- Price Card -->
                    <div class="bg-white dark:bg-slate-900 rounded-lg sm:rounded-lg p-6 sm:p-8 shadow-sm border border-border hover:shadow-sm transition-shadow duration-300 sticky top-24">
                        <div class="text-sm text-secondary mb-2 font-medium">Harga Limit</div>
                        <div class="text-3xl sm:text-4xl font-black bg-gradient-to-r from-emerald-600 to-emerald-700 bg-clip-text text-transparent mb-6">{{ $auction->formatted_limit_price }}</div>

                        @if($auction->estimated_price)
                        <div class="mb-6 p-4 bg-muted rounded-lg border border-border">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-secondary">Estimasi</span>
                                <span class="font-bold text-foreground">{{ $auction->formatted_estimated_price }}</span>
                            </div>
                        </div>
                        @endif

                        <!-- Status Info -->
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between items-center py-2 border-b border-border last:border-b-0">
                                <span class="text-sm text-secondary">Status</span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold backdrop-blur-sm text-white
                                    @if($auction->status === 'registration_open') bg-gradient-to-r from-emerald-600 to-emerald-700
                                    @elseif($auction->status === 'auction_scheduled') bg-gradient-to-r from-sky-500 to-sky-400
                                    @elseif($auction->status === 'sold') bg-gradient-to-r from-red-500 to-red-400
                                    @else bg-gradient-to-r from-gray-600 to-gray-500 @endif">
                                    <span class="w-1.5 h-1.5 bg-white rounded-full mr-1.5 opacity-75"></span>
                                    {{ $auction->status_label }}
                                </span>
                            </div>
                            @if($auction->auction_date)
                            <div class="flex justify-between items-center py-2 border-b border-border last:border-b-0">
                                <span class="text-sm text-secondary">Tanggal Lelang</span>
                                <span class="text-sm font-semibold text-foreground">{{ $auction->auction_date->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-border last:border-b-0">
                                <span class="text-sm text-secondary">Waktu</span>
                                <span class="text-sm font-semibold text-foreground">{{ $auction->auction_date->format('H:i') }} WIB</span>
                            </div>
                            @endif
                            @if($auction->registration_end)
                            <div class="flex justify-between items-center py-2 border-b border-border last:border-b-0">
                                <span class="text-sm text-secondary">Tutup Pendaftaran</span>
                                <span class="text-sm font-semibold text-foreground">{{ $auction->registration_end->format('d M Y') }}</span>
                            </div>
                            @endif
                            @if($auction->total_bidders !== null)
                            <div class="flex justify-between items-center py-2 border-b border-border last:border-b-0">
                                <span class="text-sm text-secondary">Peserta</span>
                                <span class="text-sm font-semibold text-foreground">{{ $auction->total_bidders }} orang</span>
                            </div>
                            @endif
                            @if($auction->view_count !== null)
                            <div class="flex justify-between items-center py-2 border-b border-border last:border-b-0">
                                <span class="text-sm text-secondary">Dilihat</span>
                                <span class="text-sm font-semibold text-foreground">{{ $auction->view_count }} kali</span>
                            </div>
                            @endif
                        </div>

                        @if($auction->days_until_auction >= 0 && $auction->auction_date)
                        <div class="mb-6 p-4 bg-muted rounded-lg text-center border border-border" x-data="{ timer: null }" x-init="timer = createTimer('{{ $auction->auction_date->toISOString() }}')">
                            <div class="text-xs text-secondary mb-1">Waktu tersisa</div>
                            <div class="text-2xl font-black text-emerald-600 font-mono" x-text="timer"></div>
                        </div>
                        @endif

                        <a href="{{ route('auctions.index') }}" class="block w-full bg-gradient-to-r from-emerald-600 to-emerald-700 text-white text-center font-semibold py-3 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-md">
                            Kembali ke Lelang
                        </a>
                    </div>

                </div>
                <!-- End Sidebar -->
            </div>
        </div>
    </section>

    @push('scripts')
    <script nonce="{{ $nonce }}">
        function createTimer(isoString) {
            const end = new Date(isoString).getTime();
            return () => {
                const now = new Date().getTime();
                const diff = Math.max(0, end - now);
                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((diff % (1000 * 60)) / 1000);
                return `${days}h ${hours}j ${minutes}m ${seconds}d`;
            };
        }
        document.addEventListener('alpine:init', () => {
            Alpine.bind('timer', () => ({
                init() {
                    const fn = createTimer(this.$el.dataset.endTime);
                    this.$el.textContent = fn();
                    setInterval(() => { this.$el.textContent = fn(); }, 1000);
                }
            }));
        });
    </script>
    @endpush
</x-frontend-layout>
