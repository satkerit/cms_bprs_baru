@props(['heroSlides', 'heroSlideImages' => [], 'heroSliderDelay' => 5000])

<!-- Hero Slider - Contained Design -->
@if($heroSlides->count() > 0)
<section class="relative overflow-hidden" aria-label="Hero Banner">
    <div class="relative group rounded-2xl overflow-hidden shadow-lg"
         role="region"
         aria-label="Hero slider"
         id="hero-slider"
         data-delay="{{ $heroSliderDelay }}"
         data-total="{{ $heroSlides->count() }}">

            <!-- Hero Slider Container -->
            <div class="relative w-full overflow-hidden hero-slider-hybrid">

            @foreach($heroSlides as $index => $slide)
            @php $isActive = $index === 0; @endphp
            <!-- Slide Wrapper -->
            <div class="hero-slide absolute inset-0 w-full h-full transition-all duration-500 ease-out {{ $isActive ? 'opacity-100 z-10 active' : 'opacity-0 z-0' }}"
                 data-index="{{ $index }}">
                @if($slide->image)
                @php
                    $slideImgs = $heroSlideImages[$slide->id] ?? [];
                    $compressedImage = $slideImgs['compressed'] ?? $slide->image;
                    $webpImages = $slideImgs['webp_responsive'] ?? [];
                    $avifImages = $slideImgs['avif_responsive'] ?? [];
                    $focalX = $slide->focal_x ?? 50;
                    $focalY = $slide->focal_y ?? 50;
                    $objectPosition = "{$focalX}% {$focalY}%";
                    @endphp
                    <picture class="block w-full h-full">
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
                        <img src="{{ \App\Helpers\StorageHelper::url($compressedImage) }}"
                             alt=""
                             class="w-full h-full object-cover"
                             style="object-position: {{ $objectPosition }};"
                             loading="{{ $isActive ? 'eager' : 'lazy' }}"
                             decoding="async"
                             @if($isActive)
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
                            @if(($slide->show_title ?? true) && $slide->title)
                            <div class="hero-content mb-2 sm:mb-3 transform transition-all duration-500 delay-100 {{ $isActive ? 'translate-y-0 opacity-100' : 'translate-y-6 opacity-0' }}"
                                 data-hide="translate-y-6 opacity-0">
                                <span class="inline-flex items-center px-3 py-1 sm:px-4 sm:py-1.5 bg-white/15 text-white text-xs sm:text-sm font-semibold rounded-full border border-white/25 backdrop-blur-sm">
                                    {{ $slide->title }}
                                </span>
                            </div>
                            @endif

                            <h1 class="hero-content text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold text-white leading-tight tracking-tight mb-2 sm:mb-3 drop-shadow-lg transform transition-all duration-500 delay-150 {{ $isActive ? 'translate-y-0 opacity-100' : 'translate-y-8 opacity-0' }}"
                                data-hide="translate-y-8 opacity-0">
                                {{ $slide->subtitle ?? $slide->title }}
                            </h1>

                            @if(($slide->show_subtitle ?? true) && ($slide->subtitle ?? $slide->title) && $slide->title && $slide->title !== ($slide->subtitle ?? ''))
                            <p class="hero-content text-sm sm:text-base text-white/80 leading-relaxed mb-4 sm:mb-5 drop-shadow transform transition-all duration-500 delay-200 {{ $isActive ? 'translate-y-0 opacity-100' : 'translate-y-8 opacity-0' }}"
                               data-hide="translate-y-8 opacity-0">
                                {{ $slide->subtitle }}
                            </p>
                            @endif
                        </div>
                    </div>
                </div>

                @if(($slide->show_button ?? true) && $slide->link_url)
                <div class="hero-content absolute bottom-6 sm:bottom-8 right-4 sm:right-6 lg:right-8 z-20 transform transition-all duration-500 delay-300 {{ $isActive ? 'translate-y-0 opacity-100' : 'translate-y-4 opacity-0' }}"
                     data-hide="translate-y-4 opacity-0">
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
                <button class="hero-prev absolute left-4 top-1/2 -translate-y-1/2 z-30
                       w-10 h-10 sm:w-12 sm:h-12
                       bg-white/20 hover:bg-white/30
                       rounded-full shadow-lg
                       flex items-center justify-center
                       transition-all duration-200 hover:scale-110
                       opacity-0 group-hover:opacity-100
                       border border-white/20 focus:outline-none focus-visible:ring-2 focus-visible:ring-white
                       touch-manipulation min-w-[44px] min-h-[44px]"
                        aria-label="Slide sebelumnya">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button class="hero-next absolute right-4 top-1/2 -translate-y-1/2 z-30
                       w-10 h-10 sm:w-12 sm:h-12
                       bg-white/20 hover:bg-white/30
                       rounded-full shadow-lg
                       flex items-center justify-center
                       transition-all duration-200 hover:scale-110
                       opacity-0 group-hover:opacity-100
                       border border-white/20 focus:outline-none focus-visible:ring-2 focus-visible:ring-white
                       touch-manipulation min-w-[44px] min-h-[44px]"
                        aria-label="Slide berikutnya">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                <!-- Dot Indicators -->
                <div class="absolute bottom-4 sm:bottom-6 left-1/2 -translate-x-1/2 z-30 flex items-center gap-2">
                    @foreach($heroSlides as $index => $slide)
                    <button class="hero-dot relative flex items-center justify-center transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-emerald-600 rounded-full touch-manipulation min-w-[32px] min-h-[32px]"
                            data-index="{{ $index }}"
                            aria-label="Slide {{ $index + 1 }}"
                            @if($index === 0) aria-current="true" @endif>
                        <span class="absolute w-5 h-5 rounded-full border-2 transition-all duration-300 {{ $index === 0 ? 'border-emerald-600 scale-100 opacity-100' : 'border-transparent scale-0 opacity-0' }}"></span>
                        <span class="h-2 rounded-full transition-all duration-300 {{ $index === 0 ? 'bg-emerald-600 w-6' : 'bg-white/60 hover:bg-white/80 w-2' }}"></span>
                    </button>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
