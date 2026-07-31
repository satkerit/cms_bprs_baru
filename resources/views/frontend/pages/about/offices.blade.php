<x-frontend-layout>
    <x-slot name="title">Kantor Kami - BPRS Bangka Belitung</x-slot>

    <!-- Hero -->
    <section class="relative pt-4 sm:pt-6 md:pt-8 pb-16 sm:pb-20 md:pb-24 overflow-hidden">
        <div class="absolute inset-0 hero-gradient">
            <div class="absolute inset-0 bg-grid-pattern opacity-50"></div>
            <div class="absolute top-20 left-10 w-72 h-72 bg-emerald-400/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-emerald-400/20 rounded-full blur-3xl"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <span class="inline-flex items-center px-4 py-2 bg-card/10 backdrop-blur-sm rounded-full text-white/90 text-xs font-medium mb-6 ring-1 ring-white/20">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                Jaringan Kantor
            </span>
            <h1 class="text-5xl md:text-5xl font-bold text-white mb-6 tracking-tight">Kantor Kami</h1>
            <p class="text-lg font-semibold text-emerald-50 mx-auto">Temukan kantor BPRS Bangka Belitung terdekat dari lokasi Anda untuk kemudahan bertransaksi.</p>
        </div>
    </section>

    <section class="py-16 -mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-900 rounded-lg border border-border overflow-hidden mb-8 shadow-sm">
                <div class="px-6 py-5 border-b border-border bg-muted/50/50 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-foreground flex items-center gap-3">
                        <div class="w-10 h-10 bg-emerald-50 rounded-lg flex items-center justify-center text-emerald-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        Peta Jaringan Kantor
                    </h2>
                    <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-xs font-bold rounded-full uppercase tracking-wide">OpenStreetMap</span>
                </div>
                @php
                    $mapPoints = $offices->filter(fn($o) => $o->has_coordinates)->map(fn($o) => [
                        'n' => $o->name,
                        'a' => $o->address,
                        't' => $o->type_label,
                        'la' => $o->latitude,
                        'lo' => $o->longitude
                    ])->values();
                @endphp
                <div class="relative">
                    <div id="officesMap"
                         class="w-full h-[300px] sm:h-[420px]"
                         data-map-init
                         data-points='@json($mapPoints)'
                         data-options='{"scrollWheelZoom": false}'></div>
                </div>
            </div>
            <!-- Filter -->
            <div class="bg-card rounded-lg shadow-gray-200/50 p-2 mb-8 border border-border max-w-4xl mx-auto">
                <div class="flex flex-wrap justify-center gap-2">
                    <a href="{{ route('about.offices') }}" class="px-6 py-2.5 rounded-lg text-xs font-semibold transition-all duration-300 {{ !request('type') ? 'bg-emerald-600 text-white shadow-emerald-500/30 ring-2 ring-emerald-600 ring-offset-2' : 'bg-muted/50 text-muted-foreground hover:bg-muted hover:text-emerald-600' }}">
                        Semua Kantor
                    </a>
                    <a href="{{ route('about.offices', ['type' => 'pusat']) }}" class="px-6 py-2.5 rounded-lg text-xs font-semibold transition-all duration-300 {{ request('type') === 'pusat' ? 'bg-amber-500 text-white shadow-amber-500/30 ring-2 ring-amber-500 ring-offset-2' : 'bg-muted/50 text-muted-foreground hover:bg-muted hover:text-amber-500' }}">
                        Kantor Pusat
                    </a>
                    <a href="{{ route('about.offices', ['type' => 'cabang']) }}" class="px-6 py-2.5 rounded-lg text-xs font-semibold transition-all duration-300 {{ request('type') === 'cabang' ? 'bg-blue-500 text-white shadow-blue-500/30 ring-2 ring-blue-500 ring-offset-2' : 'bg-muted/50 text-muted-foreground hover:bg-muted hover:text-blue-500' }}">
                        Kantor Cabang
                    </a>
                    <a href="{{ route('about.offices', ['type' => 'kas']) }}" class="px-6 py-2.5 rounded-lg text-xs font-semibold transition-all duration-300 {{ request('type') === 'kas' ? 'bg-muted text-foreground shadow-muted/30 ring-2 ring-muted ring-offset-2' : 'bg-muted/50 text-muted-foreground hover:bg-muted hover:text-muted-foreground' }}">
                        Kantor Kas
                    </a>

                </div>
            </div>

            @if($offices->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($offices as $office)
                <div class="group bg-card rounded-lg shadow-gray-200/50 overflow-hidden hover:shadow-sm hover:shadow-emerald-500/10 transition-all duration-300 hover:-translate-y-1">
                    <div class="h-1.5 bg-gradient-to-r from-emerald-600 to-emerald-700"></div>
                    <div class="relative h-56 overflow-hidden">
                        @if($office->photo)
                        <x-optimized-image
                             src="{{ \App\Helpers\StorageHelper::url($office->photo) }}"
                             alt="{{ $office->name }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                             :lazy="true"
                             aspect-ratio="16/9"
                        />
                        @else
                        <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                            <svg class="w-16 h-16 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        @endif
                        <div class="absolute top-3 left-3">
                            @php
                                $badgeColors = [
                                    'pusat' => 'bg-amber-500 text-white',
                                    'cabang' => 'bg-blue-500 text-white',
                                    'kas' => 'bg-muted text-muted-foreground',
                                    'kas_keliling' => 'bg-emerald-600 text-white'
                                ];
                            @endphp
                            <span class="px-3 py-1 text-xs font-bold rounded-full {{ $badgeColors[$office->type] ?? 'bg-muted text-muted-foreground' }}">
                                {{ $office->type_label }}
                            </span>
                        </div>
                        @if($office->has_coordinates)
                        <div class="absolute top-3 right-3">
                            <span class="w-8 h-8 bg-card/90 rounded-full flex items-center justify-center shadow" title="GPS tersedia">
                                <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                </svg>
                            </span>
                        </div>
                        @endif
                    </div>
                    <div class="p-5">
                        <h3 class="text-base sm:text-lg font-bold text-foreground mb-3 group-hover:text-emerald-600 transition-colors">{{ $office->name }}</h3>
                        <div class="space-y-2 text-xs text-muted-foreground mb-4">
                            <p class="flex items-start">
                                <svg class="w-4 h-4 mr-2 mt-0.5 shrink-0 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="line-clamp-2">{{ $office->address }}</span>
                            </p>
                            @if($office->phone)
                            <p class="flex items-center">
                                <svg class="w-4 h-4 mr-2 shrink-0 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ $office->phone }}
                            </p>
                            @endif
                        </div>
                        <div class="flex items-center gap-2 pt-4 border-t border-border">
                            <a href="{{ route('about.offices.show', $office) }}" class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-emerald-600 text-white text-xs font-medium rounded-lg hover:bg-emerald-700 transition">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                Detail
                            </a>
                            @if($office->has_coordinates)
                            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $office->latitude }},{{ $office->longitude }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 border border-emerald-600 text-emerald-600 text-xs font-medium rounded-lg hover:bg-emerald-50 transition" title="Petunjuk Arah">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                </svg>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-16">
                <svg class="w-20 h-20 text-muted-foreground mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <p class="text-muted-foreground text-base">Belum ada data kantor tersedia</p>
            </div>
            @endif
        </div>
    </section>

    {{-- Leaflet CSS & JS — lazy loaded via app.js dynamic import --}}
    <style>
        #officesMap .leaflet-popup-content-wrapper{border-radius:14px}
        #officesMap .leaflet-popup-content{margin:10px 14px}
    </style>

    @push('scripts')
    <script nonce="{{ $nonce }}">
        (function () {
            var tries = 0;
            function initWhenReady() {
                var el = document.getElementById('officesMap');
                if (!el) return;
                if (!window.BPRSMaps) {
                    if (tries++ < 20) return setTimeout(initWhenReady, 150);
                    return;
                }
                const data = @js($offices->map(fn($o) => [
                    'n' => $o->name, 'a' => $o->address, 't' => $o->type_label,
                    'la' => $o->latitude, 'lo' => $o->longitude, 'u' => route('about.offices.show', $o)
                ])->values());

                const result = window.BPRSMaps.initSimpleMap('officesMap', data, { scrollWheelZoom: false });
                if (!result || !result.markers || result.markers.length === 0) {
                    el.parentElement.parentElement.classList.add('hidden');
                }
            }
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initWhenReady);
            } else {
                initWhenReady();
            }
        })();
    </script>
    @endpush
</x-frontend-layout>
