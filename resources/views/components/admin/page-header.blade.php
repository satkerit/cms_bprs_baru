@props(['title', 'subtitle' => null, 'actions' => null, 'badge' => null, 'accent' => 'emerald'])

@php
    $gradientClass = match($accent) {
        'gold' => 'from-amber-500 to-amber-600',
        'sky' => 'from-sky-500 to-sky-600',
        'violet' => 'from-violet-500 to-violet-600',
        default => 'from-emerald-500 to-emerald-600',
    };
@endphp

<div {{ $attributes->merge(['class' => 'mb-6 lg:mb-8 fade-in']) }}>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="min-w-0 flex-1">
            <div class="flex items-center gap-3">
                {{-- Accent bar --}}
                <div class="w-1 h-8 rounded-full bg-gradient-to-b {{ $gradientClass }} shrink-0"></div>
                <div>
                    <div class="flex items-center gap-2.5">
                        <h1 class="text-xl font-bold text-slate-900 dark:text-slate-100 tracking-tight">
                            {{ $title }}
                        </h1>
                        @if($badge)
                            <span class="admin-badge-emerald">{{ $badge }}</span>
                        @endif
                    </div>                        @if($subtitle)
                        <p class="mt-0.5 text-[13px] text-slate-500 dark:text-slate-400 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ $subtitle }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
        @if($actions)
            <div class="flex items-center gap-3 shrink-0 flex-wrap">
                {{ $actions }}
            </div>
        @endif
    </div>
</div>
