<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class ThrottleDssApi
{
    protected int $maxAttempts = 20;

    protected int $decayMinutes = 1;

    public function handle(Request $request, Closure $next): Response
    {
        $key = 'throttle:dss:'.$request->ip();
        $attempts = (int) Cache::get($key, 0);

        if ($attempts >= $this->maxAttempts) {
            return response()->json([
                'success' => false,
                'errors' => ['Terlalu banyak permintaan DSS. Silakan coba lagi nanti.'],
            ], 429);
        }

        Cache::put($key, $attempts + 1, now()->addMinutes($this->decayMinutes));

        return $next($request);
    }
}
