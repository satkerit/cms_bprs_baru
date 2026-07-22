<?php

namespace App\Support;

use Illuminate\Http\Request;
use Spatie\ResponseCache\CacheProfiles\BaseCacheProfile;
use Symfony\Component\HttpFoundation\Response;

class CustomCacheProfile extends BaseCacheProfile
{
    /**
     * Determine if the given request should be cached.
     *
     * Only cache public GET requests. Exclude:
     * - Admin panel routes (any URI starting with admin/)
     * - Authenticated requests
     * - Non-GET methods
     * - AJAX/Livewire requests
     * - Debug bar
     */
    public function shouldCacheRequest(Request $request): bool
    {
        // Only cache GET requests
        if (! $request->isMethod('GET')) {
            return false;
        }

        // Don't cache admin panel routes
        if ($request->is('admin*') || $request->is('admin/*')) {
            return false;
        }

        // Don't cache authenticated requests (even on public pages)
        if (auth()->check()) {
            return false;
        }

        // Don't cache AJAX, Livewire, or API requests
        if (
            $request->ajax()
            || $request->expectsJson()
            || $request->hasHeader('X-Livewire')
            || $request->is('api/*')
        ) {
            return false;
        }

        // Don't cache debug bar assets
        if ($request->is('_debugbar*')) {
            return false;
        }

        return true;
    }

    /**
     * Determine if the given response should be cached.
     * Only cache successful responses (2xx).
     */
    public function shouldCacheResponse(Response $response): bool
    {
        return $response->isSuccessful();
    }

    /**
     * Determine if the cache should be bypassed.
     * Allow bypass via configured header.
     */
    public function useCacheNameSuffix(Request $request): string
    {
        return '';
    }
}
