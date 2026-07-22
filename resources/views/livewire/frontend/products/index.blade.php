<div>
    <!-- Hero Section -->
    <section class="relative pt-24 sm:pt-28 md:pt-32 pb-16 sm:pb-20 md:pb-24 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-600 via-emerald-500 to-emerald-700">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.05\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
            <div class="absolute top-20 left-10 w-72 h-72 bg-emerald-500/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-emerald-100 rounded-full blur-3xl"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-md rounded-full text-white text-xs sm:text-sm font-semibold mb-6 border border-white/20">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                Produk & Layanan
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4 tracking-tight">Produk & Layanan</h1>
            <p class="text-base sm:text-lg md:text-xl text-yellow-50 mx-auto">Temukan berbagai produk dan layanan perbankan syariah yang sesuai dengan kebutuhan Anda</p>
        </div>
    </section>

    <!-- Products Section -->
    <section class="py-12 sm:py-16 md:py-20 bg-muted -mt-10 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search & Filter -->
            <div class="bg-card rounded-xl border border-border shadow-sm mb-8 p-4 sm:p-6 card-hover">
                <div class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2">
                            <svg class="w-5 h-5 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </span>
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari produk berdasarkan nama..." class="form-input pl-10">
                    </div>
                    <div class="w-full md:w-1/4">
                        <div class="relative">
                            <select wire:model.live="type" class="form-select appearance-none">
                                <option value="">Semua Tipe</option>
                                <option value="simpanan_syariah">Simpanan Syariah</option>
                                <option value="pembiayaan_syariah">Pembiayaan Syariah</option>
                                <option value="deposito_syariah">Deposito Syariah</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-muted-foreground">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Active Filters -->
                @if($search || $type)
                <div class="flex flex-wrap items-center gap-2 mt-4 pt-4 border-t border-border">
                    <span class="text-xs text-muted-foreground">Filter aktif:</span>
                    @if($search)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-50 text-primary-700">
                            "{{ $search }}"
                            <button wire:click="$set('search', '')" class="ml-1 bg-transparent border-0 cursor-pointer text-primary-700 hover:text-primary-900">&times;</button>
                        </span>
                    @endif
                    @if($type)
                        @php
                            $typeLabels = [
                                'simpanan_syariah' => 'Simpanan Syariah',
                                'pembiayaan_syariah' => 'Pembiayaan Syariah',
                                'deposito_syariah' => 'Deposito Syariah',
                            ];
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-primary-50 text-primary-700">
                            {{ $typeLabels[$type] ?? $type }}
                            <button wire:click="$set('type', '')" class="ml-1 bg-transparent border-0 cursor-pointer text-primary-700 hover:text-primary-900">&times;</button>
                        </span>
                    @endif
                    <button wire:click="$set('search', ''); $set('type', '')" class="text-xs text-muted-foreground hover:text-foreground underline bg-transparent border-0 cursor-pointer transition-colors">
                        Reset semua
                    </button>
                </div>
                @endif
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <div class="bg-card rounded-xl border border-border card-hover overflow-hidden group">
                            @if($product->image)
                                <div class="aspect-video overflow-hidden">
                                    <img src="{{ \App\Helpers\StorageHelper::url($product->image) }}" alt="{{ $product->name }}" class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-110">
                                </div>
                            @else
                                <div class="flex items-center justify-center aspect-video bg-gradient-to-br from-emerald-100 to-emerald-50 dark:from-emerald-100 dark:to-emerald-900/30">
                                    <svg class="w-16 h-16 text-yellow-300 dark:text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="p-5">
                                @php
                                    $typeLabels = [
                                        'simpanan_syariah' => 'Simpanan Syariah',
                                        'pembiayaan_syariah' => 'Pembiayaan Syariah',
                                        'deposito_syariah' => 'Deposito Syariah',
                                    ];
                                    $typeColors = [
                                        'simpanan_syariah' => 'bg-blue-50 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300',
                                        'pembiayaan_syariah' => 'bg-purple-50 text-purple-700 dark:bg-purple-900/40 dark:text-purple-300',
                                        'deposito_syariah' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold mb-3 {{ $typeColors[$product->type] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $typeLabels[$product->type] ?? $product->type }}
                                </span>
                                <h3 class="text-lg font-bold text-card-foreground mb-2 group-hover:text-emerald-600 transition-colors">{{ $product->name }}</h3>
                                @if($product->short_description)
                                    <p class="text-muted-foreground text-sm mb-4 line-clamp-2">{{ $product->short_description }}</p>
                                @endif
                                <button wire:click="selectProduct({{ $product->id }})" class="inline-flex items-center px-3 py-1.5 text-xs font-semibold bg-primary-50 text-primary-700 hover:bg-primary-100 rounded-full transition-all border-0 cursor-pointer hover:scale-105 btn-press">
                                    Lihat Detail
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-card rounded-xl border border-border text-center py-16 card-hover">
                    <div class="w-20 h-20 flex items-center justify-center mx-auto mb-4 rounded-full bg-muted">
                        <svg class="w-10 h-10 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-card-foreground mb-2">Produk Tidak Ditemukan</h3>
                    <p class="text-muted-foreground">
                        @if($search || $type)
                            Tidak ada produk yang sesuai dengan filter Anda.
                            <button wire:click="$set('search', ''); $set('type', '')" class="text-emerald-600 hover:text-emerald-700 underline bg-transparent border-0 cursor-pointer transition-colors">Reset filter</button>
                        @else
                            Belum ada produk yang tersedia saat ini.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </section>

    <!-- Product Detail Modal -->
    @if($showModal && $selectedProduct)
    <div class="fixed inset-0 z-50 flex items-center justify-center">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" wire:click="closeModal"></div>
        <div class="relative bg-card rounded-2xl shadow-2xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto animate-scale-in">
            <div class="p-0">
                @if($selectedProduct->image)
                    <div class="aspect-video overflow-hidden rounded-t-2xl">
                        <img src="{{ \App\Helpers\StorageHelper::url($selectedProduct->image) }}" alt="{{ $selectedProduct->name }}" class="object-cover w-full h-full">
                    </div>
                @endif
                <div class="p-6 sm:p-8">
                    @php
                        $typeLabels = [
                            'simpanan_syariah' => 'Simpanan Syariah',
                            'pembiayaan_syariah' => 'Pembiayaan Syariah',
                            'deposito_syariah' => 'Deposito Syariah',
                        ];
                    @endphp
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-50 text-primary-700 mb-3">
                        {{ $typeLabels[$selectedProduct->type] ?? $selectedProduct->type }}
                    </span>
                    <h3 class="text-2xl sm:text-3xl font-bold text-card-foreground mb-4">{{ $selectedProduct->name }}</h3>
                    @if($selectedProduct->short_description)
                        <p class="text-muted-foreground mb-4">{{ $selectedProduct->short_description }}</p>
                    @endif
                    @if($selectedProduct->description)
                        <div class="text-sm text-muted-foreground leading-relaxed prose prose-yellow max-w-none">
                            {!! nl2br(e($selectedProduct->description)) !!}
                        </div>
                    @endif
                </div>
            </div>
            <div class="px-6 sm:px-8 py-4 bg-muted border-t border-border flex justify-end rounded-b-2xl">
                <button wire:click="closeModal" class="px-5 py-2.5 text-sm font-medium text-muted-foreground bg-card border border-border rounded-xl hover:bg-muted transition-all btn-press">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
