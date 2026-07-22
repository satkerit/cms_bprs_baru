<?php

namespace App\Traits;

use App\Jobs\ProcessImageUpload;
use App\Services\FileScanner;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

trait HandlesImageUpload
{
    /**
     * Handle image upload from file or storage selection
     *
     * @param Request $request
     * @param string $fieldName
     * @param string $storagePath
     * @param string|null $oldPath
     * @return string|null
     */
    protected function handleImageUpload(Request $request, string $fieldName, string $storagePath, ?string $oldPath = null): ?string
    {
        $deleteField = $fieldName . '_delete';
        $fromStorageField = $fieldName . '_from_storage';

        // Check if image should be deleted
        if ($request->input($deleteField) === '1') {
            // Delete old file if exists
            if ($oldPath) {
                Storage::disk('public')->delete($oldPath);
            }
            return null;
        }

        // Check if image is selected from storage
        if ($request->filled($fromStorageField)) {
            $storageSrc = $request->input($fromStorageField);

            // Validate the storage path exists
            if (Storage::disk('public')->exists($storageSrc)) {
                // Delete old file if exists and different
                if ($oldPath && $oldPath !== $storageSrc) {
                    Storage::disk('public')->delete($oldPath);
                }
                return $storageSrc;
            }
        }

        if ($request->hasFile($fieldName)) {
            $file = $request->file($fieldName);

            $result = app(FileScanner::class)->scan($file);
            if ($result->isInfected()) {
                app(FileScanner::class)->quarantine($file);
                throw new \Exception('File diblokir: ' . ($result->detail ?? 'terindikasi berbahaya'));
            }

            if ($oldPath) {
                Storage::disk('public')->delete($oldPath);
            }

            return $this->storeOptimizedImage($file, $storagePath);
        }

        // Return old path if no new image
        return $oldPath;
    }

    /**
     * Store image with optimization using ImageService
     * Generates responsive WebP, AVIF, and JPEG variants
     */
    protected function storeOptimizedImage(UploadedFile $file, string $storagePath): string
    {
        // Increase memory limit and execution time for image processing
        $originalMemoryLimit = ini_get('memory_limit');
        $originalTimeLimit = ini_get('max_execution_time');

        ini_set('memory_limit', '512M');
        ini_set('max_execution_time', 300); // 5 minutes

        try {
            $extension = strtolower($file->extension() ?: $file->getClientOriginalExtension());

            // Define allowed extensions
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'];

            if (!in_array($extension, $allowedExtensions)) {
                throw new \Exception('Ekstensi file tidak diizinkan: ' . $extension);
            }

            // For images that can be optimized
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
                try {
                    // Check file size before processing
                    $fileSize = $file->getSize();
                    $maxSizeBytes = get_max_upload_size_kb() * 1024;
                    if ($fileSize > $maxSizeBytes) {
                        throw new \Exception('File terlalu besar untuk diproses');
                    }

                    // Determine quality based on storage path
                    if (str_contains($storagePath, 'hero-slides')) {
                        $jpegQuality = 90;
                        $webpQuality = 88;
                    } else {
                        $jpegQuality = 85;
                        $webpQuality = 85;
                    }

                    // Use unified ImageService to upload and generate variants
                    $result = ImageService::upload($file, [
                        'sizes' => [1920, 1280, 1024, 768, 480],
                        'formats' => ['avif', 'webp', 'jpg'],
                        'dir' => $storagePath,
                        'quality' => $jpegQuality,
                    ]);

                    $fullPath = $result['original'];

                    // Log successful optimization
                    Log::info('Image optimized successfully via ImageService', [
                        'original_size' => $fileSize,
                        'final_path' => $fullPath,
                        'variants' => count($result['sizes']),
                        'storage_type' => str_contains($storagePath, 'hero-slides') ? 'hero-slide' : 'regular',
                    ]);

                    // Backward compatibility: also dispatch queue job for additional processing
                    try {
                        $options = [
                            'quality' => $jpegQuality,
                            'webp_quality' => $webpQuality,
                        ];

                        if (str_contains($storagePath, 'hero-slides')) {
                            $options['avif_quality'] = 85;
                            $options['generate_avif'] = true;
                        }

                        ProcessImageUpload::dispatch($fullPath, $options);

                        Log::info('Responsive variants dispatched to queue', [
                            'path' => $fullPath,
                            'options' => $options,
                        ]);
                    } catch (\Throwable $e) {
                        Log::warning('Variant generation dispatch failed: ' . $e->getMessage(), [
                            'path' => $fullPath,
                        ]);
                    }

                    return $fullPath;
                } catch (\Throwable $e) {
                    // Log error and fall back to normal upload
                    Log::warning('Image optimization failed: ' . $e->getMessage(), [
                        'file_size' => $file->getSize(),
                        'file_name' => $file->getClientOriginalName(),
                    ]);

                    // Fall back to direct storage without optimization
                    return $file->store($storagePath, 'public');
                }
            }

            // Default: store without optimization
            return $file->store($storagePath, 'public');
        } finally {
            // Restore original limits
            ini_set('memory_limit', $originalMemoryLimit);
            ini_set('max_execution_time', $originalTimeLimit);
        }
    }

    /**
     * Handle logo uploads explicitly (skip optimization to preserve quality/transparency perfectly if needed)
     * Or just use the same method if confident.
     * For now, we'll keep the main logic in storeOptimizedImage and remove the old optimizeImage method.
     */
}
