<?php

namespace App\Http\Middleware;

use App\Models\VisitorLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitors
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Only track non-admin, non-livewire, non-api, successful GET requests
        if ($request->isMethod('GET')
            && ! $request->is('admin*')
            && ! $request->is('livewire*')
            && ! $request->is('api*')
            && $response->getStatusCode() === 200
        ) {
            try {
                VisitorLog::create([
                    'ip_address' => $request->ip(),
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                    'user_agent' => $request->userAgent(),
                ]);
            } catch (\Exception $e) {
                // Fail silently to prevent user-facing crashes
            }
        }

        return $response;
    }
}
