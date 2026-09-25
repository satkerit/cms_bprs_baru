<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

/**
 * HTML Sanitizer untuk konten WYSIWYG.
 *
 * Memakai HTMLPurifier (via mews/purifier) sebagai mesin utama: parser HTML
 * sungguhan dengan whitelist tag/atribut, sehingga jauh lebih kuat terhadap
 * bypass XSS/mXSS dibanding sanitasi berbasis regex.
 *
 * Profil whitelist didefinisikan di config/purifier.php pada key "cms".
 * API (clean/sanitize) dipertahankan agar pemakaian di model tidak berubah.
 */
class HtmlSanitizer
{
    /**
     * Profil konfigurasi HTMLPurifier yang dipakai.
     */
    protected const PROFILE = 'cms';

    /**
     * Sanitize HTML content
     */
    public static function clean(?string $html): string
    {
        if ($html === null || trim($html) === '') {
            return '';
        }

        try {
            $clean = \Purifier::clean($html, self::PROFILE);
        } catch (\Throwable $e) {
            // Fail-closed: bila sanitizer gagal (mis. cache tidak writable),
            // buang seluruh tag dan sisakan teks polos agar tidak ada HTML
            // tak tersanitasi yang lolos ke halaman.
            Log::error('HtmlSanitizer: Purifier gagal, fallback ke strip_tags', [
                'error' => $e->getMessage(),
            ]);

            return strip_tags($html);
        }

        // Tambahkan target + rel pada link eksternal (perilaku yang dipertahankan
        // dari implementasi sebelumnya).
        return self::sanitizeLinks($clean);
    }

    /**
     * Alias for clean method
     */
    public static function sanitize(?string $html): string
    {
        return self::clean($html);
    }

    /**
     * Sanitize links to add rel="noopener noreferrer" for external links
     */
    protected static function sanitizeLinks(string $html): string
    {
        return preg_replace_callback(
            '/<a\s+([^>]*)>/i',
            function ($matches) {
                $attributes = $matches[1];

                // Check if it's an external link
                if (preg_match('/href\s*=\s*["\']https?:\/\//i', $attributes)) {
                    // Add target="_blank" if not present
                    if (!preg_match('/target\s*=/i', $attributes)) {
                        $attributes .= ' target="_blank"';
                    }
                    // Add rel="noopener noreferrer" if not present
                    if (!preg_match('/rel\s*=/i', $attributes)) {
                        $attributes .= ' rel="noopener noreferrer"';
                    }
                }

                return "<a {$attributes}>";
            },
            $html
        );
    }
}
