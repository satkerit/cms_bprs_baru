@props(['heroSlides', 'heroSlideImages' => [], 'heroSliderDelay' => 5000])

<!-- Hero Slider - Contained Design -->
@if($heroSlides->count() > 0)
<section class="relative overflow-hidden" aria-label="Hero Banner"
         x-data="heroSlider({{ $heroSliderDelay }})"
         x-init="total = {{ $heroSlides->count() }}">
    <input type="hidden" x-ref="slideCount" value="{{ $heroSlides->count() }}">

    <div class="relative group rounded-2xl overflow-hidden shadow-lg"
             role="region"
             aria-label="Hero slider"
             @mouseover="stopAutoplay()"
             @mouseleave="startAutoplay()"
             @touchstart="handleTouchStart($event)"
             @touchend="handleTouchEnd($event)">

            <!-- Hero Slider Container dengan Hybrid Aspect Ratio -->
            <div class="relative w-full overflow-hidden hero-slider-hybrid">

            @foreach($heroSlides as $index => $slide)
            <!-- Slide Wrapper -->
            <div class="absolute inset-0 w-full h-full transition-all duration-500 ease-out"
                 :class="active === {{ $index }} ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                @if($slide->image)
                @php
                    $slideImgs = $heroSlideImages[$slide->id] ?? [];
                    $compressedImage = $slideImgs['compressed'] ?? $slide->image;
                    $webpImages = $slideImgs['webp_responsive'] ?? [];
                    $avifImages = $slideImgs['avif_responsive'] ?? [];
                @endphp
                <!-- Picture wrapper - MUST fill 100% height to work with aspect-ratio -->
                <picture class="block w-full h-full">
                    {{-- AVIF sources --}}
                    @if(isset($avifImages['mobile']))
                    <source media="(max-width: 640px)"
                            srcset="{{ \App\Helpers\StorageHelper::url($avifImages['mobile']) }}"
                            type="image/avif">
                    @endif
                    @if(isset($avifImages['tablet']))
                    <source media="(max-width: 1024px)"
                            srcset="{{ \App\Helpers\StorageHelper::url($avifImages['tablet']) }}"
                            type="image/avif">
                    @endif
                    @if(isset($avifImages['desktop']))
                    <source media="(min-width: 1025px)"
                            srcset="{{ \App\Helpers\StorageHelper::url($avifImages['desktop']) }}"
                            type="image/avif">
                    @endif
                    {{-- WebP sources --}}
                    @if(isset($webpImages['mobile']))
                    <source media="(max-width: 640px)"
                            srcset="{{ \App\Helpers\StorageHelper::url($webpImages['mobile']) }}"
                            type="image/webp">
                    @endif
                    @if(isset($webpImages['tablet']))
                    <source media="(max-width: 1024px)"
                            srcset="{{ \App\Helpers\StorageHelper::url($webpImages['tablet']) }}"
                            type="image/webp">
                    @endif
                    @if(isset($webpImages['desktop']))
                    <source media="(min-width: 1025px)"
                            srcset="{{ \App\Helpers\StorageHelper::url($webpImages['desktop']) }}"
                            type="image/webp">
                    @endif
                    {{-- Fallback --}}
                    <img src="{{ \App\Helpers\StorageHelper::url($compressedImage) }}"
                         alt=""
                         class="w-full h-full object-cover object-center"
                         loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                         decoding="async"
                         @if($index === 0)
                         fetchpriority="high"
                         @endif>
                </picture>
                @else
                <div class="w-full h-full bg-emerald-900"></div>
                @endif

                <!-- Content Overlay -->
                <div class="absolute inset-0 hero-slider-overlay"></div>
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="sm:max-w-3xl lg:max-w-4xl">
                            <!-- Badge -->
                            @if(($slide->show_title ?? true) && $slide->title)
                            <div class="mb-2 sm:mb-3 transform transition-all duration-500 delay-100"
                                 :class="active === {{ $index }} ? 'translate-y-0 opacity-100' : 'translate-y-6 opacity-0'">
                                <span class="inline-flex items-center px-3 py-1 sm:px-4 sm:py-1.5 bg-white/15 text-white text-xs sm:text-sm font-semibold rounded-full border border-white/25 backdrop-blur-sm">
                                    {{ $slide->title }}
                                </span>
                            </div>
                            @endif

                            <!-- Main Heading -->
                            <h1 class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-white leading-tight tracking-tight mb-2 sm:mb-3 drop-shadow-lg transform transition-all duration-500 delay-150"
                                :class="active === {{ $index }} ? 'translate-y-0 opacity-100' : 'translate-y-8 opacity-0'">
                                {{ $slide->subtitle ?? $slide->title }}
                            </h1>

                            <!-- Subtitle / Description -->
                            @if(($slide->show_subtitle ?? true) && ($slide->subtitle ?? $slide->title) && $slide->title && $slide->title !== ($slide->subtitle ?? ''))
                            <p class="text-sm sm:text-base text-white/80 leading-relaxed mb-4 sm:mb-5 drop-shadow transform transition-all duration-500 delay-200"
                               :class="active === {{ $index }} ? 'translate-y-0 opacity-100' : 'translate-y-8 opacity-0'">
                                {{ $slide->subtitle }}
                            </p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- CTA Button - Positioned at Bottom Right -->
                @if(($slide->show_button ?? true) && $slide->link_url)
                <div class="absolute bottom-6 sm:bottom-8 right-4 sm:right-6 lg:right-8 z-20 transform transition-all duration-500 delay-300"
                     :class="active === {{ $index }} ? 'translate-y-0 opacity-100' : 'translate-y-4 opacity-0'">
                    <a href="{{ $slide->link_url }}"
                       class="group/btn inline-flex items-center gap-2 px-4 py-2.5 sm:px-5 sm:py-3
                              bg-emerald-600 hover:bg-emerald-700
                              text-white text-xs sm:text-base font-bold rounded-lg
                              shadow hover:shadow-md
                              transition-all duration-300 border border-emerald-600">
                        <span>{{ $slide->link_text ?? 'Selengkapnya' }}</span>
                        <svg class="w-4 h-4 transform group-hover/btn:translate-x-1 transition-transform flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                </div>
                @endif
            </div>
            @endforeach

                <!-- Navigation Arrows -->
                @if($heroSlides->count() > 1)
                <button @click="prev()"
                        aria-label="Slide sebelumnya"
                        class="absolute left-4 top-1/2 -translate-y-1/2 z-30
                               w-10 h-10 sm:w-12 sm:h-12
                               bg-white/20 hover:bg-white/30
                               rounded-full shadow-lg
                               flex items-center justify-center
                               transition-all duration-200 hover:scale-110
                               opacity-0 group-hover:opacity-100
                               border border-white/20 focus:outline-none focus-visible:ring-2 focus-visible:ring-white
                               touch-manipulation min-w-[44px] min-h-[44px]">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button @click="next()"
                        aria-label="Slide berikutnya"
                        class="absolute right-4 top-1/2 -translate-y-1/2 z-30
                               w-10 h-10 sm:w-12 sm:h-12
                               bg-white/20 hover:bg-white/30
                               rounded-full shadow-lg
                               flex items-center justify-center
                               transition-all duration-200 hover:scale-110
                               opacity-0 group-hover:opacity-100
                               border border-white/20 focus:outline-none focus-visible:ring-2 focus-visible:ring-white
                               touch-manipulation min-w-[44px] min-h-[44px]">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                <!-- Dot Indicators -->
                <div class="absolute bottom-4 sm:bottom-6 left-1/2 -translate-x-1/2 z-30 flex items-center gap-2">
                    @foreach($heroSlides as $index => $slide)
                    <button @click="goTo({{ $index }})"
                            aria-label="Slide {{ $index + 1 }}"
                            :aria-current="active === {{ $index }} ? 'true' : 'false'"
                            class="relative flex items-center justify-center transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 rounded-full touch-manipulation min-w-[32px] min-h-[32px]"
                            :class="active === {{ $index }} ? 'scale-100' : 'scale-90 hover:scale-100'">
                        <span class="absolute w-5 h-5 rounded-full border-2 transition-all duration-300"
                              :class="active === {{ $index }} ? 'border-emerald-600 scale-100 opacity-100' : 'border-transparent scale-0 opacity-0'"></span>
                        <span class="h-2 rounded-full transition-all duration-300"
                              :class="active === {{ $index }} ? 'bg-emerald-600 w-6' : 'bg-white/60 hover:bg-white/80 w-2'"></span>
                    </button>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endif
