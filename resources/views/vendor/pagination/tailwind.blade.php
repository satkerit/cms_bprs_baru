@php
    $size = $size ?? 'default';
    $btnBase = 'inline-flex items-center justify-center font-medium transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-emerald-500/40 focus:ring-offset-1 select-none';
    $btnSm = 'min-w-[32px] h-8 text-[12px] rounded-lg gap-1 px-2.5';
    $btnMd = 'min-w-[38px] h-[38px] text-[13px] rounded-xl gap-1.5 px-3.5';
    $btnLg = 'min-w-[44px] h-[44px] text-[14px] rounded-xl gap-2 px-4';
    $btnSize = match($size) { 'sm' => $btnSm, 'lg' => $btnLg, default => $btnMd };
    $btnActive = 'bg-gradient-to-b from-emerald-500 to-emerald-600 text-white shadow-md shadow-emerald-600/20 hover:shadow-lg hover:shadow-emerald-600/30 hover:from-emerald-600 hover:to-emerald-700 focus-visible:ring-emerald-500/40';
    $btnInactive = 'bg-white text-slate-600 border border-slate-200/70 shadow-sm hover:bg-slate-50 hover:border-slate-300 hover:text-slate-700 focus-visible:ring-emerald-500/40';
    $btnDisabled = 'bg-slate-50 text-slate-300 border border-slate-100 cursor-not-allowed';
    $btnDots = 'inline-flex items-center justify-center text-slate-300 select-none';
@endphp

@if ($paginator->hasPages())
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4 px-1 py-0.5">
        {{-- Info bar --}}
        <p class="text-[12px] text-slate-500 whitespace-nowrap order-2 sm:order-1">
            @if ($paginator->firstItem())
                Menampilkan
                <span class="font-semibold text-slate-700">{{ $paginator->firstItem() }}</span>
                -
                <span class="font-semibold text-slate-700">{{ $paginator->lastItem() }}</span>
                dari
                <span class="font-semibold text-slate-700">{{ $paginator->total() }}</span>
                data
            @else
                {{ $paginator->count() }} data
            @endif
        </p>

        {{-- Navigation --}}
        <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center gap-1.5 order-1 sm:order-2">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="{{ $btnBase }} {{ $btnSize }} {{ $btnDisabled }}" aria-disabled="true">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                    <span class="hidden sm:inline">Sebelumnya</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="{{ $btnBase }} {{ $btnSize }} {{ $btnInactive }}" aria-label="{{ __('pagination.previous') }}">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
                    <span class="hidden sm:inline">Sebelumnya</span>
                </a>
            @endif

            {{-- Page Numbers --}}
            <div class="hidden sm:flex items-center gap-1">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="{{ $btnDots }} {{ $btnSize }}" aria-disabled="true">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
                        </span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="{{ $btnBase }} {{ $btnSize }} {{ $btnActive }}" aria-current="page">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="{{ $btnBase }} {{ $btnSize }} {{ $btnInactive }}" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{-- Mobile: Page indicator --}}
            <span class="sm:hidden inline-flex items-center px-3 h-[38px] text-[13px] font-medium text-slate-500">
                {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}
            </span>

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="{{ $btnBase }} {{ $btnSize }} {{ $btnInactive }}" aria-label="{{ __('pagination.next') }}">
                    <span class="hidden sm:inline">Selanjutnya</span>
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </a>
            @else
                <span class="{{ $btnBase }} {{ $btnSize }} {{ $btnDisabled }}" aria-disabled="true">
                    <span class="hidden sm:inline">Selanjutnya</span>
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                </span>
            @endif
        </nav>
    </div>
@endif
