@php $accent = $accent ?? 'emerald'; @endphp

{{-- ═══ BOARD MEMBER CARD ═══ --}}
<article class="group flex flex-col items-center text-center">

    {{-- Photo --}}
    <div class="relative w-full mb-4">
        <div class="relative aspect-[3/4] overflow-hidden rounded-2xl
                    ring-1 ring-black/5 dark:ring-white/10
                    shadow-lg group-hover:shadow-2xl
                    group-hover:shadow-{{ $accent }}-500/20
                    transition-all duration-500 ease-[cubic-bezier(0.32,0.72,0,1)]">

            {{-- Background gradient fallback --}}
            <div class="absolute inset-0 bg-gradient-to-br
                @if($accent === 'amber') from-amber-800 via-amber-700 to-amber-900
                @else from-emerald-800 via-emerald-700 to-emerald-900
                @endif"></div>

            {{-- Subtle pattern --}}
            <div class="absolute inset-0 opacity-[0.07]"
                 style="background-image: radial-gradient(circle, white 1px, transparent 1px); background-size: 20px 20px;"></div>

            {{-- Photo --}}
            @if($member->photo)
            <div class="absolute inset-0">
                <x-optimized-image
                    src="{{ \App\Helpers\StorageHelper::url($member->photo) }}"
                    alt="{{ $member->name }}"
                    class="w-full h-full object-cover object-top
                           scale-100 group-hover:scale-[1.04]
                           transition-transform duration-700 ease-[cubic-bezier(0.32,0.72,0,1)]"
                    :lazy="$index >= 4"
                    :priority="$index < 4"
                    aspect-ratio="3/4"
                />
            </div>
            @else
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-24 h-24 rounded-full bg-white/15 backdrop-blur-sm ring-2 ring-white/25 flex items-center justify-center">
                    <svg class="w-12 h-12 text-white/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
            </div>
            @endif

            {{-- Bottom vignette --}}
            <div class="absolute inset-x-0 bottom-0 h-1/3 bg-gradient-to-t from-black/60 to-transparent"></div>

            {{-- Hover shimmer --}}
            <div class="absolute inset-0
                @if($accent === 'amber') bg-amber-500/10
                @else bg-emerald-500/10
                @endif
                opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        </div>

        {{-- Position badge — floats below photo --}}
        <div class="absolute -bottom-3 left-1/2 -translate-x-1/2 z-10">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider whitespace-nowrap shadow-md
                @if($accent === 'amber')
                    bg-amber-500 text-white
                @else
                    bg-emerald-600 text-white
                @endif">
                {{ $member->position }}
            </span>
        </div>
    </div>

    {{-- Name --}}
    <div class="mt-4 px-1">
        <h3 class="text-sm sm:text-base font-semibold text-foreground dark:text-slate-100 leading-snug line-clamp-2
                   group-hover:text-{{ $accent }}-600 dark:group-hover:text-{{ $accent }}-400
                   transition-colors duration-300">
            {{ $member->name }}
        </h3>
    </div>

</article>
