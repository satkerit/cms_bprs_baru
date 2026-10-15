<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Set proper HTTP cache headers on public frontend HTML responses
 * so Cloudflare (s-maxage) and browsers (max-age + SWR) can cache them.
 * Skips admin / API / Livewire / debugbar / health routes and non-GET requests.
 */
class FrontendCacheHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $request->isMethod('GET')) {
            return $response;
        }

        $contentType = (string) $response->headers->get('Content-Type', '');
        if (! str_contains($contentType, 'text/html')) {
            return $response;
        }

        if ($request->is('admin*', 'admin', 'api*', 'livewire/*', '_debugbar*', 'up')) {
            return $response;
        }

        $response->headers->set(
            'Cache-Control',
            'public, max-age=60, s-maxage=600, stale-while-revalidate=86400'
        );

        return $response;
    }
}
