<?php

namespace App\Http\View\Composers;

use App\Models\Seo;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class SeoComposer
{
    /**
     * Pemetaan nama route → identifier di tabel seos
     */
    protected static array $routeMap = [
        'home' => 'home',
        'products.index' => 'products',
        'products.show' => 'products',
        'pages.index' => 'blog',
        'pages.show' => 'blog',
        'services.index' => 'services',
        'gallery.index' => 'gallery',
        'contact' => 'contact',
        'faq.index' => 'faq',
        'dss.index' => 'dss',
    ];

    public function compose(View $view): void
    {
        // Sudah ada seo dari controller (misal halaman artikel)? skip
        if ($view->offsetExists('pageSeo')) {
            return;
        }

        $routeName = request()->route()?->getName() ?? '';
        $pageKey = static::$routeMap[$routeName] ?? null;

        $seo = null;
        if ($pageKey) {
            $seo = Cache::remember("seo_{$pageKey}", 60 * 10, function () use ($pageKey) {
                return Seo::where('page', $pageKey)->first();
            });
        }

        $view->with('pageSeo', $seo);
    }
}
