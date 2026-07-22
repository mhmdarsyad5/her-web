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
        'galleries.index' => 'gallery',
        'galleries.show' => 'gallery',
        'contacts.index' => 'contact',
        'abouts.index' => 'about',
        'faq.index' => 'faq',
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
                // Tentukan daftar alias pencarian agar admin bebas mengetik bahasa Inggris maupun Indonesia
                $aliases = [$pageKey];
                if ($pageKey === 'about') {
                    $aliases = ['about', 'about-us', 'about_us', 'tentang-kami', 'tentang_kami'];
                } elseif ($pageKey === 'contact') {
                    $aliases = ['contact', 'contact-us', 'contact_us', 'kontak', 'hubungi-kami'];
                } elseif ($pageKey === 'products') {
                    $aliases = ['products', 'produk'];
                } elseif ($pageKey === 'services') {
                    $aliases = ['services', 'layanan'];
                } elseif ($pageKey === 'gallery') {
                    $aliases = ['gallery', 'galeri'];
                } elseif ($pageKey === 'blog') {
                    $aliases = ['blog', 'artikel', 'berita'];
                }

                return Seo::whereIn('page', $aliases)->first();
            });
        }

        $view->with('pageSeo', $seo);
    }
}
