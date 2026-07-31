<x-frontend-layout>
    <x-slot:title>{{ $title }} - {{ config('app.name') }}</x-slot:title>

    <!-- Hero Section -->
    <section class="relative pt-4 sm:pt-6 md:pt-8 pb-16 sm:pb-20 overflow-hidden">
        <div class="absolute inset-0 hero-gradient">
            <div class="absolute inset-0 bg-grid-pattern opacity-50"></div>
            <div class="absolute top-20 left-10 w-72 h-72 bg-emerald-400/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-emerald-400/20 rounded-full blur-3xl"></div>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('reports.index') }}" class="inline-flex items-center gap-1.5 text-white/80 hover:text-white mb-3 sm:mb-4 transition-colors text-xs sm:text-sm group/back">
                <svg class="w-4 h-4 shrink-0 group-hover/back:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke Laporan
            </a>
            <div class="text-center">
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4 leading-tight tracking-tight">{{ $title }}</h1>
                @if($description)
                    <p class="text-sm sm:text-lg md:text-xl text-emerald-100 mx-auto px-4 max-w-5xl">{{ $description }}</p>
                @else
                    <p class="text-sm sm:text-lg md:text-xl text-emerald-100 mx-auto px-4 max-w-5xl">{{ $subtitle }}</p>
                @endif
            </div>
        </div>
    </section>

    <section class="py-12 md:py-16 bg-muted/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($reports->count() > 0)
                <!-- Controls: Year Filter + Info -->
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8" x-data="{ year: '{{ request('year', '') }}' }">
                    <p class="text-sm text-muted-foreground">
                        Menampilkan <span class="font-semibold text-foreground">{{ $reports->total() }}</span> laporan
                        @if($years->count() > 0)
                            <span class="hidden sm:inline">dari berbagai periode</span>
                        @endif
                    </p>

                    @if($years->count() > 0)
                    <div class="flex items-center gap-2">
                        <label for="year-filter" class="text-xs sm:text-sm text-muted-foreground font-medium">Filter Tahun:</label>
                        <select id="year-filter"
                                x-model="year"
                                @change="year ? window.location = '{{ route('reports.tahunan-berkelanjutan') }}?year=' + year : window.location = '{{ route('reports.tahunan-berkelanjutan') }}'"
                                class="px-3 py-2 text-sm bg-white dark:bg-slate-900 dark:border-slate-700 border border-border rounded-lg focus:ring-2 focus:ring-{{ $color }}-500/20 focus:border-{{ $color }}-500 outline-none transition-colors cursor-pointer dark:text-slate-200">
                            <option value="">Semua Tahun</option>
                            @foreach($years as $y)
                                <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                </div>

                <!-- Report Cards Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                    @foreach($reports as $report)
                    <div class="group bg-card rounded-xl border border-border overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300 flex flex-col">
                        <!-- Card Top: PDF Icon + Badge -->
                        <div class="relative h-32 sm:h-36 bg-gradient-to-br {{ $c['bg'] }} flex items-center justify-center overflow-hidden">
                            <!-- Background decorative pattern -->
                            <div class="absolute inset-0 opacity-[0.07]">
                                <div class="absolute top-4 left-4 w-16 h-16 border-2 border-emerald-600 rounded-lg rotate-12"></div>
                                <div class="absolute bottom-4 right-4 w-20 h-20 border-2 border-emerald-600 rounded-lg -rotate-6"></div>
                                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-24 h-24 border border-emerald-600/30 rounded-full"></div>
                            </div>

                            <!-- PDF Icon -->
                            <div class="relative group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-14 h-14 sm:w-16 sm:h-16 {{ $c['text'] }}/80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M14 14H6a2 2 0 00-2 2v4a2 2 0 002 2h12a2 2 0 002-2v-8l-6-6H6a2 2 0 00-2 2v2"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                    <line x1="16" y1="13" x2="8" y2="13"/>
                                    <line x1="16" y1="17" x2="8" y2="17"/>
                                </svg>
                            </div>

                            <!-- Year Badge -->
                            @if($report->quarter)
                            <div class="absolute top-3 left-3">
                                <span class="inline-flex items-center px-2 py-0.5 text-xs font-semibold bg-white/90 backdrop-blur-sm {{ $c['text'] }} rounded-md shadow-sm border border-{{ $color }}-200">
                                    Q{{ $report->quarter }} {{ $report->year }}
                                </span>
                            </div>
                            @elseif($report->year)
                            <div class="absolute top-3 left-3">
                                <span class="inline-flex items-center px-2 py-0.5 text-xs font-semibold bg-white/90 backdrop-blur-sm {{ $c['text'] }} rounded-md shadow-sm border border-{{ $color }}-200">
                                    {{ $report->year }}
                                </span>
                            </div>
                            @endif

                            <!-- Type Badge -->
                            <div class="absolute top-3 right-3">
                                <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium {{ $c['text'] }}/80 bg-white/80 backdrop-blur-sm rounded-md border border-{{ $color }}-200/50">
                                    PDF
                                </span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-4 sm:p-5 flex flex-col flex-1">
                            <h3 class="font-bold text-foreground group-hover:{{ $c['text'] }} transition-colors leading-snug mb-1.5">
                                {{ $report->title }}
                            </h3>

                            @if($report->description)
                                <p class="text-xs sm:text-sm text-muted-foreground line-clamp-2 mb-3 leading-relaxed">{{ $report->description }}</p>
                            @endif

                            <!-- Meta Info -->
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-muted-foreground mb-3 mt-auto">
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    {{ $report->created_at->format('d M Y') }}
                                </span>
                                @if($report->file_size)
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/></svg>
                                    {{ $report->file_size >= 1048576 ? number_format($report->file_size / 1048576, 1) . ' MB' : number_format($report->file_size / 1024, 0) . ' KB' }}
                                </span>
                                @endif
                                <span class="inline-flex items-center gap-1" title="{{ number_format($report->download_count ?? 0) }} kali diunduh">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    {{ number_format($report->download_count ?? 0) }}
                                </span>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center gap-2 pt-3 border-t border-border">
                                <a href="{{ route('reports.preview', $report) }}" target="_blank"
                                   class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 {{ $c['btn'] }} text-white text-xs font-semibold rounded-lg transition-colors btn-press">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Preview
                                </a>
                                <a href="{{ route('reports.download', $report) }}"
                                   class="flex-1 inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-white dark:bg-slate-800 {{ $c['btn_outline'] }} text-xs font-semibold rounded-lg border transition-colors btn-press">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    Download
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($reports->hasPages())
                <div class="mt-8 sm:mt-12">
                    {{ $reports->links() }}
                </div>
                @endif
            @else
                <div class="text-center py-16 sm:py-20 bg-card rounded-xl border border-border">
                    <div class="w-20 h-20 bg-muted rounded-full flex items-center justify-center mx-auto mb-4 sm:mb-6">
                        <svg class="w-10 h-10 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-foreground mb-2">Belum Ada Laporan</h3>
                    <p class="text-muted-foreground text-sm w-full">Laporan {{ strtolower($title) }} belum tersedia. Silakan cek kembali nanti atau pilih kategori laporan lainnya.</p>
                    <a href="{{ route('reports.index') }}" class="inline-flex items-center gap-1.5 mt-6 px-4 py-2.5 {{ $c['btn'] }} text-white text-sm font-semibold rounded-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Kembali ke Semua Laporan
                    </a>
                </div>
            @endif
        </div>
    </section>
</x-frontend-layout>
