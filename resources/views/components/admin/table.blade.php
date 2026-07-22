@props([
    'headers' => [],
    'striped' => false,
    'compact' => false,
    'hoverable' => true,
])

@php
    $cellPadding = $compact ? 'px-4 py-2.5' : 'px-5 py-3.5';
    $firstCellPadding = $compact ? 'pl-5 pr-4 py-2.5' : 'pl-6 pr-5 py-3.5';
    $lastCellPadding = $compact ? 'pl-4 pr-5 py-2.5' : 'pl-5 pr-6 py-3.5';
    $rowHoverClass = $hoverable ? 'hover:bg-emerald-50/30 transition-colors duration-150' : '';
@endphp

<div class="relative overflow-hidden rounded-xl border border-slate-200/70 bg-white shadow-sm ring-1 ring-slate-900/5">
    <div class="overflow-x-auto -mx-[1px]">
        <table class="w-full border-collapse">
            @if(count($headers) > 0)
                <thead>
                    <tr>
                        @foreach($headers as $i => $header)
                            <th scope="col"
                                class="{{ $i === 0 ? $firstCellPadding : ($i === count($headers) - 1 ? $lastCellPadding : $cellPadding) }}
                                       text-left text-[11px] font-semibold text-slate-500 uppercase tracking-[0.06em] leading-4
                                       bg-gradient-to-b from-slate-50 to-slate-50/80 border-b border-slate-200/70
                                       whitespace-nowrap select-none">
                                <div class="flex items-center gap-2">
                                    @if($i === 0)
                                        <div class="w-0.5 h-3.5 rounded-full bg-gradient-to-b from-emerald-500 to-emerald-600 shrink-0"></div>
                                    @endif
                                    <span>{{ $header }}</span>
                                </div>
                            </th>
                        @endforeach
                    </tr>
                </thead>
            @endif
            <tbody class="divide-y divide-slate-100/80 @if($striped) [&>tr:nth-child(even)]:bg-slate-50/40 @endif">
                @php
                    $slotHtml = (string) $slot;
                    if ($hoverable) {
                        $slotHtml = preg_replace('/<tr(\s|>)/', '<tr class="'.$rowHoverClass.'"$1', $slotHtml);
                    }
                @endphp
                {!! $slotHtml !!}
            </tbody>
        </table>
    </div>
</div>
