<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware(['web', 'throttle:120,1'])
                ->group(base_path('routes/hero-slider-routes.php'));

            // Include debug routes
            Route::middleware('web')->group(base_path('routes/debug.php'));

            // Explicit route model binding for WhyChooseUs
            Route::bind('why_choose_us', function ($value) {
                return \App\Models\WhyChooseUs::findOrFail($value);
            });
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(function (Request $request) {
            return route('admin.login');
        });

        // Set middleware priority - optimize upload needs to run early
        $middleware->priority([
            \App\Http\Middleware\OptimizeFileUpload::class,
            \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        // Register middleware aliases
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'throttle.custom' => \App\Http\Middleware\RateLimitRequests::class,
            'security.threat' => \App\Http\Middleware\SecurityThreatDetection::class,
            'admin.ddos' => \App\Http\Middleware\AdminDdosProtection::class,
            'ddos' => \App\Http\Middleware\DdosProtection::class,
            'menu.permission' => \App\Http\Middleware\CheckMenuPermission::class,
            'idle.timeout' => \App\Http\Middleware\IdleTimeoutMiddleware::class,
            'secure.session' => \App\Http\Middleware\SecureSessionMiddleware::class,
            'optimize.upload' => \App\Http\Middleware\OptimizeFileUpload::class,
        ]);


        // Web middleware group - Security monitoring runs early
        $middleware->web(append: [
            \App\Http\Middleware\CacheStaticAssets::class,
            \App\Http\Middleware\SecureSessionMiddleware::class,
            \App\Http\Middleware\SecurityThreatDetection::class,
            \App\Http\Middleware\CheckMaintenanceMode::class,
            \App\Http\Middleware\DdosProtection::class,
            \App\Http\Middleware\LogVisitor::class,
            \App\Http\Middleware\OptimizeResponse::class,
            \Spatie\ResponseCache\Middlewares\CacheResponse::class,
            \App\Http\Middleware\SecurityHeaders::class,
        ]);

        $middleware->validateCsrfTokens(except: [
            '/api/csp-report',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\Illuminate\Http\Exceptions\PostTooLargeException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Ukuran file terlalu besar. Melebihi batas yang diizinkan server.'], 413);
            }

            return back()->withInput()->with('error', 'Ukuran file terlalu besar. Melebihi batas yang diizinkan server.');
        });
    })->create();
