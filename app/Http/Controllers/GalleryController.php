<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * ===============================
     * INDEX (LIST GALLERY)
     * ===============================
     */
    public function index()
    {
        $galleries = Gallery::where('is_published', true)
            ->orderBy('order_column')
            ->latest()
            ->paginate(9);

        $title = setting('nav_gallery', 'Gallery');

        return view(
            'frontend.pages.gallery.index',
            compact('galleries', 'title')
        );
    }

    /**
     * ===============================
     * SEARCH (AJAX)
     * ===============================
     */
    public function search(Request $request)
    {
        $keyword = $request->get('keyword');

        $galleries = Gallery::where('is_published', true)
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('title', 'LIKE', "%{$keyword}%")
                    ->orWhereJsonContains('tags', $keyword);
            })
            ->orderBy('order_column')
            ->paginate(9);

        return response()->json([
            'html' => view(
                'frontend.pages.gallery.partials.gallery-list',
                compact('galleries')
            )->render(),

            'pagination' => $galleries
                ->links('pagination::tailwind')
                ->toHtml(),

            'empty' => view(
                'frontend.pages.gallery.partials.empty'
            )->render(),
        ]);
    }

    /**
     * ===============================
     * SHOW (DETAIL GALLERY)
     * ===============================
     */
    public function show(string $id)
    {
        $gallery = Gallery::where('id', $id)
            ->where('is_published', true)
            ->firstOrFail();

        // Gallery terkait (exclude current)
        $relatedGalleries = Gallery::where('is_published', true)
            ->where('id', '!=', $gallery->id)
            ->orderBy('order_column')
            ->latest()
            ->limit(4)
            ->get();

        // SEO title → otomatis dari accessor model (ID / EN)
        $title = $gallery->title;

        return view(
            'frontend.pages.gallery.show',
            compact('gallery', 'relatedGalleries', 'title')
        );
    }
}
