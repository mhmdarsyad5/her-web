<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * List produk
     */
    public function index()
    {
        $products = Product::where('is_active', true)
            ->orderBy('sort_order')
            ->latest()
            ->paginate(10);

        $title = setting('nav_product', 'Produk');

        return view(
            'frontend.pages.products.index',
            compact('products', 'title')
        );
    }

    /**
     * Search produk (AJAX)
     */
    public function search(Request $request)
    {
        $keyword = $request->get('keyword');
        $segment = $request->get('segment', 'all');

        $products = Product::where('is_active', true)
            ->when($segment && $segment !== 'all', function ($q) use ($segment) {
                $q->where('product_type', $segment);
            })
            ->when($keyword, function ($q) use ($keyword) {
                $q->where(function ($inner) use ($keyword) {
                    $inner->where('name_id', 'LIKE', "%{$keyword}%")
                        ->orWhere('description_id', 'LIKE', "%{$keyword}%");
                });
            })
            ->orderBy('sort_order')
            ->paginate(10);

        return response()->json([
            'html' => view(
                'frontend.pages.products.partials.products-list',
                compact('products')
            )->render(),

            'pagination' => $products
                ->links('pagination::tailwind')
                ->toHtml(),

            'empty' => view(
                'frontend.pages.products.partials.empty'
            )->render(),
        ]);
    }

    /**
     * Detail produk
     */
    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedProducts = Product::where('is_active', true)
            ->where('id', '!=', $product->id)
            ->orderBy('sort_order')
            ->limit(4)
            ->get();

        $title = $product->name;

        return view(
            'frontend.pages.products.show',
            compact('product', 'relatedProducts', 'title')
        );
    }
}
