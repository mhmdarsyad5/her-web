<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class ThrottleContactForm
{
    protected int $maxAttempts = 5;
    protected int $decayMinutes = 1;

    public function handle(Request $request, Closure $next): Response
    {
        $key = 'throttle:contact:' . $request->ip();
        $attempts = (int) Cache::get($key, 0);

        if ($attempts >= $this->maxAttempts) {
            return response()->json([
                'success' => false,
                'errors' => ['Terlalu banyak pengiriman. Silakan coba lagi dalam beberapa menit.'],
            ], 429);
        }

        Cache::put($key, $attempts + 1, now()->addMinutes($this->decayMinutes));

        return $next($request);
    }
}