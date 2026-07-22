<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OptimizeFileUpload
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('post') &&
                    (count($request->allFiles()) > 0 || $request->is('admin/storage/*') || $request->is('admin/hero-slider/*') || $request->is('admin/reports/*') ||
                     str_contains($request->header('Content-Type'), 'multipart/form-data'))) {
            $this->optimizeUploadSettings();
        }

        return $next($request);
    }

    /**
     * Optimize PHP settings for file uploads using dynamic settings from SiteSetting
     */
    protected function optimizeUploadSettings(): void
    {
        try {
            $settings = SiteSetting::getSettings();

            // Memory limit
            $currentMemory = ini_get('memory_limit');
            $targetMemory = $settings->memory_limit ?? '512M';
            if ($this->parseMemoryLimit($currentMemory) < $this->parseMemoryLimit($targetMemory)) {
                ini_set('memory_limit', $targetMemory);
            }

            // Max execution time
            $currentTime = ini_get('max_execution_time');
            $targetTime = $settings->max_execution_time ?? 300;
            if ($currentTime < $targetTime) {
                ini_set('max_execution_time', (string)$targetTime);
            }

            // Max input time
            $currentInputTime = ini_get('max_input_time');
            $targetInputTime = $settings->max_input_time ?? 300;
            if ($currentInputTime < $targetInputTime) {
                ini_set('max_input_time', (string)$targetInputTime);
            }

            // Upload settings
            // NOTE: upload_max_filesize & post_max_size are PHP_INI_PERDIR settings.
            // ini_set() does NOT work for these in PHP-FPM/CGI — they MUST be set in
            // php.ini, .user.ini, or .htaccess. We still attempt ini_set() for Apache
            // mod_php where it works, and log a warning if the value didn't change.
            $uploadMaxFilesize = $settings->upload_max_filesize ?? '100M';
            $postMaxSize = $settings->post_max_size ?? '100M';
            $maxFileUploads = $settings->max_file_uploads ?? 20;

            $originalUploadMax = ini_get('upload_max_filesize');
            ini_set('upload_max_filesize', $uploadMaxFilesize);
            $afterUploadMax = ini_get('upload_max_filesize');

            $originalPostMax = ini_get('post_max_size');
            ini_set('post_max_size', $postMaxSize);
            $afterPostMax = ini_get('post_max_size');

            ini_set('max_file_uploads', (string)$maxFileUploads);

            // Log whether ini_set actually changed the settings
            $uploadChanged = ($originalUploadMax !== $afterUploadMax);
            $postChanged = ($originalPostMax !== $afterPostMax);

            if (!$uploadChanged || !$postChanged) {
                \Illuminate\Support\Facades\Log::warning('ini_set() for PHP_INI_PERDIR settings had no effect', [
                    'upload_max_filesize' => [
                        'before' => $originalUploadMax,
                        'attempted' => $uploadMaxFilesize,
                        'after' => $afterUploadMax,
                        'changed' => $uploadChanged,
                    ],
                    'post_max_size' => [
                        'before' => $originalPostMax,
                        'attempted' => $postMaxSize,
                        'after' => $afterPostMax,
                        'changed' => $postChanged,
                    ],
                    'sapi' => PHP_SAPI,
                    'hint' => 'Set upload_max_filesize and post_max_size in .user.ini or php.ini',
                ]);
            }

            // Log the settings
            if (function_exists('Log')) {
                \Illuminate\Support\Facades\Log::info('Dynamic upload settings applied', [
                    'upload_max_filesize' => $afterUploadMax,
                    'post_max_size' => $afterPostMax,
                    'max_execution_time' => ini_get('max_execution_time'),
                    'max_input_time' => ini_get('max_input_time'),
                    'memory_limit' => ini_get('memory_limit'),
                    'max_file_uploads' => ini_get('max_file_uploads'),
                ]);
            }
        } catch (\Exception $e) {
            // Fallback to default settings if SiteSetting fails
            ini_set('memory_limit', '512M');
            ini_set('max_execution_time', '300');
            ini_set('max_input_time', '300');
            ini_set('upload_max_filesize', '100M');
            ini_set('post_max_size', '100M');
            ini_set('max_file_uploads', '20');

            if (function_exists('Log')) {
                \Illuminate\Support\Facades\Log::warning('Failed to apply dynamic upload settings, using defaults', [
                    'error' => $e->getMessage()
                ]);
            }
        }

        // Optimize for image processing
        ini_set('gd.jpeg_ignore_warning', '1');
    }

    /**
     * Parse memory limit string to bytes
     */
    protected function parseMemoryLimit(string $limit): int
    {
        $limit = trim($limit);
        if ($limit === '') {
            return 0;
        }
        $unit = strtolower(preg_replace('/[0-9]/', '', $limit));
        $value = (int) $limit;

        return match ($unit) {
            'g', 'gb' => $value * 1024 * 1024 * 1024,
            'm', 'mb' => $value * 1024 * 1024,
            'k', 'kb' => $value * 1024,
            default => $value,
        };
    }
}
