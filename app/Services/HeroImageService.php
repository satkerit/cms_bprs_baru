<?php

namespace App\Services;

use App\Models\HeroSliderSettings;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class HeroImageService
{
    protected $imageManager;
    protected $settings;

    // Default definisi ukuran responsif dengan kualitas optimal
    protected $responsiveSizes = [
        'desktop_large' => ['width' => 1920, 'height' => 800, 'quality' => 88],
        'desktop_medium' => ['width' => 1440, 'height' => 600, 'quality' => 88],
        'desktop_small' => ['width' => 1024, 'height' => 427, 'quality' => 85],
        'tablet' => ['width' => 768, 'height' => 480, 'quality' => 82],
        'mobile_large' => ['width' => 480, 'height' => 360, 'quality' => 80],
        'mobile_small' => ['width' => 320, 'height' => 240, 'quality' => 78],
    ];

    public function __construct()
    {
        $this->imageManager = new ImageManager(new Driver());
        $this->settings = HeroSliderSettings::getSettings();
    }

    /**
     * Upload dan generate semua ukuran responsif dengan format modern
     * Menggunakan scaleDown + resizeCanvas agar gambar TIDAK terpotong (letterbox/pillarbox)
     */
    public function uploadHeroImage(UploadedFile $file, string $filename = null): array
    {
        // Validasi gambar dengan settings dinamis
        $this->validateImage($file);

        // Generate filename jika tidak disediakan
        if (!$filename) {
            $filename = time() . '_' . uniqid();
        }

        $uploadedImages = [];

        // Load gambar original
        $image = $this->imageManager->read($file->getPathname());

        // Generate setiap ukuran dengan format modern
        foreach ($this->responsiveSizes as $sizeName => $config) {
            // Clone image untuk diresize
            $resizedImage = $image->clone();

            // Step 1: Scale down proporsional agar muat dalam target
            $resizedImage->scaleDown(
                width: $config['width'],
                height: $config['height']
            );

            // Step 2: Tambah kanvas dengan background hitam agar ukuran pas tanpa crop
            $resizedImage->resizeCanvas(
                width: $config['width'],
                height: $config['height'],
                anchor: 'center',
                background: '#000000'
            );

            // Generate AVIF (format paling efisien)
            try {
                $avifPath = "hero-images/{$filename}_{$sizeName}.avif";
                $avifEncoded = $resizedImage->toAvif($config['quality']);
                Storage::disk('public')->put($avifPath, $avifEncoded);
                $uploadedImages[$sizeName]['avif'] = $avifPath;
            } catch (\Exception $e) {
                // AVIF might not be supported, skip silently
            }

            // Generate WebP (format modern dan efisien)
            $webpPath = "hero-images/{$filename}_{$sizeName}.webp";
            $webpEncoded = $resizedImage->toWebp($config['quality']);
            Storage::disk('public')->put($webpPath, $webpEncoded);

            // Generate JPG fallback dengan kualitas optimal
            $jpgPath = "hero-images/{$filename}_{$sizeName}.jpg";
            $jpgEncoded = $resizedImage->toJpeg($config['quality'], progressive: true);
            Storage::disk('public')->put($jpgPath, $jpgEncoded);

            $uploadedImages[$sizeName] = array_merge($uploadedImages[$sizeName] ?? [], [
                'webp' => $webpPath,
                'jpg' => $jpgPath,
                'width' => $config['width'],
                'height' => $config['height'],
                'quality' => $config['quality']
            ]);
        }

        return $uploadedImages;
    }

    /**
     * Validasi gambar sebelum upload menggunakan settings dinamis
     */
    protected function validateImage(UploadedFile $file): void
    {
        // Cek ukuran minimum
        $imageSize = getimagesize($file->getPathname());
        if ($imageSize[0] < $this->settings->min_width || $imageSize[1] < $this->settings->min_height) {
            throw new \InvalidArgumentException(
                "Gambar terlalu kecil. Minimum {$this->settings->min_width}×{$this->settings->min_height}px"
            );
        }

        // Cek ukuran maksimum
        if ($imageSize[0] > $this->settings->max_width || $imageSize[1] > $this->settings->max_height) {
            throw new \InvalidArgumentException(
                "Gambar terlalu besar. Maksimum {$this->settings->max_width}×{$this->settings->max_height}px"
            );
        }

        // Cek ukuran file
        $maxBytes = $this->settings->getMaxFileSizeBytes();
        if ($file->getSize() > $maxBytes) {
            throw new \InvalidArgumentException(
                "File terlalu besar. Maksimum {$this->settings->max_file_size_mb}MB"
            );
        }
    }

    /**
     * Generate HTML picture element dengan format modern
     */
    public function generatePictureElement(array $images, string $alt = 'Hero Image'): string
    {
        $html = '<picture class="hero-slider">';

        // Desktop Large
        if (isset($images['desktop_large'])) {
            if (isset($images['desktop_large']['avif'])) {
                $html .= '<source media="(min-width: 1920px)" srcset="' . Storage::url($images['desktop_large']['avif']) . '" type="image/avif">';
            }
            $html .= '<source media="(min-width: 1920px)" srcset="' . Storage::url($images['desktop_large']['webp']) . '" type="image/webp">';
            $html .= '<source media="(min-width: 1920px)" srcset="' . Storage::url($images['desktop_large']['jpg']) . '">';
        }

        // Desktop Medium
        if (isset($images['desktop_medium'])) {
            if (isset($images['desktop_medium']['avif'])) {
                $html .= '<source media="(min-width: 1440px)" srcset="' . Storage::url($images['desktop_medium']['avif']) . '" type="image/avif">';
            }
            $html .= '<source media="(min-width: 1440px)" srcset="' . Storage::url($images['desktop_medium']['webp']) . '" type="image/webp">';
            $html .= '<source media="(min-width: 1440px)" srcset="' . Storage::url($images['desktop_medium']['jpg']) . '">';
        }

        // Desktop Small
        if (isset($images['desktop_small'])) {
            if (isset($images['desktop_small']['avif'])) {
                $html .= '<source media="(min-width: 1024px)" srcset="' . Storage::url($images['desktop_small']['avif']) . '" type="image/avif">';
            }
            $html .= '<source media="(min-width: 1024px)" srcset="' . Storage::url($images['desktop_small']['webp']) . '" type="image/webp">';
            $html .= '<source media="(min-width: 1024px)" srcset="' . Storage::url($images['desktop_small']['jpg']) . '">';
        }

        // Tablet
        if (isset($images['tablet'])) {
            if (isset($images['tablet']['avif'])) {
                $html .= '<source media="(min-width: 768px)" srcset="' . Storage::url($images['tablet']['avif']) . '" type="image/avif">';
            }
            $html .= '<source media="(min-width: 768px)" srcset="' . Storage::url($images['tablet']['webp']) . '" type="image/webp">';
            $html .= '<source media="(min-width: 768px)" srcset="' . Storage::url($images['tablet']['jpg']) . '">';
        }

        // Mobile Large
        if (isset($images['mobile_large'])) {
            if (isset($images['mobile_large']['avif'])) {
                $html .= '<source media="(min-width: 480px)" srcset="' . Storage::url($images['mobile_large']['avif']) . '" type="image/avif">';
            }
            $html .= '<source media="(min-width: 480px)" srcset="' . Storage::url($images['mobile_large']['webp']) . '" type="image/webp">';
            $html .= '<source media="(min-width: 480px)" srcset="' . Storage::url($images['mobile_large']['jpg']) . '">';
        }

        // Mobile Small (default)
        if (isset($images['mobile_small'])) {
            if (isset($images['mobile_small']['avif'])) {
                $html .= '<source srcset="' . Storage::url($images['mobile_small']['avif']) . '" type="image/avif">';
            }
            $html .= '<source srcset="' . Storage::url($images['mobile_small']['webp']) . '" type="image/webp">';
            $html .= '<img src="' . Storage::url($images['mobile_small']['jpg']) . '" alt="' . htmlspecialchars($alt, ENT_QUOTES, 'UTF-8') . '" loading="lazy">';
        }

        $html .= '</picture>';

        return $html;
    }

    /**
     * Hapus semua ukuran gambar
     */
    public function deleteHeroImages(array $images): void
    {
        foreach ($images as $sizeImages) {
            if (isset($sizeImages['webp'])) {
                Storage::disk('public')->delete($sizeImages['webp']);
            }
            if (isset($sizeImages['jpg'])) {
                Storage::disk('public')->delete($sizeImages['jpg']);
            }
        }
    }
}
