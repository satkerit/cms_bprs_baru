@props([
    'type' => 'success',
    'title' => null,
    'dismissible' => true,
])

@php
    $config = [
        'success' => [
            'container' => 'bg-emerald-50 dark:bg-emerald-950/40 border-emerald-200/70 dark:border-emerald-800/50 text-emerald-800 dark:text-emerald-300',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
            'iconBg' => 'bg-emerald-100 dark:bg-emerald-900/60 text-emerald-600 dark:text-emerald-400',
        ],
        'error' => [
            'container' => 'bg-red-50 dark:bg-red-950/40 border-red-200/70 dark:border-red-800/50 text-red-800 dark:text-red-300',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
            'iconBg' => 'bg-red-100 dark:bg-red-900/60 text-red-600 dark:text-red-400',
        ],
        'warning' => [
            'container' => 'bg-amber-50 dark:bg-amber-950/40 border-amber-200/70 dark:border-amber-800/50 text-amber-800 dark:text-amber-300',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>',
            'iconBg' => 'bg-amber-100 dark:bg-amber-900/60 text-amber-600 dark:text-amber-400',
        ],
        'info' => [
            'container' => 'bg-sky-50 dark:bg-sky-950/40 border-sky-200/70 dark:border-sky-800/50 text-sky-800 dark:text-sky-300',
            'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
            'iconBg' => 'bg-sky-100 dark:bg-sky-900/60 text-sky-600 dark:text-sky-400',
        ],
    ];

    $cfg = $config[$type] ?? $config['success'];
@endphp

<div x-data="{ show: true }" x-show="show" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2"
     {{ $attributes->merge(['class' => 'relative flex items-start gap-3.5 p-4 rounded-xl border ' . $cfg['container']]) }}
     role="alert">
    {{-- Icon --}}
    <div class="shrink-0 w-9 h-9 rounded-lg {{ $cfg['iconBg'] }} flex items-center justify-center">
        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $cfg['icon'] !!}</svg>
    </div>

    {{-- Content --}}
    <div class="flex-1 min-w-0 pt-0.5">
        @if($title)
            <p class="text-[13px] font-semibold leading-snug">{{ $title }}</p>
        @endif
        <div class="text-[13px] opacity-90 leading-relaxed {{ $title ? 'mt-1' : '' }}">
            {{ $slot }}
        </div>
    </div>

    {{-- Close --}}
    @if($dismissible)
        <button @click="show = false" type="button"
            class="shrink-0 p-1 rounded-lg opacity-50 hover:opacity-100 transition-opacity"
            aria-label="Tutup">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    @endif
</div>
