@if($years->count() > 0)
<div class="bg-white dark:bg-slate-900 rounded-xl shadow-lg shadow-black/5 p-6 mb-8 flex flex-wrap items-center gap-2 border border-border">
    <span class="text-sm text-foreground dark:text-slate-100 font-semibold mr-2 w-full mb-2">Tahun:</span>
    <a href="{{ request()->url() }}" class="px-5 py-1.5 rounded-full font-medium text-sm {{ !request('year') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/30' : 'bg-muted text-secondary hover:bg-secondary/10' }}">Semua</a>
    @foreach($years as $year)
    <a href="{{ request()->fullUrlWithQuery(['year' => $year]) }}" class="px-5 py-1.5 rounded-full font-medium text-sm {{ request('year') == $year ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/30' : 'bg-muted text-secondary hover:bg-secondary/10' }}">{{ $year }}</a>
    @endforeach
</div>
@endif

@if($reports->count() > 0)
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($reports as $report)
    <div class="bg-white dark:bg-slate-900 rounded-xl shadow-lg shadow-black/5 border border-border overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-xl group">
        <a href="{{ \App\Helpers\StorageHelper::url($report->file_path) }}" target="_blank" rel="noopener" class="block no-underline">
            <div class="p-6">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-900/50 flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-6 h-6 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-foreground dark:text-slate-100 text-sm group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors line-clamp-2 mb-1">{{ $report->title }}</h3>
                        @if($report->year)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-muted text-secondary">{{ $report->year }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </a>
        <div class="px-6 pb-5 flex gap-2 border-t border-border/50 dark:border-slate-800/50 pt-4">
            <a href="{{ \App\Helpers\StorageHelper::url($report->file_path) }}"
               target="_blank" rel="noopener"
               class="report-link flex-1 min-h-[44px] px-4 py-2 bg-white dark:bg-slate-800 border border-border dark:border-slate-700 text-foreground dark:text-slate-200 text-sm rounded-lg flex items-center justify-center hover:bg-muted dark:hover:bg-slate-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Download
            </a>
            @if($report->file_path)
            <a href="{{ \App\Helpers\StorageHelper::url($report->file_path) }}"
               target="_blank" rel="noopener"
               class="min-h-[44px] px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm rounded-lg flex items-center justify-center transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
            </a>
            @endif
        </div>
    </div>
    @endforeach
</div>
@else
<div class="text-center py-20 bg-white dark:bg-slate-900 rounded-xl border border-border shadow-sm">
    <div class="w-20 h-20 bg-muted rounded-full flex items-center justify-center mx-auto mb-4">
        <svg class="w-10 h-10 text-muted-foreground" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
        </svg>
    </div>
    <h3 class="text-lg font-semibold text-foreground dark:text-slate-100 mb-1">Belum ada laporan tersedia</h3>
    <p class="text-muted-foreground text-sm">Laporan akan ditampilkan setelah dipublikasikan.</p>
</div>
@endif
