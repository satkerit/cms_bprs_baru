@props(['rows' => 5, 'columns' => 4])
@php
    $gridCols = match($columns) {
        6 => 'grid-cols-6',
        5 => 'grid-cols-5',
        4 => 'grid-cols-4',
        3 => 'grid-cols-3',
        default => 'grid-cols-4',
    };
    $firstColSpan = match($columns) {
        6 => 'col-span-2',
        5 => 'col-span-3',
        4 => 'col-span-3',
        3 => 'col-span-4',
        default => 'col-span-3',
    };
@endphp
<div class="p-6 space-y-4">
    {{-- Header skeleton --}}
    <div class="h-10 bg-gradient-to-r from-zinc-100 via-zinc-50 to-zinc-100 rounded-xl animate-pulse"></div>
    {{-- Rows --}}
    @for($i = 0; $i < $rows; $i++)
        <div class="grid {{ $gridCols }} gap-4">
            @for($j = 0; $j < min($columns, 6); $j++)
                <div class="{{ $j === 0 ? $firstColSpan : '' }}">
                    <div class="h-4 bg-gradient-to-r from-zinc-100 via-zinc-50 to-zinc-100 rounded-lg animate-pulse" style="animation-delay: {{ $i * 100 }}ms"></div>
                </div>
            @endfor
        </div>
    @endfor
</div>
