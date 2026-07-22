@props([
    'icon' => 'document',
    'title' => 'Tidak ada data',
    'description' => null,
    'action' => null,
    'actionUrl' => null,
    'actionLabel' => 'Tambah Data',
])

@php
    $icons = [
        'document' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>',
        'search' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>',
        'inbox' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>',
        'users' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>',
        'image' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
        'star' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/>',
        'clock' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>',
    ];
@endphp

<div {{ $attributes->merge(['class' => 'py-12 px-6 text-center']) }}>
    {{-- Icon with decorative bg --}}
    <div class="relative w-20 h-20 mx-auto mb-5">
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-50 via-emerald-50/50 to-transparent rounded-2xl"></div>
        <div class="absolute inset-2 bg-white rounded-xl flex items-center justify-center shadow-sm ring-1 ring-emerald-100/50">
            <svg class="w-9 h-9 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $icons[$icon] ?? $icons['document'] !!}
            </svg>
        </div>
    </div>

    {{-- Title --}}
    <h3 class="text-[15px] font-semibold text-slate-900 mb-1">{{ $title }}</h3>

    {{-- Description --}}
    @if($description)
        <p class="text-[13px] text-slate-500 max-w-sm mx-auto leading-relaxed">{{ $description }}</p>
    @endif

    {{-- Action Button --}}
    @if($action || $actionUrl)
        <div class="mt-6">
            @if($action)
                {{ $action }}
            @elseif($actionUrl)
                <a href="{{ $actionUrl }}"
                   class="btn-primary inline-flex items-center gap-2 px-5 py-2.5 text-sm no-underline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                    {{ $actionLabel }}
                </a>
            @endif
        </div>
    @endif
</div>
