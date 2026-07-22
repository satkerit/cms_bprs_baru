@props([
    'type' => 'button',
    'variant' => 'default',
    'size' => 'default',
    'href' => null,
    'icon' => null,
])

@php
    $baseClasses = 'inline-flex items-center justify-center gap-2 font-medium rounded-xl transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-emerald-500 select-none';

    $variants = [
        'default' => 'bg-gradient-to-r from-emerald-600 to-emerald-500 text-white hover:from-emerald-700 hover:to-emerald-600 shadow-lg shadow-emerald-600/25 hover:shadow-emerald-600/35 active:shadow-emerald-600/20',
        'primary' => 'bg-gradient-to-r from-emerald-600 to-emerald-500 text-white hover:from-emerald-700 hover:to-emerald-600 shadow-lg shadow-emerald-600/25 hover:shadow-emerald-600/35 active:shadow-emerald-600/20',
        'gold' => 'bg-gradient-to-r from-amber-600 to-amber-500 text-white hover:from-amber-700 hover:to-amber-600 shadow-lg shadow-amber-600/25 hover:shadow-amber-600/35',
        'secondary' => 'bg-slate-100 text-slate-700 hover:bg-slate-200/80 border border-slate-200/60 hover:border-slate-300 shadow-sm',
        'destructive' => 'bg-gradient-to-r from-red-600 to-red-500 text-white hover:from-red-700 hover:to-red-600 shadow-lg shadow-red-600/25 hover:shadow-red-600/35',
        'outline' => 'border border-slate-200 text-slate-700 bg-white/80 hover:bg-slate-50 hover:border-slate-300 shadow-sm backdrop-blur-sm',
        'ghost' => 'text-slate-600 hover:text-slate-900 hover:bg-slate-100',
        'link' => 'text-amber-600 hover:text-amber-700 underline-offset-2 hover:underline',
    ];

    $sizes = [
        'sm' => 'px-3 py-1.5 text-xs',
        'default' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-2.5 text-sm',
        'icon' => 'p-2',
    ];

    $variantClass = $variants[$variant] ?? $variants['default'];
    $sizeClass = $sizes[$size] ?? $sizes['default'];

    $classes = trim($baseClasses . ' ' . $variantClass . ' ' . $sizeClass);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">{!! $icon !!}</svg>
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">{!! $icon !!}</svg>
        @endif
        {{ $slot }}
    </button>
@endif
