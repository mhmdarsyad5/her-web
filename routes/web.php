<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DSSController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TermConditionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Contacts
Route::get('/kontak', [ContactController::class, 'index'])->name('contacts.index');

// Contact Messages
Route::post('/', [HomeController::class, 'storeContact'])
    ->middleware('throttle.contact')
    ->name('contact.store');

// Pages
Route::get('/artikel/{slug}', [PageController::class, 'show'])->name('pages.show');
Route::get('/artikel', [PageController::class, 'index'])->name('pages.index');
Route::get('/artikel/tag/{slug}', [PageController::class, 'tag'])->name('pages.tag');
Route::get('/cari/artikel', [PageController::class, 'search'])
    ->middleware('throttle:30,1')
    ->name('pages.search');
Route::get('/cari/artikel/skeleton', function () {
    return view('frontend.pages.pages.partials.skeleton')->render();
})->name('search.skeleton');

// FAQ
Route::get('/tanya-jawab', [FaqController::class, 'index'])->name('faq.index');

// Galleries
Route::get('/galeri', [GalleryController::class, 'index'])->name('galleries.index');
Route::get('/galeri/{id}', [GalleryController::class, 'show'])->name('galleries.show');
Route::get('/cari/galeri', [GalleryController::class, 'search'])
    ->middleware('throttle:30,1')
    ->name('galleries.search');
Route::get('/cari/galeri/skeleton', function () {
    return view('frontend.pages.gallery.partials.skeleton')->render();
})->name('galleries.search.skeleton');

// Abouts
Route::get('/tentang-kami', [AboutController::class, 'index'])->name('abouts.index');

// Term & Privacy
Route::get('/syarat-ketentuan', [TermConditionController::class, 'index'])->name('terms-conditions.index');
Route::get('/kebijakan-privasi', [PrivacyPolicyController::class, 'index'])->name('privacy-policy.index');

// Services
Route::get('/layanan', [ServiceController::class, 'index'])->name('services.index');

// Products
Route::get('/produk', [ProductController::class, 'index'])
    ->name('products.index');

Route::get('/cari/produk', [ProductController::class, 'search'])
    ->middleware('throttle:30,1')
    ->name('products.search');

Route::get('/cari/produk/skeleton', function () {
    return view('frontend.pages.products.partials.skeleton')->render();
})->name('products.search.skeleton');

// ⚠️ SELALU TERAKHIR
Route::get('/produk/{slug}', [ProductController::class, 'show'])
    ->name('products.show');

// DSS (Decision Support System) Routes
Route::post('/dss/process', [DSSController::class, 'processForm'])
    ->middleware('throttle.dss')
    ->name('dss.process');
Route::get('/dss/criteria/{fieldType}', [DSSController::class, 'getCriteria'])->name('dss.criteria');
Route::post('/dss/submit-lead', [DSSController::class, 'submitLead'])->name('dss.submit-lead');

// Dynamic XML Sitemap for Google SEO
Route::get('/sitemap.xml', function () {
    $pages = \App\Models\Page::where('status', 'published')
        ->whereNotNull('publish_at')
        ->where('publish_at', '<=', now())
        ->get();
    $products = \App\Models\Product::all();

    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    // Home Page
    $xml .= '<url>';
    $xml .= '<loc>'.url('/').'</loc>';
    $xml .= '<priority>1.0</priority>';
    $xml .= '</url>';

    // Blog Listings Page
    $xml .= '<url>';
    $xml .= '<loc>'.route('pages.index').'</loc>';
    $xml .= '<priority>0.8</priority>';
    $xml .= '</url>';

    // Blog/Articles Detail Pages
    foreach ($pages as $page) {
        $xml .= '<url>';
        $xml .= '<loc>'.route('pages.show', $page->slug).'</loc>';
        $xml .= '<lastmod>'.$page->updated_at->toAtomString().'</lastmod>';
        $xml .= '<priority>0.7</priority>';
        $xml .= '</url>';
    }

    // Products Listings Page
    $xml .= '<url>';
    $xml .= '<loc>'.route('products.index').'</loc>';
    $xml .= '<priority>0.8</priority>';
    $xml .= '</url>';

    // Products Detail Pages
    foreach ($products as $product) {
        $xml .= '<url>';
        $xml .= '<loc>'.route('products.show', $product->slug).'</loc>';
        $xml .= '<lastmod>'.$product->updated_at->toAtomString().'</lastmod>';
        $xml .= '<priority>0.7</priority>';
        $xml .= '</url>';
    }

    // Other static pages
    $staticPages = ['contacts.index', 'faq.index', 'galleries.index', 'abouts.index', 'terms-conditions.index', 'privacy-policy.index', 'services.index'];
    foreach ($staticPages as $route) {
        if (Route::has($route)) {
            $xml .= '<url>';
            $xml .= '<loc>'.route($route).'</loc>';
            $xml .= '<priority>0.5</priority>';
            $xml .= '</url>';
        }
    }

    $xml .= '</urlset>';

    return response($xml, 200, ['Content-Type' => 'application/xml']);
})->name('sitemap');
