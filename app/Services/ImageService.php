<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ImageService
{
    private static ?ImageManager $manager = null;
    private static ?bool $ffmpegAvailable = null;

    // Breakpoints untuk responsive images
    const BREAKPOINTS = [
        'mobile' => 480,
        'small' => 768,
        'medium' => 1024,
        'large' => 1280,
        'original' => 1920,
    ];

    // Legacy breakpoints (dari ImageCompressionService)
    const LEGACY_BREAKPOINTS = [
        'mobile' => 640,
        'tablet' => 1024,
        'desktop' => 1920,
    ];

    const QUALITY_HIGH = 90;
    const QUALITY_MEDIUM = 85;
    const QUALITY_LOW = 75;

    // ===================== INTERNAL =====================

    protected static function manager(): ImageManager
    {
        if (self::$manager === null) {
            self::$manager = new ImageManager(new Driver());
        }
        return self::$manager;
    }

    protected static function disk()
    {
        return Storage::disk('public');
    }

    // ===================== NEW UNIFIED UPLOAD API =====================

    /**
     * Upload image dan generate responsive variants dalam multiple formats.
     *
     * @param UploadedFile $file
     * @param array $options {
     *     @type array  $sizes    Array of widths, e.g. [1920, 1280, 1024, 768, 480]
     *     @type array  $formats  Output formats, e.g. ['avif', 'webp', 'jpg']
     *     @type string $dir      Storage directory
     *     @type int    $quality  Compression quality (0-100)
     *     @type bool   $optimize Run full optimization pipeline
     * }
     * @return array
     */
    public static function upload(UploadedFile $file, array $options = []): array
    {
        $sizes = $options['sizes'] ?? array_values(self::BREAKPOINTS);
        $formats = $options['formats'] ?? ['avif', 'webp', 'jpg'];
        $dir = $options['dir'] ?? 'uploads';
        $quality = $options['quality'] ?? self::QUALITY_MEDIUM;
        $optimize = $options['optimize'] ?? true;

        $originalMemoryLimit = ini_get('memory_limit');
        $originalTimeLimit = ini_get('max_execution_time');

        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 300);

        try {
            $extension = 'jpg';
            $filename = Str::uuid() . '.' . $extension;
            $originalPath = $dir . '/' . $filename;

            $manager = self::manager();
            $image = $manager->read($file);

            // Save original as JPEG
            $encoded = $image->toJpeg(quality: $quality, progressive: true);
            self::disk()->put($originalPath, (string) $encoded);

            $result = [
                'original' => $originalPath,
                'sizes' => [],
                'webp' => [],
                'avif' => [],
                'jpg' => [],
            ];

            // Map sizes to names
            $sizeNames = array_keys(self::BREAKPOINTS);
            $namedSizes = [];
            foreach ($sizes as $i => $width) {
                $name = $sizeNames[$i] ?? "size_{$i}";
                $namedSizes[$name] = $width;
            }

            foreach ($namedSizes as $name => $width) {
                $resized = clone $image;
                $resized->scaleDown(width: $width);

                // JPEG
                if (in_array('jpg', $formats)) {
                    $jpgPath = $dir . '/' . pathinfo($filename, PATHINFO_FILENAME) . "_{$name}.jpg";
                    $encoded = $resized->toJpeg(quality: $quality, progressive: true);
                    self::disk()->put($jpgPath, (string) $encoded);
                    $result['jpg'][$name] = $jpgPath;
                    $result['sizes'][$name] = $jpgPath;
                }

                // WebP
                if (in_array('webp', $formats)) {
                    try {
                        $webpPath = $dir . '/' . pathinfo($filename, PATHINFO_FILENAME) . "_{$name}.webp";
                        $encoded = $resized->toWebp(quality: $quality);
                        self::disk()->put($webpPath, (string) $encoded);
                        $result['webp'][$name] = $webpPath;
                    } catch (\Throwable $e) {
                        Log::warning("WebP generation failed for {$name}: " . $e->getMessage());
                    }
                }

                // AVIF
                if (in_array('avif', $formats) && self::isAVIFSupported()) {
                    try {
                        $avifPath = $dir . '/' . pathinfo($filename, PATHINFO_FILENAME) . "_{$name}.avif";
                        $encoded = $resized->toAvif(quality: $quality);
                        self::disk()->put($avifPath, (string) $encoded);
                        $result['avif'][$name] = $avifPath;
                    } catch (\Throwable $e) {
                        Log::warning("AVIF generation failed for {$name}: " . $e->getMessage());
                    }
                }
            }

            return $result;
        } finally {
            ini_set('memory_limit', $originalMemoryLimit);
            ini_set('max_execution_time', $originalTimeLimit);
        }
    }

    // ===================== BACKWARD COMPAT: HERO SLIDER =====================

    /**
     * Upload dan resize hero slider image (backward compat)
     */
    public static function uploadHeroSliderImage(UploadedFile $file, $folder = 'hero-slides')
    {
        $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        $path = $folder . '/' . $filename;

        $manager = self::manager();
        $image = $manager->read($file->getPathname());

        $sizes = [
            'original' => ['width' => 1920, 'height' => 1080, 'quality' => 90],
            'large' => ['width' => 1280, 'height' => 720, 'quality' => 85],
            'medium' => ['width' => 1024, 'height' => 576, 'quality' => 85],
            'small' => ['width' => 768, 'height' => 432, 'quality' => 80],
            'mobile' => ['width' => 480, 'height' => 270, 'quality' => 80],
        ];

        $generatedImages = [];

        foreach ($sizes as $sizeName => $config) {
            $resizedImage = clone $image;
            $resizedImage->cover($config['width'], $config['height']);

            $sizeFilename = $sizeName === 'original'
                ? $filename
                : pathinfo($filename, PATHINFO_FILENAME) . '_' . $sizeName . '.' . pathinfo($filename, PATHINFO_EXTENSION);

            $sizePath = $folder . '/' . $sizeFilename;

            $encodedImage = $resizedImage->toJpeg($config['quality']);
            self::disk()->put($sizePath, $encodedImage);

            $generatedImages[$sizeName] = $sizePath;
        }

        return [
            'original' => $generatedImages['original'],
            'sizes' => $generatedImages,
        ];
    }

    /**
     * Delete hero slider images (all sizes) - backward compat
     */
    public static function deleteHeroSliderImage($imagePath)
    {
        if (!$imagePath) {
            return true;
        }

        $disk = self::disk();

        if ($disk->exists($imagePath)) {
            $disk->delete($imagePath);
        }

        $pathInfo = pathinfo($imagePath);
        $baseFilename = $pathInfo['filename'];
        $extension = $pathInfo['extension'];
        $folder = $pathInfo['dirname'];

        $sizes = ['large', 'medium', 'small', 'mobile'];

        foreach ($sizes as $size) {
            $sizeFilename = $baseFilename . '_' . $size . '.' . $extension;
            $sizePath = $folder . '/' . $sizeFilename;

            if ($disk->exists($sizePath)) {
                $disk->delete($sizePath);
            }
        }

        return true;
    }

    // ===================== FULL PROCESSING PIPELINE (dari ImageCompressionService) =====================

    /**
     * Process uploaded image - generate all variants (compressed, WebP, AVIF, responsive JPEG)
     */
    public static function processUploadedImage(string $originalPath, array $options = []): array
    {
        $originalMemoryLimit = ini_get('memory_limit');
        $originalTimeLimit = ini_get('max_execution_time');

        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 300);

        try {
            $disk = self::disk();

            if (!$disk->exists($originalPath)) {
                throw new \Exception("Original image not found: {$originalPath}");
            }

            $manager = self::manager();
            $image = $manager->read($disk->path($originalPath));

            $pathInfo = pathinfo($originalPath);
            $directory = $pathInfo['dirname'];
            $filename = $pathInfo['filename'];
            $fullPath = $disk->path($originalPath);

            $results = [
                'original' => $originalPath,
                'compressed' => [],
                'webp' => [],
                'avif' => [],
                'responsive' => [],
            ];

            // 1. Generate compressed JPEG
            $compressedPath = self::generateCompressed($image, $directory, $filename, $options);
            if ($compressedPath) {
                $results['compressed'] = $compressedPath;
            }

            // 2. Generate AVIF versions for all breakpoints
            $avifVersions = self::generateFormatVersions($image, $directory, $filename, $options, $fullPath, 'avif');
            $results['avif'] = $avifVersions;

            // 3. Generate WebP versions for all breakpoints
            $webpVersions = self::generateFormatVersions($image, $directory, $filename, $options, $fullPath, 'webp');
            $results['webp'] = $webpVersions;

            // 4. Generate responsive JPEG versions
            $responsiveVersions = self::generateResponsiveVersions($image, $directory, $filename, $options);
            $results['responsive'] = $responsiveVersions;

            Log::info('Image processing completed', [
                'original' => $originalPath,
                'variants_created' => count($results['webp']) + count($results['avif']) + count($results['responsive']) + 1,
            ]);

            return $results;
        } catch (\Exception $e) {
            Log::error('Image processing failed: ' . $e->getMessage(), [
                'path' => $originalPath,
                'trace' => $e->getTraceAsString(),
            ]);

            return [
                'original' => $originalPath,
                'compressed' => $originalPath,
                'webp' => [],
                'avif' => [],
                'responsive' => [],
            ];
        } finally {
            ini_set('memory_limit', $originalMemoryLimit);
            ini_set('max_execution_time', $originalTimeLimit);
        }
    }

    /**
     * Generate responsive sizes (WebP + JPEG) for a given image path
     */
    public static function generateResponsiveSizes(string $imagePath): array
    {
        $originalMemoryLimit = ini_get('memory_limit');
        $originalTimeLimit = ini_get('max_execution_time');

        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 300);

        try {
            $disk = self::disk();

            if (!$disk->exists($imagePath)) {
                throw new \Exception("Image not found: {$imagePath}");
            }

            $manager = self::manager();
            $image = $manager->read($disk->path($imagePath));

            $pathInfo = pathinfo($imagePath);
            $directory = $pathInfo['dirname'];
            $filename = $pathInfo['filename'];
            $fullPath = $disk->path($imagePath);

            $results = [
                'webp' => [],
                'jpeg' => [],
            ];

            // Generate WebP versions for all breakpoints
            $results['webp'] = self::generateFormatVersions($image, $directory, $filename, [], $fullPath, 'webp');

            // Generate JPEG responsive versions
            $results['jpeg'] = self::generateResponsiveVersions($image, $directory, $filename, []);

            Log::info('Responsive sizes generated', [
                'path' => $imagePath,
                'webp_count' => count($results['webp']),
                'jpeg_count' => count($results['jpeg']),
            ]);

            return $results;
        } catch (\Exception $e) {
            Log::error('generateResponsiveSizes failed: ' . $e->getMessage(), ['path' => $imagePath]);
            return ['webp' => [], 'jpeg' => []];
        } finally {
            ini_set('memory_limit', $originalMemoryLimit);
            ini_set('max_execution_time', $originalTimeLimit);
        }
    }

    /**
     * Compress an existing image for web (resize + re-encode)
     */
    public static function compressForWeb(string $relativePath, int $quality = 80, int $maxWidth = 1200): ?string
    {
        try {
            $disk = self::disk();

            if (!$disk->exists($relativePath)) {
                return null;
            }

            $manager = self::manager();
            $image = $manager->read($disk->path($relativePath));

            if ($image->width() > $maxWidth) {
                $image->scaleDown(width: $maxWidth);
            }

            $extension = strtolower(pathinfo($relativePath, PATHINFO_EXTENSION));

            $encoded = match ($extension) {
                'webp' => $image->toWebp(quality: $quality),
                'png' => $image->toPng(),
                default => $image->toJpeg(quality: $quality, progressive: true),
            };

            $pathInfo = pathinfo($relativePath);
            $compressedPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '_compressed.' . ($extension === 'webp' ? 'webp' : 'jpg');
            $disk->put($compressedPath, (string) $encoded);

            return $compressedPath;
        } catch (\Exception $e) {
            Log::error('compressForWeb failed: ' . $e->getMessage(), ['path' => $relativePath]);
            return null;
        }
    }

    // ===================== DELETE =====================

    /**
     * Delete all variants of an image
     */
    public static function deleteImage(string $originalPath): void
    {
        $disk = self::disk();
        $pathInfo = pathinfo($originalPath);
        $directory = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];

        // Delete compressed version
        $compressedPath = "{$directory}/{$filename}_compressed.jpg";
        if ($disk->exists($compressedPath)) {
            $disk->delete($compressedPath);
        }

        // Delete all responsive versions (using both legacy and new breakpoints)
        $allBreakpoints = array_merge(
            array_keys(self::BREAKPOINTS),
            array_keys(self::LEGACY_BREAKPOINTS)
        );
        $allBreakpoints = array_unique($allBreakpoints);

        foreach ($allBreakpoints as $name) {
            foreach (['avif', 'webp', 'jpg'] as $ext) {
                $variantPath = "{$directory}/{$filename}_{$name}.{$ext}";
                if ($disk->exists($variantPath)) {
                    $disk->delete($variantPath);
                }
            }
        }

        // Delete original
        if ($disk->exists($originalPath)) {
            $disk->delete($originalPath);
        }
    }

    // ===================== EXISTING VARIANTS LOOKUP =====================

    /**
     * Batch-get all existing variants for multiple images
     */
    public static function getExistingVariants(array $imagePaths): array
    {
        $byDir = [];
        foreach ($imagePaths as $path) {
            if (!$path) {
                continue;
            }
            $dir = pathinfo($path, PATHINFO_DIRNAME);
            $byDir[$dir][] = pathinfo($path, PATHINFO_FILENAME);
        }

        $result = [];
        foreach ($byDir as $dir => $filenames) {
            $files = self::disk()->files($dir);
            $fileNames = array_map(fn($f) => pathinfo($f, PATHINFO_BASENAME), $files);

            foreach ($filenames as $filename) {
                $compressed = "{$filename}_compressed.jpg";
                $webpResp = [];
                $avifResp = [];

                foreach (self::LEGACY_BREAKPOINTS as $name => $width) {
                    if (in_array("{$filename}_{$name}.webp", $fileNames)) {
                        $webpResp[$name] = "{$dir}/{$filename}_{$name}.webp";
                    }
                    if (in_array("{$filename}_{$name}.avif", $fileNames)) {
                        $avifResp[$name] = "{$dir}/{$filename}_{$name}.avif";
                    }
                }

                $result["{$dir}/{$filename}"] = [
                    'compressed' => in_array($compressed, $fileNames) ? "{$dir}/{$compressed}" : null,
                    'webp_responsive' => $webpResp,
                    'avif_responsive' => $avifResp,
                ];
            }
        }

        return $result;
    }

    /**
     * Get existing compressed version or fallback to original
     */
    public static function getExistingCompressed(string $originalPath): string
    {
        $pathInfo = pathinfo($originalPath);
        $directory = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];

        $compressedPath = "{$directory}/{$filename}_compressed.jpg";

        if (self::disk()->exists($compressedPath)) {
            return $compressedPath;
        }

        return $originalPath;
    }

    /**
     * Get existing responsive WebP versions
     */
    public static function getExistingResponsiveWebP(string $originalPath): array
    {
        $pathInfo = pathinfo($originalPath);
        $directory = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];
        $disk = self::disk();

        $webpVersions = [];
        foreach (self::LEGACY_BREAKPOINTS as $name => $width) {
            $webpPath = "{$directory}/{$filename}_{$name}.webp";
            if ($disk->exists($webpPath)) {
                $webpVersions[$name] = $webpPath;
            }
        }

        return $webpVersions;
    }

    /**
     * Get single WebP version (desktop/main)
     */
    public static function getExistingWebP(string $originalPath): ?string
    {
        $pathInfo = pathinfo($originalPath);
        $directory = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];

        $webpPath = "{$directory}/{$filename}_desktop.webp";
        if (self::disk()->exists($webpPath)) {
            return $webpPath;
        }

        return null;
    }

    /**
     * Get existing responsive AVIF versions
     */
    public static function getExistingResponsiveAVIF(string $originalPath): array
    {
        $pathInfo = pathinfo($originalPath);
        $directory = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];
        $disk = self::disk();

        $avifVersions = [];
        foreach (self::LEGACY_BREAKPOINTS as $name => $width) {
            $avifPath = "{$directory}/{$filename}_{$name}.avif";
            if ($disk->exists($avifPath)) {
                $avifVersions[$name] = $avifPath;
            }
        }

        return $avifVersions;
    }

    /**
     * Get single AVIF version (desktop/main)
     */
    public static function getExistingAVIF(string $originalPath): ?string
    {
        $pathInfo = pathinfo($originalPath);
        $directory = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];

        $avifPath = "{$directory}/{$filename}_desktop.avif";
        if (self::disk()->exists($avifPath)) {
            return $avifPath;
        }

        return null;
    }

    // ===================== URL HELPERS =====================

    /**
     * Get responsive image URLs
     */
    public static function getResponsiveUrls($imagePath)
    {
        if (!$imagePath) {
            return [];
        }

        $pathInfo = pathinfo($imagePath);
        $baseFilename = $pathInfo['filename'];
        $extension = $pathInfo['extension'];
        $folder = $pathInfo['dirname'];
        $disk = self::disk();

        $urls = [
            'original' => Storage::url($imagePath),
        ];

        $sizes = ['large', 'medium', 'small', 'mobile'];

        foreach ($sizes as $size) {
            $sizeFilename = $baseFilename . '_' . $size . '.' . $extension;
            $sizePath = $folder . '/' . $sizeFilename;

            if ($disk->exists($sizePath)) {
                $urls[$size] = Storage::url($sizePath);
            }
        }

        return $urls;
    }

    /**
     * Get srcset string for responsive images
     */
    public static function getSrcset($imagePath)
    {
        $urls = self::getResponsiveUrls($imagePath);

        if (empty($urls)) {
            return '';
        }

        $srcset = [];

        $widthMappings = [
            'mobile' => '480w',
            'small' => '768w',
            'medium' => '1024w',
            'large' => '1280w',
            'original' => '1920w',
        ];

        foreach ($widthMappings as $size => $width) {
            if (isset($urls[$size])) {
                $srcset[] = $urls[$size] . ' ' . $width;
            }
        }

        return implode(', ', $srcset);
    }

    /**
     * Get the best image URL for a specific screen size
     */
    public static function getImageForSize($imagePath, $screenSize = 'large')
    {
        $urls = self::getResponsiveUrls($imagePath);

        return $urls[$screenSize] ?? $urls['original'] ?? Storage::url($imagePath);
    }

    // ===================== VIEW HELPERS (dari ImageOptimizationService) =====================

    /**
     * Generate optimized image URL with optional resizing
     */
    public static function url(string $path, ?int $width = null, ?int $height = null, string $fit = 'cover'): string
    {
        if (empty($path)) {
            return self::placeholder($width, $height);
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return Storage::url($path);
    }

    /**
     * Generate placeholder SVG
     */
    public static function placeholder(?int $width = 400, ?int $height = 300, string $color = '#e5e7eb'): string
    {
        $w = $width ?? 400;
        $h = $height ?? 300;
        $encodedColor = str_replace('#', '%23', $color);

        return "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 {$w} {$h}'%3E%3Crect fill='{$encodedColor}' width='100%25' height='100%25'/%3E%3C/svg%3E";
    }

    /**
     * Generate blur placeholder for image
     */
    public static function blurPlaceholder(?int $width = 400, ?int $height = 300): string
    {
        return self::placeholder($width, $height, '#f3f4f6');
    }

    /**
     * Generate lazy image HTML tag
     */
    public static function lazyImageTag(
        string $src,
        string $alt = '',
        string $class = '',
        bool $lazy = true,
        ?int $width = null,
        ?int $height = null,
        bool $priority = false
    ): string {
        $loading = $priority ? 'eager' : ($lazy ? 'lazy' : 'eager');
        $fetchPriority = $priority ? 'high' : 'auto';

        $w = $width ?? 400;
        $h = $height ?? 300;
        $placeholder = self::blurPlaceholder($w, $h);

        $widthAttr = $width ? "width=\"{$width}\"" : '';
        $heightAttr = $height ? "height=\"{$height}\"" : '';

        $escapedAlt = htmlspecialchars($alt, ENT_QUOTES, 'UTF-8');
        $escapedClass = htmlspecialchars($class, ENT_QUOTES, 'UTF-8');
        $escapedSrc = htmlspecialchars($src, ENT_QUOTES, 'UTF-8');

        return "<img src=\"{$escapedSrc}\" alt=\"{$escapedAlt}\" class=\"{$escapedClass} optimized-image transition-opacity duration-300\" loading=\"{$loading}\" decoding=\"async\" fetchpriority=\"{$fetchPriority}\" {$widthAttr} {$heightAttr} style=\"background-image: url('{$placeholder}'); background-size: cover;\" data-placeholder=\"{$placeholder}\">";
    }

    /**
     * Get image dimensions from path (if available)
     */
    public static function getDimensions(string $path): ?array
    {
        if (empty($path) || !self::disk()->exists($path)) {
            return null;
        }

        try {
            $fullPath = self::disk()->path($path);
            $imageInfo = @getimagesize($fullPath);

            if ($imageInfo) {
                return [
                    'width' => $imageInfo[0],
                    'height' => $imageInfo[1],
                ];
            }
        } catch (\Exception $e) {
            // Silently fail
        }

        return null;
    }

    /**
     * Generate srcset for responsive images (view helper variant)
     */
    public static function srcset(string $path, array $widths = [320, 640, 768, 1024, 1280, 1536]): ?string
    {
        return null;
    }

    /**
     * Check if image is SVG
     */
    public static function isSvg(string $path): bool
    {
        return Str::endsWith(strtolower($path), '.svg');
    }

    /**
     * Get appropriate sizes attribute based on layout
     */
    public static function getSizes(string $layout = 'default'): string
    {
        return match ($layout) {
            'full' => '100vw',
            'hero' => '100vw',
            'card' => '(max-width: 640px) 100vw, (max-width: 1024px) 50vw, 33vw',
            'thumbnail' => '(max-width: 640px) 50vw, 200px',
            'avatar' => '48px',
            default => '(max-width: 768px) 100vw, 50vw',
        };
    }

    // ===================== FORMAT DETECTION =====================

    /**
     * Check if AVIF is supported by GD
     */
    public static function isAVIFSupported(): bool
    {
        if (!function_exists('gd_info')) {
            return false;
        }

        try {
            $gdInfo = gd_info();
            return isset($gdInfo['AVIF Support']) && $gdInfo['AVIF Support'];
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Check if ffmpeg is available on the system
     */
    public static function isFFmpegAvailable(): bool
    {
        if (self::$ffmpegAvailable !== null) {
            return self::$ffmpegAvailable;
        }

        $test = shell_exec('where ffmpeg 2>NUL');
        self::$ffmpegAvailable = !empty($test);
        return self::$ffmpegAvailable;
    }

    /**
     * Find ffmpeg binary path
     */
    protected static function findFFmpegBinary(): string
    {
        $possiblePaths = [
            'ffmpeg',
            'C:\\ffmpeg\\bin\\ffmpeg.exe',
            'C:\\ProgramData\\chocolatey\\bin\\ffmpeg.exe',
        ];

        foreach ($possiblePaths as $path) {
            $test = shell_exec("where {$path} 2>NUL");
            if ($test) {
                $lines = explode("\n", trim($test));
                return trim($lines[0]);
            }
        }

        return 'ffmpeg';
    }

    /**
     * Map quality (0-100) to AVIF CRF (63-0)
     */
    protected static function mapQualityToAVIFCRF(int $quality): int
    {
        return max(0, min(63, (int) round((100 - $quality) * 0.63)));
    }

    // ===================== INTERNAL HELPERS =====================

    protected static function generateCompressed($image, string $directory, string $filename, array $options): string
    {
        $quality = $options['quality'] ?? self::QUALITY_MEDIUM;
        $compressedFilename = "{$filename}_compressed.jpg";
        $compressedPath = "{$directory}/{$compressedFilename}";

        $encoded = $image->toJpeg(quality: $quality, progressive: true);
        self::disk()->put($compressedPath, (string) $encoded);

        return $compressedPath;
    }

    protected static function generateFormatVersions($image, string $directory, string $filename, array $options, ?string $fullPath, string $format): array
    {
        $quality = $options["{$format}_quality"] ?? self::QUALITY_MEDIUM;
        $breakpoints = $options['breakpoints'] ?? self::LEGACY_BREAKPOINTS;

        $method = $format === 'webp' ? 'toWebp' : 'toAvif';
        $extension = $format;

        // Try GD first
        if ($format === 'avif' && self::isAVIFSupported()) {
            try {
                return self::generateFormatViaGD($image, $directory, $filename, $breakpoints, $quality, $method, $extension);
            } catch (\Exception $e) {
                Log::warning("GD {$format} conversion failed, trying ffmpeg fallback: " . $e->getMessage());
            }
        } elseif ($format === 'webp' && function_exists('imagewebp')) {
            try {
                return self::generateFormatViaGD($image, $directory, $filename, $breakpoints, $quality, $method, $extension);
            } catch (\Exception $e) {
                Log::warning("GD WebP conversion failed, trying ffmpeg fallback: " . $e->getMessage());
            }
        }

        // Fallback to ffmpeg
        if ($fullPath && self::isFFmpegAvailable()) {
            return self::generateFormatViaFFmpeg($fullPath, $directory, $filename, $breakpoints, $quality, $format);
        }

        Log::info("{$format} conversion skipped: neither GD nor ffmpeg available");
        return [];
    }

    protected static function generateFormatViaGD($image, string $directory, string $filename, array $breakpoints, int $quality, string $method, string $extension): array
    {
        $versions = [];
        foreach ($breakpoints as $name => $width) {
            $formatFilename = "{$filename}_{$name}.{$extension}";
            $formatPath = "{$directory}/{$formatFilename}";

            $resized = clone $image;
            $resized->scaleDown(width: $width);
            $encoded = $resized->{$method}(quality: $quality);

            self::disk()->put($formatPath, (string) $encoded);
            $versions[$name] = $formatPath;
        }
        return $versions;
    }

    protected static function generateFormatViaFFmpeg(string $fullPath, string $directory, string $filename, array $breakpoints, int $quality, string $format): array
    {
        $disk = self::disk();
        $versions = [];
        $ffmpeg = self::findFFmpegBinary();

        $codec = $format === 'avif' ? 'libaom-av1' : 'libwebp';
        $extraOpts = $format === 'avif'
            ? "-cpu-used 4 -crf " . self::mapQualityToAVIFCRF($quality) . " -pix_fmt yuv420p -still-picture 1"
            : "-quality {$quality} -preset picture";

        foreach ($breakpoints as $name => $width) {
            $formatFilename = "{$filename}_{$name}.{$format}";
            $formatPath = "{$directory}/{$formatFilename}";
            $outputPath = $disk->path($formatPath);

            $cmd = sprintf(
                '"%s" -y -i "%s" -vf "scale=\'min(%d,iw)\':min\'(%d*ih/iw)\':force_original_aspect_ratio=decrease" -c:v %s %s "%s" 2>&1',
                $ffmpeg,
                $fullPath,
                $width,
                $width,
                $codec,
                $extraOpts,
                $outputPath
            );

            $output = shell_exec($cmd);

            if (file_exists($outputPath) && filesize($outputPath) > 0) {
                $versions[$name] = $formatPath;
                Log::debug("{$format} variant generated via ffmpeg: {$formatPath}");
            } else {
                Log::warning("FFmpeg {$format} generation failed for {$formatPath}", ['cmd' => $cmd, 'output' => $output]);
            }
        }

        return $versions;
    }

    protected static function generateResponsiveVersions($image, string $directory, string $filename, array $options): array
    {
        $quality = $options['quality'] ?? self::QUALITY_MEDIUM;
        $breakpoints = $options['breakpoints'] ?? self::LEGACY_BREAKPOINTS;
        $versions = [];

        foreach ($breakpoints as $name => $width) {
            $responsiveFilename = "{$filename}_{$name}.jpg";
            $responsivePath = "{$directory}/{$responsiveFilename}";

            $resized = clone $image;
            $resized->scaleDown(width: $width);
            $encoded = $resized->toJpeg(quality: $quality, progressive: true);

            self::disk()->put($responsivePath, (string) $encoded);
            $versions[$name] = $responsivePath;
        }

        return $versions;
    }
}
