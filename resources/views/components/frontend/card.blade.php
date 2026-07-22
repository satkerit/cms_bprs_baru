@props(['title', 'subtitle' => null, 'image' => null, 'href' => '#'])

<div class="group bg-white rounded-xl border border-border shadow-sm overflow-hidden flex flex-col h-full transition-colors hover:border-emerald-600">

    @if($image)
    <div class="relative overflow-hidden aspect-video border-b border-border">
        <img
            src="{{ $image }}"
            alt="{{ $title }}"
            class="absolute inset-0 w-full h-full object-cover"
            loading="lazy"
            decoding="async"
            width="400" height="225"
        />
        @if($subtitle)
        <div class="absolute top-3 left-3 z-10">
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700">
                {{ $subtitle }}
            </span>
        </div>
        @endif
    </div>
    @endif

    <div class="flex flex-col flex-1 p-5">
        @if(!$image && $subtitle)
            <span class="inline-flex items-center self-start px-2.5 py-1 rounded text-xs font-semibold bg-muted text-secondary mb-3">{{ $subtitle }}</span>
        @endif

        <h3 class="text-base font-bold mb-2 text-foreground leading-snug group-hover:text-emerald-600 transition-colors duration-200">
            {{ $title }}
        </h3>

        <div class="text-secondary text-sm leading-relaxed flex-1 mb-5">
            {{ $slot }}
        </div>

        <div class="pt-4 border-t border-border">
            <a href="{{ $href }}" class="font-semibold inline-flex items-center gap-1.5 text-emerald-600 text-sm hover:text-emerald-700 transition-colors">
                Selengkapnya
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="transition-transform duration-300 group-hover:translate-x-1">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</div>
