@props([
    'title' => null,
    'subtitle' => null,
    'actions' => null,
    'noPadding' => false,
    'footer' => null,
    'hover' => false,
    'glass' => false,
    'accent' => 'emerald',
    'compact' => false,
])

@php
    $accentColors = [
        'emerald' => 'from-emerald-500 to-emerald-600',
        'gold' => 'from-amber-500 to-amber-600',
        'sky' => 'from-sky-500 to-sky-600',
        'violet' => 'from-violet-500 to-violet-600',
    ];
    $accentClass = $accentColors[$accent] ?? $accentColors['emerald'];

    $paddingClass = $compact ? 'p-5' : 'p-6';

    $baseClass = 'bg-white rounded-2xl border border-slate-200/60 shadow-sm transition-all duration-300';
    if ($hover) {
        $baseClass .= ' hover:shadow-lg hover:shadow-emerald-500/5 hover:border-emerald-200/70 hover:-translate-y-0.5';
    }
    if ($glass) {
        $baseClass .= ' bg-white/70 backdrop-blur-xl';
    }
@endphp

<div {{ $attributes->merge(['class' => $baseClass]) }}>
    @if($title)
        <div class="{{ $noPadding ? 'px-6 py-5' : $paddingClass }} border-b border-slate-100/80">
            <div class="flex items-center justify-between gap-4">
                <div class="min-w-0 flex-1">
                    <div class="flex items-center gap-3">
                        {{-- Accent gradient bar --}}
                        <div class="w-0.5 h-5 rounded-full bg-gradient-to-b {{ $accentClass }} shrink-0"></div>
                        <div>
                            <h3 class="text-[15px] font-semibold text-slate-900 leading-snug">{{ $title }}</h3>
                            @if($subtitle)
                                <p class="mt-0.5 text-[13px] text-slate-500 leading-snug">{{ $subtitle }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @if($actions)
                    <div class="flex items-center gap-2.5 shrink-0">
                        {{ $actions }}
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- Body --}}
    <div class="{{ $noPadding && !$title ? '' : ($noPadding ? '' : $paddingClass) }}">
        {{ $slot }}
    </div>

    {{-- Footer --}}
    @if($footer)
        <div class="px-6 py-4 border-t border-slate-100/80 bg-slate-50/50 rounded-b-2xl">
            {{ $footer }}
        </div>
    @endif
</div>
