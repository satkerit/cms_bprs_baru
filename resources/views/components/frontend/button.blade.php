@props(['variant' => 'primary', 'type' => 'button', 'href' => null])

@php
    $baseClasses = 'inline-flex items-center justify-center px-6 py-3 rounded-lg font-semibold transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2';

    $variantClasses = [
        'primary' => 'bg-gradient-to-r from-emerald-600 to-emerald-700 text-white hover:from-emerald-700 hover:to-emerald-800 shadow-sm',
        'secondary' => 'bg-white text-emerald-600 border border-border hover:border-emerald-300 hover:bg-emerald-50 shadow-sm',
        'outline' => 'bg-transparent text-emerald-600 border-2 border-emerald-600 hover:bg-emerald-50',
        'danger' => 'bg-gradient-to-r from-red-500 to-rose-500 text-white hover:from-red-600 hover:to-rose-600 shadow-sm',
    ];

    $class = $variantClasses[$variant] ?? $variantClasses['primary'];
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => "$baseClasses $class"]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => "$baseClasses $class"]) }}>
        {{ $slot }}
    </button>
@endif
