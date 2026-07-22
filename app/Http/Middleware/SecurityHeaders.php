<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Vite;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Security headers to add to all responses
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Generate CSP nonce early so it's available in Blade views
        $nonce = base64_encode(random_bytes(16));
        $request->attributes->set('csp_nonce', $nonce);

        // Tell Vite to use this nonce
        if (class_exists(\Illuminate\Support\Facades\Vite::class)) {
            \Illuminate\Support\Facades\Vite::useCspNonce($nonce);
        }

        $response = $next($request);

        // Prevent clickjacking
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Prevent MIME type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Enable XSS filter
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Referrer policy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Permissions policy - Allow geolocation for prayer times widget
        $response->headers->set('Permissions-Policy', 'geolocation=(self), microphone=(), camera=()');

        // Content Security Policy
        $csp = $this->buildContentSecurityPolicy();
        $response->headers->set('Content-Security-Policy', $csp);

        // HSTS for production
        if (app()->environment('production')) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        }

        // Add additional security headers
        $this->addAdditionalSecurityHeaders($response);

        return $response;
    }

    /**
     * Build Content Security Policy header
     */
    protected function buildContentSecurityPolicy(): string
    {
        $nonce = request()->attributes->get('csp_nonce');

        $policies = [
            "default-src 'self'",
            // unsafe-eval diperlukan oleh Alpine.js v3 yang menggunakan Function() untuk evaluasi ekspresi x-data.
            // Untuk menghapus unsafe-eval sepenuhnya, aplikasi harus migrasi ke @alpinejs/csp build
            // yang memerlukan pre-compile semua ekspresi Alpine (perubahan besar).
            "script-src 'nonce-{$nonce}' 'strict-dynamic' 'unsafe-eval' https://cdn.jsdelivr.net https://unpkg.com https://code.jquery.com https://cdn.ckeditor.com https://analytics.ahrefs.com",
            // Styles: Allow self, unsafe-inline (for Alpine.js dynamic styles and nonce-based <style> tags),
            // unsafe-hashes (for style attributes), and trusted CDNs
            // Note: 'unsafe-inline' takes effect when no nonce is present in style-src.
            // We omit the nonce from style-src to allow both <style> blocks and dynamic style="" attributes.
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://fonts.bunny.net https://cdn.jsdelivr.net https://unpkg.com https://cdnjs.cloudflare.com",
            "font-src 'self' https://fonts.gstatic.com https://fonts.bunny.net https://cdn.jsdelivr.net https://cdnjs.cloudflare.com data:",
            "img-src 'self' data: https: blob:",
            "connect-src 'self' https://cdn.jsdelivr.net https://unpkg.com https://tile.openstreetmap.org https://a.tile.openstreetmap.org https://b.tile.openstreetmap.org https://c.tile.openstreetmap.org https://nominatim.openstreetmap.org http://api.aladhan.com",
            "frame-src 'self' https://www.google.com https://maps.google.com blob:",
            "frame-ancestors 'self'",
            "form-action 'self'",
            "base-uri 'self'",
            "object-src 'none'",
        ];

        // Only add upgrade-insecure-requests in production with HTTPS
        if (app()->environment('production') && request()->secure()) {
            $policies[] = "upgrade-insecure-requests";
        }

        // Add report-uri for monitoring (optional)
        if (config('security.csp.report_violations', false)) {
            $policies[] = "report-uri /api/csp-report";
        }

        return implode('; ', $policies);
    }

    /**
     * Add additional security headers
     */
    protected function addAdditionalSecurityHeaders(Response $response): void
    {
        // Cross-Origin-Opener-Policy (COOP)
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin');

        // Cross-Origin-Embedder-Policy (COEP)
        $response->headers->set('Cross-Origin-Embedder-Policy', 'unsafe-none');

        // Cross-Origin-Resource-Policy (CORP)
        $response->headers->set('Cross-Origin-Resource-Policy', 'same-origin');

        // X-Permitted-Cross-Domain-Policies
        $response->headers->set('X-Permitted-Cross-Domain-Policies', 'none');

        // Expect-CT dihapus — deprecated sejak Chrome 107 dan tidak diakui browser modern.

        // Remove server information
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('Server');
    }
}
