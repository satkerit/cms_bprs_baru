@if($years->count() > 0)
<div class="bg-white rounded-xl shadow-lg shadow-black/5 p-6 mb-8 flex flex-wrap items-center gap-2 border border-border">
    <span class="text-sm text-foreground font-semibold mr-2 w-full mb-2">Tahun:</span>
    <a href="{{ request()->url() }}" class="px-5 py-1.5 rounded-full font-medium text-sm {{ !request('year') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/30' : 'bg-muted text-secondary hover:bg-secondary/10' }}">Semua</a>
    @foreach($years as $year)
    <a href="{{ request()->fullUrlWithQuery(['year' => $year]) }}" class="px-5 py-1.5 rounded-full font-medium text-sm {{ request('year') == $year ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-500/30' : 'bg-muted text-secondary hover:bg-secondary/10' }}">{{ $year }}</a>
    @endforeach
</div>
@endif

@if($reports->count() > 0)
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($reports as $report)
    <div class="bg-white rounded-xl shadow-lg shadow-black/5 border border-border overflow-hidden">
        <div class="p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center text-red-600 shrink-0">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                    </svg>
                </div>
                <div class="flex items-center gap-2 flex-wrap justify-end">
                    <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-100">{{ $report->type_label }}</span>
                    @if($type === 'keuangan_publikasi')
                    <span class="text-xs font-semibold text-blue-700 bg-blue-50 px-3 py-1 rounded-full border border-blue-200">{{ $report->quarter ? 'Q'.$report->quarter : 'Tahunan' }}</span>
                    @endif
                </div>
            </div>
            <h3 class="text-lg font-bold text-foreground mb-2 line-clamp-2 leading-tight">{{ $report->title }}</h3>
            @if($report->description)
            <p class="text-sm text-secondary mb-4 line-clamp-2">{{ Str::limit($report->description, 90) }}</p>
            @endif
            <div class="text-sm text-secondary">
                <p class="flex items-center">
                    <svg class="w-4 h-4 mr-2 text-secondary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    {{ $report->posted_at ? $report->posted_at->format('d M Y') : '-' }}
                </p>
                <p class="flex items-center mt-1.5">
                    <svg class="w-4 h-4 mr-2 text-secondary shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    {{ $report->file_size ? number_format($report->file_size/1024/1024, 2).' MB' : '-' }}
                </p>
            </div>
            <div class="flex items-center gap-3 mt-4">
                <span class="inline-flex items-center text-blue-600 bg-blue-50 px-2 py-1 rounded-full text-xs font-medium">
                    <svg class="w-3 h-3 mr-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    <span id="preview-{{ $report->id }}">{{ number_format($report->preview_count ?? 0) }}</span>
                </span>
                <span class="inline-flex items-center text-green-600 bg-green-50 px-2 py-1 rounded-full text-xs font-medium">
                    <svg class="w-3 h-3 mr-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    <span id="download-{{ $report->id }}">{{ number_format($report->download_count ?? 0) }}</span>
                </span>
            </div>
            <div class="flex items-center gap-2 mt-6">
                <a href="{{ route('reports.preview', $report->id) }}"
                   target="_blank"
                   data-action="preview"
                   data-report-id="{{ $report->id }}"
                   class="report-link flex-1 min-h-[44px] px-4 py-2 bg-white border border-border text-foreground text-sm rounded-lg flex items-center justify-center hover:bg-muted transition-colors">
                    <svg class="w-4 h-4 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Preview
                </a>
                <a href="{{ route('reports.download', $report->id) }}"
                   data-action="download"
                   data-report-id="{{ $report->id }}"
                   class="report-link flex-1 min-h-[44px] px-4 py-2 bg-emerald-600 text-white text-sm rounded-lg flex items-center justify-center hover:bg-emerald-700 transition-all">
                    <svg class="w-4 h-4 mr-1.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Download
                </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="mt-8">{{ $reports->links() }}</div>
@else
<div class="text-center py-16 text-sm text-secondary">Belum ada laporan tersedia</div>
@endif
