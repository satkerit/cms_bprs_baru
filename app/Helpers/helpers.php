<?php

use App\Helpers\StorageHelper;

if (!function_exists('storage_url')) {
    /**
     * Get storage URL for uploaded files
     * Works in both development and production environments
     *
     * @param string|null $path
     * @return string
     */
    function storage_url(?string $path): string
    {
        return StorageHelper::url($path);
    }
}

if (!function_exists('storage_asset')) {
    /**
     * Get asset URL (for public assets like CSS, JS)
     * Works in both development and production environments
     *
     * @param string $path
     * @return string
     */
    function storage_asset(string $path): string
    {
        return StorageHelper::asset($path);
    }
}

if (!function_exists('storage_exists')) {
    /**
     * Check if file exists in storage
     *
     * @param string|null $path
     * @return bool
     */
    function storage_exists(?string $path): bool
    {
        return StorageHelper::exists($path);
    }
}

if (!function_exists('storage_path_url')) {
    /**
     * Alias for storage_url (for backward compatibility)
     *
     * @param string|null $path
     * @return string
     */
    function storage_path_url(?string $path): string
    {
        return StorageHelper::url($path);
    }
}

if (!function_exists('format_rupiah')) {
    /**
     * Format number to Indonesian Rupiah currency
     *
     * @param int|float|string|null $amount
     * @param bool $showPrefix Show "Rp" prefix (default: true)
     * @return string
     */
    function format_rupiah($amount, bool $showPrefix = true): string
    {
        if ($amount === null || $amount === '') {
            return $showPrefix ? 'Rp 0' : '0';
        }

        // Convert to number if string
        if (is_string($amount)) {
            $amount = (float) preg_replace('/[^0-9.-]/', '', $amount);
        }

        $formatted = number_format($amount, 0, ',', '.');

        return $showPrefix ? 'Rp ' . $formatted : $formatted;
    }
}

if (!function_exists('csp_nonce')) {
    /**
     * Get the CSP nonce for the current request
     *
     * @return string
     */
    function csp_nonce(): string
    {
        return request()->attributes->get('csp_nonce', '');
    }
}

if (!function_exists('format_rupiah_short')) {
    /**
     * Format number to short Indonesian Rupiah (with K, Jt, M suffix)
     *
     * @param int|float|string|null $amount
     * @param bool $showPrefix Show "Rp" prefix (default: true)
     * @return string
     */
    function format_rupiah_short($amount, bool $showPrefix = true): string
    {
        if ($amount === null || $amount === '') {
            return $showPrefix ? 'Rp 0' : '0';
        }

        // Convert to number if string
        if (is_string($amount)) {
            $amount = (float) preg_replace('/[^0-9.-]/', '', $amount);
        }

        $prefix = $showPrefix ? 'Rp ' : '';

        // Miliar (Billion)
        if ($amount >= 1000000000) {
            $value = $amount / 1000000000;
            // Format dengan 1 desimal jika ada, tanpa desimal jika bulat
            $formatted = $value == floor($value) ? number_format($value, 0, ',', '.') : number_format($value, 1, ',', '.');
            return $prefix . $formatted . ' M';
        }
        // Juta (Million)
        elseif ($amount >= 1000000) {
            $value = $amount / 1000000;
            // Format dengan 1 desimal jika ada, tanpa desimal jika bulat
            $formatted = $value == floor($value) ? number_format($value, 0, ',', '.') : number_format($value, 1, ',', '.');
            return $prefix . $formatted . ' Jt';
        }
        // Ribu (Thousand)
        elseif ($amount >= 1000) {
            $value = $amount / 1000;
            // Format dengan 1 desimal jika ada, tanpa desimal jika bulat
            $formatted = $value == floor($value) ? number_format($value, 0, ',', '.') : number_format($value, 1, ',', '.');
            return $prefix . $formatted . ' Rb';
        }

        // Kurang dari 1000, tampilkan full
        return $prefix . number_format($amount, 0, ',', '.');
    }
}

if (!function_exists('format_file_size')) {
    function format_file_size($bytes): string
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' B';
        }
    }
}

if (!function_exists('get_max_upload_size_kb')) {
    /**
     * Get maximum upload size in KB based on SiteSetting or fallback to default
     * Useful for Laravel's max: validation rule which expects size in KB
     *
     * This function reads from upload_max_filesize to determine the PHP-level max.
     * For feature-specific limits, use get_upload_max_size() instead.
     *
     * @param int $default_kb Default size in KB (default: 15360 = 15MB)
     * @return int
     */
    function get_max_upload_size_kb(int $default_kb = 15360): int
    {
        try {
            $settings = \App\Models\SiteSetting::getSettings();
            if (isset($settings->upload_max_filesize)) {
                $val = trim($settings->upload_max_filesize);
                $last = strtolower($val[strlen($val) - 1]);
                $val = (int)$val;

                switch ($last) {
                    case 'g':
                        $val *= 1024 * 1024;
                        break;
                    case 'm':
                        $val *= 1024;
                        break;
                    case 'k':
                        $val *= 1;
                        break;
                    default: // Bytes
                        $val = $val / 1024;
                        break;
                }

                return max(1, (int)$val);
            }
        } catch (\Exception $e) {
            // Silently fallback to default if settings unavailable
        }

        return $default_kb;
    }
}

if (!function_exists('get_upload_max_size')) {
    /**
     * Get feature-specific maximum upload size in KB from SiteSetting.
     *
     * Supported feature types:
     * - 'image'          → max_image_size_kb (default: 2048 = 2MB)  — Berita, Board Member, Office, Logo, WhyChooseUs
     * - 'product_image'  → max_product_image_size_kb (default: 2048 = 2MB)
     * - 'document'       → max_document_size_kb (default: 15360 = 15MB) — PDF Laporan & Brosur
     * - 'hero_image'     → max_hero_image_size_kb (default: 5120 = 5MB)
     * - 'auction_image'  → max_auction_image_size_kb (default: 5120 = 5MB)
     *
     * @param string $feature Nama fitur (image, product_image, document, hero_image, auction_image)
     * @param int $default_kb Fallback size in KB jika settings tidak tersedia
     * @return int
     */
    function get_upload_max_size(string $feature = 'image', int $default_kb = 2048): int
    {
        $columnMap = [
            'image'         => 'max_image_size_kb',
            'product_image' => 'max_product_image_size_kb',
            'document'      => 'max_document_size_kb',
            'hero_image'    => 'max_hero_image_size_kb',
            'auction_image' => 'max_auction_image_size_kb',
        ];

        $column = $columnMap[$feature] ?? null;

        if ($column === null) {
            return $default_kb;
        }

        try {
            $settings = \App\Models\SiteSetting::getSettings();
            if (isset($settings->{$column}) && $settings->{$column} > 0) {
                return (int) $settings->{$column};
            }
        } catch (\Exception $e) {
            // Silently fallback if settings unavailable
        }

        return $default_kb;
    }
}
