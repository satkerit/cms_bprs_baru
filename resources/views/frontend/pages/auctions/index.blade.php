<x-frontend-layout>
    <x-slot name="title">Lelang Agunan - {{ config('app.name') }}</x-slot>

    @push('head')
    <!-- SEO Meta Tags -->
    <meta name="description" content="Temukan berbagai lelang agunan terpercaya dengan harga terbaik. Rumah, tanah, ruko, dan properti komersial lainnya.">
    <meta name="keywords" content="lelang agunan, lelang properti, BPRS Babel, auction, property auction, rumah lelang, tanah lelang">
    <meta name="author" content="BPRS Bangka Belitung">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Lelang Agunan - {{ config('app.name') }}">
    <meta property="og:description" content="Temukan berbagai lelang agunan terpercaya dengan harga terbaik. Rumah, tanah, ruko, dan properti komersial lainnya.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    @endpush

    <!-- Hero Section -->
    <section class="relative pt-24 sm:pt-28 md:pt-32 pb-16 sm:pb-20 md:pb-24 overflow-hidden">
        <div class="absolute inset-0 hero-gradient">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.03&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
            <div class="absolute top-20 left-10 w-72 h-72 bg-emerald-400/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-emerald-400/20 rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center mb-8 sm:mb-12">
                <div class="inline-flex items-center px-4 sm:px-6 py-2 sm:py-3 bg-white/15 backdrop-blur-md rounded-full text-xs sm:text-sm font-semibold mb-4 sm:mb-6 border border-white/20">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 sm:mr-3 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span class="text-emerald-700">Lelang Agunan Terpercaya</span>
                </div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl font-bold mb-4 sm:mb-6 tracking-tight text-white px-4">
                    Temukan Agunan <span class="text-emerald-600 animate-pulse">Impian Anda</span>
                </h1>
                <p class="text-base sm:text-lg md:text-xl lg:text-2xl text-emerald-700 mb-6 sm:mb-8 mx-auto px-4">
                    Dapatkan agunan berkualitas dengan harga terbaik melalui lelang resmi dan terpercaya
                </p>

                <!-- Search Form -->
                <div class="max-w-5xl mx-auto px-4">
                    <form method="GET" class="bg-white/95 backdrop-blur-md rounded-lg sm:rounded-lg p-4 sm:p-6 md:p-8 border border-emerald-100 shadow-lg shadow-emerald-500/10">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6">
                            <div class="space-y-1.5 sm:space-y-2 text-left">
                                <label class="block text-xs sm:text-sm font-bold tracking-tight text-foreground">Cari Agunan</label>
                                <input type="text" name="search" value="{{ request('search') }}"
                                       placeholder="Lokasi, jenis agunan..."
                                       class="w-full px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-base border border-border rounded-lg sm:rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-foreground transition-all touch-manipulation">
                            </div>
                            <div class="space-y-1.5 sm:space-y-2 text-left">
                                <label class="block text-xs sm:text-sm font-semibold text-foreground">Jenis Aset</label>
                                <select name="asset_type" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-base border border-border rounded-lg sm:rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-foreground transition-all touch-manipulation">
                                    <option value="">Semua Jenis</option>
                                    @foreach($assetTypes as $value => $label)
                                        <option value="{{ $value }}" {{ request('asset_type') === $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-1.5 sm:space-y-2 text-left">
                                <label class="block text-xs sm:text-sm font-semibold text-foreground">Kota</label>
                                <select name="city" class="w-full px-3 sm:px-4 py-2.5 sm:py-3 text-xs sm:text-base border border-border rounded-lg sm:rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent text-foreground transition-all touch-manipulation">
                                    <option value="">Semua Kota</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city }}" {{ request('city') === $city ? 'selected' : '' }}>
                                            {{ $city }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="space-y-1.5 sm:space-y-2">
                                <label class="block text-xs sm:text-sm font-semibold text-secondary">&nbsp;</label>
                                <button type="submit" class="w-full min-h-[44px] bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-bold py-2.5 sm:py-3 px-4 sm:px-6 rounded-lg sm:rounded-lg text-xs sm:text-base transition-all duration-300 transform hover:scale-105 hover:shadow-md tracking-tight touch-manipulation active:scale-95 flex items-center justify-center gap-1.5 sm:gap-2">
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                    Cari Lelang
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12 md:py-16 bg-muted/50" x-data="{ showFilters: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @php
                $featuredCount = isset($featuredAuctions) ? $featuredAuctions->count() : 0;
                $upcomingCount = isset($upcomingAuctions) ? $upcomingAuctions->count() : 0;
                $hasSidebar = $featuredCount > 0 || $upcomingCount > 0;
            @endphp
            <div class="flex flex-col {{ $hasSidebar ? 'lg:flex-row' : '' }} gap-8">
                <!-- Main Content -->
                <div class="{{ $hasSidebar ? 'lg:w-3/4' : 'w-full' }}">
                    <!-- Advanced Filters -->
                    <div class="bg-white rounded-lg shadow-sm p-6 md:p-8 mb-8 border border-border">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-bold text-foreground flex items-center gap-3">
                                <span class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"/>
                                    </svg>
                                </span>
                                Filter Lanjutan
                            </h3>
                            <button @click="showFilters = !showFilters" class="text-emerald-600 hover:text-emerald-600 font-medium text-sm">
                                <span x-text="showFilters ? 'Sembunyikan' : 'Tampilkan'">Tampilkan</span>
                                <svg class="w-4 h-4 inline ml-1 transform transition-transform" :class="showFilters ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                        </div>

                        <div x-show="showFilters" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" id="advanced-filters">
                            <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <input type="hidden" name="asset_type" value="{{ request('asset_type') }}">
                                <input type="hidden" name="city" value="{{ request('city') }}">

                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-foreground">Harga Minimum</label>
                                    <input type="number" name="min_price" value="{{ request('min_price') }}"
                                           placeholder="0" class="w-full px-4 py-3 border border-border rounded-lg focus:ring-2 focus:ring-emerald-500 transition-all">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-foreground">Harga Maksimum</label>
                                    <input type="number" name="max_price" value="{{ request('max_price') }}"
                                           placeholder="Unlimited" class="w-full px-4 py-3 border border-border rounded-lg focus:ring-2 focus:ring-emerald-500 transition-all">
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-foreground">Status Lelang</label>
                                    <select name="status" class="w-full px-4 py-3 border border-border rounded-lg focus:ring-2 focus:ring-emerald-500 transition-all">
                                        <option value="">Semua Status</option>
                                        <option value="registration_open" {{ request('status') === 'registration_open' ? 'selected' : '' }}>Pendaftaran Dibuka</option>
                                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Dipublikasi</option>
                                        <option value="auction_scheduled" {{ request('status') === 'auction_scheduled' ? 'selected' : '' }}>Terjadwal</option>
                                    </select>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-foreground">Urutkan Berdasarkan</label>
                                    <select name="sort_by" class="w-full px-4 py-3 border border-border rounded-lg focus:ring-2 focus:ring-emerald-500 transition-all">
                                        <option value="date" {{ request('sort_by') === 'date' ? 'selected' : '' }}>Tanggal Lelang</option>
                                        <option value="price" {{ request('sort_by') === 'price' ? 'selected' : '' }}>Harga</option>
                                        <option value="featured" {{ request('sort_by') === 'featured' ? 'selected' : '' }}>Featured</option>
                                    </select>
                                </div>
                                <div class="md:col-span-2 lg:col-span-4 flex gap-4">
                                    <button type="submit" class="flex-1 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105">
                                        Terapkan Filter
                                    </button>
                                    <a href="{{ route('auctions.index') }}" class="flex-1 bg-muted hover:bg-muted/80 text-secondary font-bold py-3 px-6 rounded-lg transition-all duration-300 text-center">
                                        Reset Filter
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Results Info & Sort -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                        <div class="text-secondary">
                            <span class="font-semibold text-foreground">{{ $auctions->total() }}</span> lelang ditemukan
                            @if(request()->hasAny(['search', 'asset_type', 'city', 'min_price', 'max_price', 'status']))
                            <span class="text-sm text-emerald-600 ml-2">
                                    (dengan filter aktif)
                                </span>
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-secondary">Urutan:</span>
                            <a href="{{ route('auctions.index', array_merge(request()->query(), ['sort_order' => 'asc'])) }}"
                               class="px-3 py-2 text-sm border rounded-lg transition-all {{ request('sort_order') === 'asc' ? 'bg-emerald-50 border-emerald-100 text-emerald-600' : 'border-border hover:border-emerald-100' }}">
                                Ascending
                            </a>
                            <a href="{{ route('auctions.index', array_merge(request()->query(), ['sort_order' => 'desc'])) }}"
                               class="px-3 py-2 text-sm border rounded-lg transition-all {{ request('sort_order') === 'desc' ? 'bg-emerald-50 border-emerald-100 text-emerald-600' : 'border-border hover:border-emerald-100' }}">
                                Descending
                            </a>
                        </div>
                    </div>

                    <!-- Auction Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 lg:gap-8">
                        @forelse($auctions as $auction)
                            <div class="bg-white rounded-xl border border-border shadow-sm overflow-hidden transition-all duration-500 hover:-translate-y-2 hover:shadow-xl group" data-intersect>
                                <!-- Image -->
                                <div class="relative aspect-[4/3] overflow-hidden">
                                    @if($auction->main_image)
                                        <x-optimized-image
                                            src="{{ $auction->main_image }}"
                                            alt="{{ $auction->title }}"
                                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                            :lazy="true"
                                            aspect-ratio="4/3"
                                        />
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-emerald-50 via-emerald-100 to-emerald-200 flex items-center justify-center">
                                            <div class="text-center">
                                                <svg class="h-16 w-16 text-emerald-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                </svg>
                                                <p class="text-emerald-600 font-medium text-sm">{{ $auction->asset_type_label }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Badges -->
                                    <div class="absolute top-4 left-4 flex flex-col space-y-2">
                                        @if($auction->is_featured)
                                            <span class="bg-gradient-to-r from-amber-400 to-orange-500 text-white px-3 py-1 rounded-full text-sm font-bold animate-pulse">
                                                ⭐ Featured
                                            </span>
                                        @endif
                                        @if($auction->is_urgent)
                                            <span class="bg-gradient-to-r from-red-500 to-pink-600 text-white px-3 py-1 rounded-full text-sm font-bold animate-pulse">
                                                🔥 Urgent
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Sold Watermark -->
                                    @if($auction->status === 'sold')
                                    <div class="absolute inset-0 flex items-center justify-center bg-black/30 z-20 pointer-events-none">
                                        <div class="transform -rotate-12 bg-red-600/90 text-white px-10 py-3 text-3xl md:text-3xl font-black tracking-widest border-4 border-white uppercase backdrop-blur-sm">
                                            TERJUAL
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Status -->
                                    <div class="absolute top-4 right-4">
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold backdrop-blur-sm text-white
                                        @if($auction->status === 'registration_open') bg-gradient-to-r from-emerald-600 to-emerald-700
                                        @elseif($auction->status === 'auction_scheduled') bg-gradient-to-r from-sky-500 to-sky-400
                                        @elseif($auction->status === 'sold') bg-gradient-to-r from-red-500 to-red-400
                                        @else bg-gradient-to-r from-gray-600 to-gray-500 @endif">
                                            <span class="w-2 h-2 bg-white rounded-full mr-2 opacity-75"></span>
                                            {{ $auction->status_label }}
                                        </span>
                                    </div>

                                    <!-- Quick Actions -->
                                    <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('auctions.show', $auction) }}"
                                               class="w-10 h-10 bg-white/90 hover:bg-white rounded-full flex items-center justify-center transition-all hover:scale-110"
                                               title="Lihat Detail">
                                                <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="p-6">
                                    <div class="mb-3">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-emerald-50 text-emerald-600">
                                            {{ $auction->asset_type_label }}
                                        </span>
                                    </div>

                                    <h3 class="text-xl font-bold text-foreground mb-3 line-clamp-2 group-hover:text-emerald-600 transition-colors">
                                        <a href="{{ route('auctions.show', $auction) }}">
                                            {{ $auction->title }}
                                        </a>
                                    </h3>

                                    <div class="flex items-center text-sm text-secondary mb-4">
                                        <svg class="h-4 w-4 mr-2 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        {{ $auction->city ?? 'Lokasi tidak tersedia' }}
                                    </div>

                                    <!-- Price -->
                                    <div class="mb-4">
                                        <div class="text-3xl font-bold bg-gradient-to-r from-emerald-600 to-emerald-700 bg-clip-text text-transparent">{{ $auction->formatted_limit_price }}</div>
                                        @if($auction->estimated_price)
                                            <div class="text-sm text-secondary">Estimasi: {{ $auction->formatted_estimated_price }}</div>
                                        @endif
                                    </div>

                                    <!-- Auction Info -->
                                    <div class="space-y-2 mb-4">
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-secondary flex items-center">
                                                <svg class="h-4 w-4 mr-1 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                Tanggal Lelang
                                            </span>
                                            <span class="font-semibold text-foreground">
                                                @if($auction->auction_date)
                                                    {{ $auction->auction_date->format('d M Y') }}
                                                @else
                                                    Belum ditentukan
                                                @endif
                                            </span>
                                        </div>
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-secondary flex items-center">
                                                <svg class="h-4 w-4 mr-1 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                Waktu
                                            </span>
                                            <span class="font-semibold text-foreground">
                                                @if($auction->auction_date)
                                                    {{ $auction->auction_date->format('H:i') }} WIB
                                                @else
                                                    -
                                                @endif
                                            </span>
                                        </div>
                                    </div>

                                    @if($auction->days_until_auction >= 0 && $auction->auction_date)
                                        <div class="text-center mb-4" data-end-time="{{ $auction->auction_date->toISOString() }}">
                                            {{ $auction->time_until_auction }}
                                        </div>
                                    @endif

                                    <!-- Action Button -->
                                    <a href="{{ route('auctions.show', $auction) }}"
                                       class="block w-full bg-gradient-to-r from-emerald-600 to-emerald-700 text-white text-center font-semibold py-3 px-4 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-md">
                                        Lihat Detail Lelang
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full">
                                <div class="text-center py-16 bg-white rounded-lg">
                                    <div class="w-24 h-24 bg-muted rounded-full flex items-center justify-center mx-auto mb-6">
                                        <svg class="w-12 h-12 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl font-bold text-foreground mb-2">Tidak ada lelang ditemukan</h3>
                                    <p class="text-secondary mb-6">Belum ada lelang yang sesuai dengan kriteria pencarian Anda.</p>
                                    <a href="{{ route('auctions.index') }}" class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition-all">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                        Reset Pencarian
                                    </a>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($auctions->hasPages())
                        <div class="mt-12">
                            <div class="bg-white rounded-lg p-6">
                                {{ $auctions->links() }}
                            </div>
                        </div>
                    @endif
                </div>

                @if($hasSidebar)
                <!-- Sidebar -->
                <div class="lg:w-1/4 space-y-8">
                    <!-- Featured Auctions -->
                    @if($featuredCount > 0)
                        <div class="bg-white rounded-lg p-6 border border-border">
                            <h3 class="text-xl font-bold text-foreground mb-6 flex items-center gap-3">
                                <span class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.54 1.118l-3.976-2.888a1 1 0 00-1.175 0l-3.976 2.888c-.784.57-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                    </svg>
                                </span>
                                Lelang Unggulan
                            </h3>
                            <div class="space-y-4">
                                @foreach($featuredAuctions as $featured)
                                    <div class="group border-b border-border pb-4 last:border-b-0 last:pb-0">
                                        <div class="flex gap-3">
                                            @if($featured->main_image)
                                                <x-optimized-image
                                                    src="{{ $featured->main_image }}"
                                                    alt="{{ $featured->title }}"
                                                    class="w-16 h-16 object-cover rounded-lg shrink-0"
                                                    :lazy="true"
                                                    width="64"
                                                    height="64"
                                                />
                                            @else
                                                <div class="w-16 h-16 bg-gradient-to-br from-emerald-50 to-emerald-50 rounded-lg flex items-center justify-center shrink-0">
                                                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="flex-1 min-w-0">
                                                <h4 class="font-semibold text-foreground mb-1 group-hover:text-emerald-600 transition-colors line-clamp-2">
                                                    <a href="{{ route('auctions.show', $featured) }}">
                                                        {{ $featured->title }}
                                                    </a>
                                                </h4>
                                                <div class="text-sm text-secondary mb-2 flex items-center">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    </svg>
                                                    {{ $featured->city }}
                                                </div>
                                                <div class="text-sm font-bold text-emerald-600">{{ $featured->formatted_limit_price }}</div>
                                                <div class="text-sm text-secondary mt-1">
                                                    @if($featured->auction_date)
                                                        {{ $featured->auction_date->format('d M Y') }}
                                                    @else
                                                        Belum ditentukan
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Upcoming Auctions -->
                    @if($upcomingCount > 0)
                        <div class="bg-white rounded-lg p-6 border border-border">
                            <h3 class="text-xl font-bold text-foreground mb-6 flex items-center gap-3">
                                <span class="w-8 h-8 bg-emerald-50 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </span>
                                Lelang Mendatang
                            </h3>
                            <div class="space-y-4">
                                @foreach($upcomingAuctions as $upcoming)
                                    <div class="group border-b border-border pb-4 last:border-b-0 last:pb-0">
                                        <div class="flex gap-3">
                                            @if($upcoming->main_image)
                                                <x-optimized-image
                                                    src="{{ $upcoming->main_image }}"
                                                    alt="{{ $upcoming->title }}"
                                                    class="w-16 h-16 object-cover rounded-lg shrink-0"
                                                    :lazy="true"
                                                    width="64"
                                                    height="64"
                                                />
                                            @else
                                                <div class="w-16 h-16 bg-gradient-to-br from-emerald-50 to-emerald-50 rounded-lg flex items-center justify-center shrink-0">
                                                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="flex-1 min-w-0">
                                                <h4 class="font-semibold text-foreground mb-1 group-hover:text-emerald-600 transition-colors line-clamp-2">
                                                    <a href="{{ route('auctions.show', $upcoming) }}">
                                                        {{ $upcoming->title }}
                                                    </a>
                                                </h4>
                                                <div class="text-sm text-secondary mb-2 flex items-center">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    </svg>
                                                    {{ $upcoming->city }}
                                                </div>
                                                <div class="text-sm font-bold text-emerald-600">{{ $upcoming->formatted_limit_price }}</div>
                                                <div class="text-sm text-secondary mt-1">
                                                    @if($upcoming->auction_date)
                                                        {{ $upcoming->auction_date->format('d M Y') }}
                                                    @else
                                                        Belum ditentukan
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </section>

    @push('scripts')
    <script nonce="{{ $nonce }}">
        // Filter logic moved to Alpine.js
    </script>
    @endpush
</x-frontend-layout>
