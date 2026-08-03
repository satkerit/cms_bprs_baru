<x-frontend-layout>
    <x-slot name="title">{{ $auction->title }} - Lelang Agunan BPRS Babel</x-slot>

    @push('head')
    <meta name="description" content="{{ Str::limit(strip_tags($auction->description), 160) }}">
    <meta property="og:title" content="{{ $auction->title }} - Lelang Agunan BPRS Babel">
    <meta property="og:description" content="{{ Str::limit(strip_tags($auction->description), 160) }}">
    @if($auction->main_image)
    <meta property="og:image" content="{{ \App\Helpers\StorageHelper::url($auction->main_image) }}">
    @endif
    @endpush

    <!-- Header & Hero Breadcrumb -->
    <section class="relative pt-8 sm:pt-10 md:pt-12 pb-16 sm:pb-20 overflow-hidden">
        <div class="absolute inset-0 hero-gradient">
            <div class="absolute inset-0 bg-grid-pattern opacity-50"></div>
            <div class="absolute top-20 left-10 w-72 h-72 bg-emerald-400/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-emerald-400/20 rounded-full blur-3xl"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
                <a href="{{ route('auctions.index') }}" class="inline-flex items-center px-3 sm:px-4 py-1.5 bg-white/20 backdrop-blur-md rounded-full text-white text-xs sm:text-sm font-medium hover:bg-white/30 transition-all duration-200">
                    <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Kembali ke Daftar Lelang
                </a>
                <span class="inline-flex items-center px-3.5 py-1.5 bg-emerald-500/30 backdrop-blur-md border border-emerald-300/30 rounded-full text-white text-xs sm:text-sm font-semibold">
                    {{ $auction->asset_type_label }}
                </span>
                @if($auction->is_featured)
                <span class="inline-flex items-center px-3.5 py-1.5 bg-gradient-to-r from-amber-400 to-orange-500 text-white text-xs sm:text-sm font-bold rounded-full shadow-sm">
                    ⭐ Agunan Unggulan
                </span>
                @endif
            </div>

            <h1 class="text-2xl sm:text-3xl md:text-4xl xl:text-5xl font-bold text-white mb-3 sm:mb-4 tracking-tight drop-shadow-sm">{{ $auction->title }}</h1>

            <div class="flex flex-wrap items-center gap-4 text-white/80 text-sm sm:text-base">
                <div class="flex items-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1.5 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>{{ $auction->city ?? 'Bangka Belitung' }}</span>
                </div>
                @if($auction->auction_number)
                <div class="flex items-center">
                    <span class="px-2.5 py-0.5 rounded bg-white/10 text-xs font-mono text-emerald-200">No. {{ $auction->auction_number }}</span>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Main Content Detail -->
    <section class="py-8 md:py-12 bg-muted/50 -mt-8 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                {{-- Column Left: Images, Specification, & Description --}}
                <div class="lg:col-span-2 space-y-6 lg:space-y-8">

                    {{-- Galeri Foto --}}
                    @php
                        $allImages = collect((array)($auction->images ?? []));
                        $mainImage = $auction->main_image;
                    @endphp
                    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-sm overflow-hidden border border-border" x-data="{ activeImage: 0 }">
                        <div class="relative bg-zinc-900/5 dark:bg-slate-950 aspect-[16/9] flex items-center justify-center overflow-hidden">
                            @if($mainImage)
                                <img src="{{ \App\Helpers\StorageHelper::url($mainImage) }}" alt="{{ $auction->title }}" class="w-full h-full object-contain p-2 transition-opacity duration-300" x-show="activeImage === 0">
                            @endif
                            @foreach($allImages as $idx => $img)
                                @if(is_string($img) && $img !== $mainImage)
                                <img src="{{ \App\Helpers\StorageHelper::url($img) }}" alt="{{ $auction->title }} - Gambar {{ $idx + 1 }}" class="w-full h-full object-contain p-2 transition-opacity duration-300" x-show="activeImage === {{ $idx + 1 }}" x-cloak>
                                @endif
                            @endforeach
                            @if(!$mainImage && $allImages->isEmpty())
                                <div class="text-center p-12">
                                    <svg class="mx-auto h-20 w-20 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <p class="mt-2 text-sm text-zinc-500">Foto agunan belum tersedia</p>
                                </div>
                            @endif

                            @if($auction->status === 'sold')
                            <div class="absolute inset-0 flex items-center justify-center bg-black/40 z-20 pointer-events-none">
                                <div class="transform -rotate-12 bg-red-600/90 text-white px-8 py-3 text-2xl sm:text-3xl font-black tracking-widest border-4 border-white uppercase backdrop-blur-sm shadow-xl">TERJUAL</div>
                            </div>
                            @endif
                        </div>

                        @if($mainImage || $allImages->count() > 1)
                        <div class="p-4 border-t border-border bg-white dark:bg-slate-900">
                            <div class="flex items-center gap-3 overflow-x-auto pb-1">
                                @if($mainImage)
                                <button @click="activeImage = 0" :class="activeImage === 0 ? 'ring-2 ring-emerald-500' : 'opacity-60 hover:opacity-100'" class="w-16 h-16 shrink-0 rounded-lg overflow-hidden border border-border transition-all">
                                    <img src="{{ \App\Helpers\StorageHelper::url($mainImage) }}" class="w-full h-full object-cover">
                                </button>
                                @endif
                                @foreach($allImages as $idx => $img)
                                    @if(is_string($img) && $img !== $mainImage)
                                    <button @click="activeImage = {{ $idx + 1 }}" :class="activeImage === {{ $idx + 1 }} ? 'ring-2 ring-emerald-500' : 'opacity-60 hover:opacity-100'" class="w-16 h-16 shrink-0 rounded-lg overflow-hidden border border-border transition-all">
                                        <img src="{{ \App\Helpers\StorageHelper::url($img) }}" class="w-full h-full object-cover">
                                    </button>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>

                    {{-- Informasi Ringkas Spesifikasi Agunan --}}
                    <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm border border-border">
                        <h2 class="text-lg font-bold text-foreground dark:text-slate-100 mb-4 flex items-center gap-2.5">
                            <span class="w-7 h-7 bg-emerald-50 dark:bg-emerald-950/50 rounded-lg flex items-center justify-center text-emerald-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </span>
                            Spesifikasi Agunan
                        </h2>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                            <div class="p-3 bg-zinc-50 dark:bg-slate-800/60 rounded-xl border border-zinc-100 dark:border-slate-800">
                                <span class="block text-xs text-secondary mb-1">Jenis Aset</span>
                                <span class="font-semibold text-sm text-foreground">{{ $auction->asset_type_label }}</span>
                            </div>

                            <div class="p-3 bg-zinc-50 dark:bg-slate-800/60 rounded-xl border border-zinc-100 dark:border-slate-800">
                                <span class="block text-xs text-secondary mb-1">Sertifikat</span>
                                <span class="font-semibold text-sm text-foreground">{{ $auction->certificate_type_label ?? 'Ada' }}</span>
                            </div>

                            <div class="p-3 bg-zinc-50 dark:bg-slate-800/60 rounded-xl border border-zinc-100 dark:border-slate-800">
                                <span class="block text-xs text-secondary mb-1">Luas Tanah</span>
                                <span class="font-semibold text-sm text-foreground">{{ $auction->land_area ? number_format($auction->land_area, 0, ',', '.') . ' m²' : '-' }}</span>
                            </div>

                            <div class="p-3 bg-zinc-50 dark:bg-slate-800/60 rounded-xl border border-zinc-100 dark:border-slate-800">
                                <span class="block text-xs text-secondary mb-1">Luas Bangunan</span>
                                <span class="font-semibold text-sm text-foreground">{{ $auction->building_area ? number_format($auction->building_area, 0, ',', '.') . ' m²' : '-' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Deskripsi Agunan --}}
                    <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 sm:p-8 shadow-sm border border-border">
                        <h2 class="text-lg font-bold text-foreground dark:text-slate-100 mb-4 flex items-center gap-2.5">
                            <span class="w-7 h-7 bg-emerald-50 dark:bg-emerald-950/50 rounded-lg flex items-center justify-center text-emerald-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </span>
                            Keterangan & Deskripsi Aset
                        </h2>
                        <div class="text-secondary leading-relaxed text-sm sm:text-base prose dark:prose-invert max-w-none">
                            {!! nl2br(e($auction->description)) !!}
                        </div>
                    </div>

                    {{-- Lokasi Aset --}}
                    <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 sm:p-8 shadow-sm border border-border">
                        <h2 class="text-lg font-bold text-foreground dark:text-slate-100 mb-3 flex items-center gap-2.5">
                            <span class="w-7 h-7 bg-emerald-50 dark:bg-emerald-950/50 rounded-lg flex items-center justify-center text-emerald-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </span>
                            Lokasi Agunan
                        </h2>
                        <p class="text-foreground font-medium text-sm sm:text-base leading-relaxed">{{ $auction->address }}</p>
                        @if($auction->city)
                        <p class="text-secondary text-xs sm:text-sm mt-1">Kota/Kabupaten: {{ $auction->city }}</p>
                        @endif
                    </div>

                    {{-- Dokumen Brosur PDF / Lampiran jika ada --}}
                    @php
                        $docs = collect((array)($auction->documents ?? []));
                    @endphp
                    @if($docs->isNotEmpty())
                    <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 shadow-sm border border-border">
                        <h2 class="text-lg font-bold text-foreground dark:text-slate-100 mb-4 flex items-center gap-2.5">
                            <span class="w-7 h-7 bg-emerald-50 dark:bg-emerald-950/50 rounded-lg flex items-center justify-center text-emerald-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            </span>
                            Lampiran Dokumen / Brosur
                        </h2>
                        <div class="space-y-2">
                            @foreach($docs as $doc)
                            @php $doc = (object) $doc; @endphp
                            <a href="{{ \App\Helpers\StorageHelper::url($doc->file_path ?? '') }}" target="_blank" class="flex items-center p-3 bg-zinc-50 dark:bg-slate-800 rounded-xl hover:bg-emerald-50 dark:hover:bg-emerald-950/30 transition-colors border border-border group">
                                <div class="w-9 h-9 bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300 rounded-lg flex items-center justify-center mr-3 shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="font-semibold text-sm text-foreground truncate">{{ $doc->original_name ?? 'Unduh Dokumen Lelang' }}</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>

                {{-- Column Right: Sidebar Actions & Price Card --}}
                <div class="space-y-6">
                    <div class="bg-white dark:bg-slate-900 rounded-2xl p-6 sm:p-8 shadow-sm border border-border sticky top-24">
                        <div class="text-xs font-semibold text-secondary uppercase tracking-wider mb-1">Harga Limit Lelang</div>
                        <div class="text-3xl font-black text-emerald-600 dark:text-emerald-400 mb-6 font-mono">{{ $auction->formatted_limit_price }}</div>

                        <div class="space-y-3 mb-6 text-sm">
                            @if($auction->deposit_amount)
                            <div class="flex justify-between items-center py-2 border-b border-border">
                                <span class="text-secondary">Uang Jaminan</span>
                                <span class="font-bold text-foreground font-mono">{{ $auction->formatted_deposit_amount }}</span>
                            </div>
                            @endif

                            @if($auction->auction_date)
                            <div class="flex justify-between items-center py-2 border-b border-border">
                                <span class="text-secondary">Tanggal Lelang</span>
                                <span class="font-semibold text-foreground">{{ $auction->auction_date->format('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-b border-border">
                                <span class="text-secondary">Waktu</span>
                                <span class="font-semibold text-foreground">{{ $auction->auction_date->format('H:i') }} WIB</span>
                            </div>
                            @endif

                            <div class="flex justify-between items-center py-2 border-b border-border">
                                <span class="text-secondary">Penyelenggara</span>
                                <span class="font-semibold text-foreground text-right">{{ $auction->auction_location ?? 'KPKNL Pangkalpinang' }}</span>
                            </div>

                            <div class="flex justify-between items-center py-2 border-b border-border">
                                <span class="text-secondary">Status Agunan</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">
                                    {{ $auction->status_label }}
                                </span>
                            </div>
                        </div>

                        {{-- Tombol Informasi & Kontak --}}
                        <div class="space-y-3">
                            @php
                                $waPhone = preg_replace('/[^0-9]/', '', $auction->contact_whatsapp ?? $auction->contact_phone ?? '081234567890');
                                if (str_starts_with($waPhone, '0')) {
                                    $waPhone = '62' . substr($waPhone, 1);
                                }
                                $waMessage = urlencode("Halo BPRS Bangka Belitung, saya berminat menanyakan informasi terkait lelang agunan: " . $auction->title . " (No: " . $auction->auction_number . ")");
                            @endphp

                            <a href="https://wa.me/{{ $waPhone }}?text={{ $waMessage }}" target="_blank"
                               class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-4 rounded-xl flex items-center justify-center gap-2 shadow-sm transition-all duration-200 text-sm">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                Tanya via WhatsApp
                            </a>

                            @if($auction->auction_url)
                            <a href="{{ $auction->auction_url }}" target="_blank" rel="noopener noreferrer"
                               class="w-full bg-zinc-100 hover:bg-zinc-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-foreground font-semibold py-3 px-4 rounded-xl flex items-center justify-center gap-2 transition-all duration-200 text-sm border border-border">
                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                Buka Portal Lelang Resmi
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-frontend-layout>
