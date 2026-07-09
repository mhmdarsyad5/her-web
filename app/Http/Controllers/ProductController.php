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
            ->paginate(9);

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
                if ($segment === 'lithium') {
                    $q->where(function ($sub) {
                        $sub->where('energy_type', 'LIKE', '%Li-Ion%')
                            ->orWhere('energy_type', 'LIKE', '%Lithium%');
                    });
                } elseif ($segment === 'electric') {
                    $q->where(function ($sub) {
                        $sub->where('energy_type', 'LIKE', '%Electric%')
                            ->orWhere('energy_type', 'LIKE', '%Elektrik%')
                            ->orWhere('name_id', 'LIKE', '%Elektrik%');
                    });
                } elseif ($segment === 'diesel') {
                    $q->where(function ($sub) {
                        $sub->where('energy_type', 'LIKE', '%Diesel%')
                            ->orWhere('name_id', 'LIKE', '%Diesel%');
                    });
                } elseif ($segment === 'pallet-truck') {
                    $q->where('name_id', 'LIKE', '%Pallet Truck%');
                } elseif ($segment === 'pallet-stacker') {
                    $q->where(function ($sub) {
                        $sub->where('name_id', 'LIKE', '%Pallet Stacker%')
                            ->orWhere('name_id', 'LIKE', '%Stacker%');
                    });
                } elseif ($segment === 'warehouse') {
                    $q->where(function ($sub) {
                        $sub->where('name_id', 'LIKE', '%Reach Truck%')
                            ->orWhere('name_id', 'LIKE', '%Stacker%')
                            ->orWhere('name_id', 'LIKE', '%Pallet%')
                            ->orWhere('name_id', 'LIKE', '%Warehouse%');
                    });
                }
            })
            ->when($keyword, function ($q) use ($keyword) {
                $q->where(function ($inner) use ($keyword) {
                    $inner->where('name_id', 'LIKE', "%{$keyword}%")
                          ->orWhere('description_id', 'LIKE', "%{$keyword}%");
                });
            })
            ->orderBy('sort_order')
            ->paginate(9);

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
