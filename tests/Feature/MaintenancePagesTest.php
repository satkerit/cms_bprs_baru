<?php

namespace Tests\Feature;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class MaintenancePagesTest extends TestCase
{
    /**
     * Every non-wildcard maintenance pattern must match a registered route,
     * so partial-maintenance targeting actually works (e.g. tentang-kami/kantor-cabang).
     */
    public function test_maintenance_patterns_match_registered_routes(): void
    {
        $routes = Route::getRoutes();

        foreach (SiteSetting::getAvailablePages() as $key => $page) {
            $pattern = $page['pattern'];

            // Wildcard patterns cover a whole section (e.g. "tentang-kami/*"),
            // and are intentionally not exact URLs.
            if (str_ends_with($pattern, '*')) {
                continue;
            }

            $route = $routes->match(Request::create('/' . ltrim($pattern, '/')));

            $this->assertFalse(
                $route->isFallback,
                "Maintenance page '{$key}' has pattern '{$pattern}' that does not match any registered route."
            );
        }
    }
}
