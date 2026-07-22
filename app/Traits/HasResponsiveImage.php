<?php

namespace App\Traits;

use App\Services\ImageService;

trait HasResponsiveImage
{
    /**
     * Get responsive image URLs
     */
    public function getResponsiveUrls()
    {
        return ImageService::getResponsiveUrls($this->image);
    }

    /**
     * Get srcset for responsive images
     */
    public function getSrcset()
    {
        return ImageService::getSrcset($this->image);
    }

    /**
     * Get image URL for specific size
     */
    public function getImageUrl($size = 'large')
    {
        return ImageService::getImageForSize($this->image, $size);
    }

    /**
     * Get the main image URL (fallback to Storage if no responsive images)
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        // Try to get the large size, fallback to original
        $urls = $this->getResponsiveUrls();
        return $urls['large'] ?? $urls['original'] ?? asset('storage/' . $this->image);
    }

    /**
     * Get all available image sizes with their URLs
     */
    public function getImageSizes()
    {
        return $this->getResponsiveUrls();
    }
}
