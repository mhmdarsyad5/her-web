<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserLastSeen
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $cacheKey = 'user-is-online-'.$user->id;

            // Cache online status selama 3 menit
            Cache::put($cacheKey, true, now()->addMinutes(3));

            // Update timestamp keaktifan di DB setiap 1 menit (mencegah query berlebihan)
            if (! $user->last_seen_at || $user->last_seen_at->diffInMinutes(now()) >= 1) {
                User::where('id', $user->id)->update(['last_seen_at' => now()]);
            }
        }

        return $next($request);
    }
}
