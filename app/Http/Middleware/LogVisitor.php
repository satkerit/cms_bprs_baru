<?php

namespace App\Http\Middleware;

use App\Jobs\LogVisitorVisit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($response->isSuccessful() &&
            !$request->is('admin/*') && !$request->is('api/*') &&
            !$request->is('livewire/*') && !$request->is('storage/*')) {
            try {
                // afterResponse() runs the job synchronously after the response is sent to the
                // browser — no queue worker required. This guarantees visitor logs are written
                // even on shared hosting / local dev where `queue:work` is not running.
                LogVisitorVisit::dispatch(
                    ip: $request->ip() ?? '0.0.0.0',
                    userAgent: $request->userAgent() ?? '',
                    url: $request->fullUrl(),
                    referrer: $request->header('referer'),
                    sessionId: session()->getId(),
                )->afterResponse();
            } catch (\Exception $e) {
                // Silently fail — logging should never break the page
            }
        }

        return $response;
    }
}
