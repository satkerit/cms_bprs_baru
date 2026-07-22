@props([
    'src',
    'alt' => '',
    'class' => '',
    'lazy' => true,
    'width' => null,
    'height' => null,
    'sizes' => '100vw',
    'priority' => false,
    'aspectRatio' => null,
    'objectFit' => 'cover',
])

@php
    use App\Services\ImageService;
    use App\Helpers\StorageHelper;

    $loadingAttr = $priority ? 'eager' : ($lazy ? 'lazy' : 'eager');
    $fetchPriority = $priority ? 'high' : 'auto';
    $decodingAttr = $priority ? 'sync' : 'async';

    // Extract path from full URL if needed
    $imagePath = $src;
    if (str_contains($src, '/storage/')) {
        $imagePath = str_replace('/storage/', '', parse_url($src, PHP_URL_PATH));
    }

    // Get responsive AVIF and WebP versions
    $avifVersions = ImageService::getExistingResponsiveAVIF($imagePath);
    $webpVersions = ImageService::getExistingResponsiveWebP($imagePath);
    $compressedSrc = ImageService::getExistingCompressed($imagePath);
@endphp

<div class="img-aspect-ratio {{ $class }}"
     @if($width && $height) style="aspect-ratio: {{ $width }}/{{ $height }}" @elseif($aspectRatio) style="aspect-ratio: {{ $aspectRatio }}" @endif
     x-data="{ loaded: false }">

    @if(!empty($avifVersions) || !empty($webpVersions))
    {{-- Use picture element for responsive AVIF and WebP --}}
    <picture>
        {{-- AVIF sources for different breakpoints (most modern, smallest size) --}}
        @if(isset($avifVersions['mobile']))
        <source 
            media="(max-width: 640px)"
            srcset="{{ StorageHelper::url($avifVersions['mobile']) }}"
            type="image/avif">
        @endif
        
        @if(isset($avifVersions['tablet']))
        <source 
            media="(min-width: 641px) and (max-width: 1024px)"
            srcset="{{ StorageHelper::url($avifVersions['tablet']) }}"
            type="image/avif">
        @endif
        
        @if(isset($avifVersions['desktop']))
        <source 
            media="(min-width: 1025px)"
            srcset="{{ StorageHelper::url($avifVersions['desktop']) }}"
            type="image/avif">
        @endif
        {{-- WebP sources for different breakpoints --}}
        @if(isset($webpVersions['mobile']))
        <source 
            media="(max-width: 640px)"
            srcset="{{ StorageHelper::url($webpVersions['mobile']) }}"
            type="image/webp">
        @endif
        
        @if(isset($webpVersions['tablet']))
        <source 
            media="(min-width: 641px) and (max-width: 1024px)"
            srcset="{{ StorageHelper::url($webpVersions['tablet']) }}"
            type="image/webp">
        @endif
        
        @if(isset($webpVersions['desktop']))
        <source 
            media="(min-width: 1025px)"
            srcset="{{ StorageHelper::url($webpVersions['desktop']) }}"
            type="image/webp">
        @endif

        {{-- Fallback to compressed JPEG/PNG with progressive loading --}}
        <img
            src="{{ StorageHelper::url($compressedSrc) }}"
            alt="{{ $alt }}"
            loading="{{ $loadingAttr }}"
            decoding="{{ $decodingAttr }}"
            fetchpriority="{{ $fetchPriority }}"
            @if($width) width="{{ $width }}" @endif
            @if($height) height="{{ $height }}" @endif
            class="img-progressive"
            data-loaded="false"
            @@load="loaded = true; $el.classList.add('loaded'); $el.setAttribute('data-loaded', 'true')"
            {{ $attributes->merge(['class' => '']) }}
        >
    </picture>
    @else
    {{-- Fallback jika WebP belum di-generate --}}
    <img
        src="{{ $src }}"
        alt="{{ $alt }}"
        loading="{{ $loadingAttr }}"
        decoding="{{ $decodingAttr }}"
        fetchpriority="{{ $fetchPriority }}"
        @if($width) width="{{ $width }}" @endif
        @if($height) height="{{ $height }}" @endif
        class="img-progressive"
        data-loaded="false"
        @@load="loaded = true; $el.classList.add('loaded'); $el.setAttribute('data-loaded', 'true')"
        {{ $attributes->merge(['class' => '']) }}
    >
    @endif
</div>
