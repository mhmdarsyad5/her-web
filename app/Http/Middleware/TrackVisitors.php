<?php

namespace App\Http\Middleware;

use App\Models\VisitorLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
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
                $userAgent = strtolower($request->userAgent() ?? '');
                $bots = [
                    'googlebot', 'bingbot', 'yandexbot', 'applebot', 'duckduckbot',
                    'slurp', 'baidu', 'facebookexternalhit', 'twitterbot', 'linkedinbot',
                    'embedly', 'quora link preview', 'showyoubot', 'outbrain', 'pinterest',
                    'slackbot', 'vkshare', 'w3c_validator', 'redditbot', 'ia_archiver',
                    'crawl', 'spider', 'bot', 'curl', 'wget', 'httpclient',
                ];

                foreach ($bots as $bot) {
                    if (str_contains($userAgent, $bot)) {
                        return $response;
                    }
                }

                $ip = $request->ip();

                // Fetch location from ip-api.com with 7 days cache and 2 seconds timeout
                $location = ['city' => null, 'region' => null, 'country' => null];
                if ($ip && $ip !== '127.0.0.1' && $ip !== '::1') {
                    $location = Cache::remember("geoip:{$ip}", 86400 * 7, function () use ($ip) {
                        try {
                            $apiRes = Http::timeout(2)->get("http://ip-api.com/json/{$ip}");
                            if ($apiRes->successful() && $apiRes->json('status') === 'success') {
                                return [
                                    'city' => $apiRes->json('city'),
                                    'region' => $apiRes->json('regionName'),
                                    'country' => $apiRes->json('country'),
                                ];
                            }
                        } catch (\Throwable $e) {
                            // Fail silently
                        }

                        return ['city' => 'Unknown', 'region' => 'Unknown', 'country' => 'Unknown'];
                    });
                }

                VisitorLog::create([
                    'ip_address' => $ip,
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                    'user_agent' => $request->userAgent(),
                    'city' => $location['city'] ?? null,
                    'region' => $location['region'] ?? null,
                    'country' => $location['country'] ?? null,
                ]);
            } catch (\Exception $e) {
                // Fail silently to prevent user-facing crashes
            }
        }

        return $response;
    }
}