</section>

@push('scripts')
<script nonce="{{ $nonce }}">
(function(){'use strict';
    var el=document.getElementById('hero-slider');
    if(!el)return;
    var slides=el.querySelectorAll('.hero-slide'),dots=el.querySelectorAll('.hero-dot'),
        prev=el.querySelector('.hero-prev'),next=el.querySelector('.hero-next'),
        total=parseInt(el.dataset.total),delay=parseInt(el.dataset.delay)||5000,
        active=0,timer=null,animating=false,tsx=0;

    function goTo(i){
        if(animating||i===active||i<0||i>=total)return;
        animating=true;
        // Hide content on current slide
        slides[active].querySelectorAll('.hero-content').forEach(function(c){
            c.classList.remove('translate-y-0','opacity-100');
            if(c.dataset.hide)c.classList.add.apply(c.classList,c.dataset.hide.split(' '));
        });
        setTimeout(function(){
            slides[active].classList.remove('opacity-100','z-10','active');
            slides[active].classList.add('opacity-0','z-0');
            slides[i].classList.remove('opacity-0','z-0');
            slides[i].classList.add('opacity-100','z-10','active');
            // Show content on new slide
            slides[i].querySelectorAll('.hero-content').forEach(function(c){
                if(c.dataset.hide)c.classList.remove.apply(c.classList,c.dataset.hide.split(' '));
                c.classList.add('translate-y-0','opacity-100');
            });
            // Update dots
            dots.forEach(function(d,idx){
                if(idx===i){
                    d.setAttribute('aria-current','true');
                    var r=d.querySelector('span:first-child'),b=d.querySelector('span:last-child');
                    if(r)r.className='absolute w-5 h-5 rounded-full border-2 transition-all duration-300 border-emerald-600 scale-100 opacity-100';
                    if(b)b.className='h-2 rounded-full transition-all duration-300 bg-emerald-600 w-6';
                }else{
                    d.removeAttribute('aria-current');
                    var r=d.querySelector('span:first-child'),b=d.querySelector('span:last-child');
                    if(r)r.className='absolute w-5 h-5 rounded-full border-2 transition-all duration-300 border-transparent scale-0 opacity-0';
                    if(b)b.className='h-2 rounded-full transition-all duration-300 bg-white/60 hover:bg-white/80 w-2';
                }
            });
            active=i;
            setTimeout(function(){animating=false;},500);
        },250);
    }
    function nextSlide(){goTo((active+1)%total);}
    function prevSlide(){goTo((active-1+total)%total);}
    function start(){clearInterval(timer);if(total>1)timer=setInterval(nextSlide,delay);}
    function stop(){clearInterval(timer);}

    if(prev)prev.addEventListener('click',function(e){e.preventDefault();prevSlide();start();},false);
    if(next)next.addEventListener('click',function(e){e.preventDefault();nextSlide();start();},false);
    dots.forEach(function(d){d.addEventListener('click',function(){var i=parseInt(this.dataset.index);goTo(i);start();},false);});

    el.addEventListener('mouseenter',stop,false);
    el.addEventListener('mouseleave',start,false);
    el.addEventListener('touchstart',function(e){tsx=e.changedTouches[0].screenX;stop();},{passive:true});
    el.addEventListener('touchend',function(e){var d=tsx-e.changedTouches[0].screenX;if(Math.abs(d)>50)d>0?nextSlide():prevSlide();start();},{passive:true});

    start();
})();
</script>
@endpush
@endif
