@props([
    'title',
    'subtitle' => null,
    'image' => null,
    'href' => null,
    'class' => '',
    'children' => null,
])

{{-- ═══ DOUBLE-BEZEL Premium Card ═══ --}}
<div class="group {{ $class }}">
    <div class="double-bezel">
        <div class="double-bezel-inner">
            @if($href)
            <a href="{{ $href }}" class="block no-underline">
            @endif
                @if($image)
                <div class="relative overflow-hidden" style="border-radius: var(--radius-double-inner) var(--radius-double-inner) 0 0;">
                    <img src="{{ $image }}"
                         alt="{{ $title }}"
                         class="w-full aspect-[16/10] object-cover transition-all duration-700 ease-[cubic-bezier(0.32,0.72,0,1)] group-hover:scale-105"
                         loading="lazy"
                         decoding="async">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                </div>
                @endif
                <div class="p-5 sm:p-6">
                    @if($subtitle)
                    <span class="text-[10px] uppercase tracking-[0.2em] font-semibold text-emerald-600 dark:text-emerald-400 mb-2 block">{{ $subtitle }}</span>
                    @endif
                    <h3 class="text-lg font-bold text-foreground dark:text-slate-100 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition-colors duration-300 leading-tight">{{ $title }}</h3>
                    @if($children ?? false)
                    <p class="text-sm text-secondary dark:text-slate-400 mt-2 leading-relaxed">{{ $children }}</p>
                    @endif
                    @if($href)
                    <div class="mt-4 flex items-center gap-1.5 text-emerald-600 dark:text-emerald-400 font-semibold text-sm group-hover:gap-2.5 transition-all duration-300">
                        <span>Selengkapnya</span>
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </div>
                    @endif
                </div>
            @if($href)
            </a>
            @endif
        </div>
    </div>
</div>
