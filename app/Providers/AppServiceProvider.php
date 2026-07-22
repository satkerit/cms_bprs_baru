<?php

namespace App\Providers;

use App\Helpers\HtmlSanitizer;
use App\Models\SmtpSetting;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Check if running on shared hosting with public_html
        $publicHtmlPath = base_path() . '/../public_html';

        if (file_exists($publicHtmlPath)) {
            $this->app->bind('path.public', function () use ($publicHtmlPath) {
                return realpath($publicHtmlPath);
            });
        }

        if ($this->app->environment('local') && class_exists(\Laravel\Telescope\TelescopeServiceProvider::class)) {
            $this->app->register(\App\Providers\TelescopeServiceProvider::class);
        }

        $this->app->singleton(\App\Services\CacheService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::shouldBeStrict(! $this->app->isProduction());

        // Prevent lazy loading in development
        if (! $this->app->isProduction()) {
            Model::preventLazyLoading();
        }

        $this->loadSmtpSettings();
        $this->applySecuritySettings();
        $this->registerBladeDirectives();
        $this->registerRateLimiters();

        // Share CSP nonce with all views
        view()->composer('*', function ($view) {
            $view->with('nonce', request()->attributes->get('csp_nonce'));
        });
    }

    /**
     * Register custom Blade directives
     */
    protected function registerBladeDirectives(): void
    {
        // @cache($key, $ttl) / @endcache — cache template fragments
        Blade::directive('cache', function ($expression) {
            return "<?php \$__cacheExp = [{$expression}]; \$__cacheKey = \$__cacheExp[0]; \$__cacheTtl = \$__cacheExp[1] ?? null; if (! Illuminate\Support\Facades\Cache::has(\$__cacheKey)): ob_start(); endif; ?>";
        });
        Blade::directive('endcache', function () {
            return "<?php if (isset(\$__cacheKey) && ! Illuminate\Support\Facades\Cache::has(\$__cacheKey)): \$__cacheContent = ob_get_clean(); echo \$__cacheContent; Illuminate\Support\Facades\Cache::put(\$__cacheKey, \$__cacheContent, \$__cacheTtl); endif; ?>";
        });

        // @cleanHtml($content) - Sanitize HTML content from WYSIWYG editors
        Blade::directive('cleanHtml', function ($expression) {
            return "<?php echo \App\Helpers\HtmlSanitizer::clean($expression); ?>";
        });

        // @compressedImage($path, $quality) - Get compressed image URL
        Blade::directive('compressedImage', function ($expression) {
            return "<?php echo \Illuminate\Support\Facades\Storage::url(\App\Services\ImageService::compressForWeb($expression)); ?>";
        });

        // @storageUrl($path) - Get storage URL (works in both dev and production)
        Blade::directive('storageUrl', function ($expression) {
            return "<?php echo \App\Helpers\StorageHelper::url($expression); ?>";
        });

        // @assetUrl($path) - Get asset URL (for CSS, JS, images in public folder)
        Blade::directive('assetUrl', function ($expression) {
            return "<?php echo \App\Helpers\StorageHelper::asset($expression); ?>";
        });
    }

    /**
     * Register rate limiters for file uploads and other sensitive operations
     */
    protected function registerRateLimiters(): void
    {
        RateLimiter::for('uploads', function (Request $request) {
            return Limit::perMinute(5)->by($request->user()?->id ?: $request->ip());
        });
    }

    /**
     * Load SMTP settings from database
     */
    protected function loadSmtpSettings(): void
    {
        try {
            // Check if we are running in console
            if ($this->app->runningInConsole()) {
                return;
            }

            if (Schema::hasTable('smtp_settings')) {
                $settings = \App\Models\SmtpSetting::getActive();
                if ($settings) {
                    $settings->applyToConfig();
                }
            }
        } catch (\Exception $e) {
            // Silently fail if database is not available
        }
    }

    /**
     * Apply security settings from database to application config
     */
    protected function applySecuritySettings(): void
    {
        try {
            // Check if we are running in console (like migrations or seeders)
            if ($this->app->runningInConsole()) {
                return;
            }

            if (Schema::hasTable('security_settings')) {
                // Only apply custom session lifetime for admin area
                if (!request()->is('admin') && !request()->is('admin/*')) {
                    return;
                }

                $settings = \App\Models\SecuritySetting::getSettings();
                if ($settings) {
                    // Apply session lifetime (convert to minutes for Laravel config)
                    if ($settings->session_lifetime) {
                        config(['session.lifetime' => (int) $settings->session_lifetime]);
                    }

                    // Apply other security configs if needed
                    config(['session.expire_on_close' => false]);

                    // Force HTTPS cookie in production
                    if ($this->app->isProduction()) {
                        config(['session.secure' => true]);
                    }
                }
            }
        } catch (\Exception $e) {
            // Silently fail if database is not available
        }
    }
}
