<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\PageCategory;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::with(['category', 'tags'])
            ->where('status', 'published')
            ->orderByDesc('publish_at')
            ->paginate(6);

        $title = setting('nav_blog', 'Blog');

        $categories = PageCategory::withCount(['pages' => function ($query) {
            $query->where('status', 'published');
        }])->having('pages_count', '>', 0)->get();

        return view(
            'frontend.pages.pages.index',
            compact('pages', 'title', 'categories')
        );
    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');
        $categorySlug = $request->get('category');

        $query = Page::where('status', 'published');

        if ($categorySlug && $categorySlug !== 'all') {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'LIKE', "%{$keyword}%")
                    ->orWhere('content', 'LIKE', "%{$keyword}%");
            });
        }

        $pages = $query->with(['category', 'tags'])->orderByDesc('publish_at')->paginate(6);

        return response()->json([
            'html' => view(
                'frontend.pages.pages.partials.articles-list',
                compact('pages')
            )->render(),

            'pagination' => $pages
                ->links('pagination::tailwind')
                ->toHtml(),

            'empty' => view(
                'frontend.pages.pages.partials.empty'
            )->render(),
        ]);
    }

    public function show($slug)
    {
        $page = Page::with(['category', 'tags'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $relatedPages = Page::with(['category'])
            ->where('status', 'published')
            ->where('id', '!=', $page->id)
            ->when($page->category_id, function ($q) use ($page) {
                $q->where('category_id', $page->category_id);
            })
            ->latest('publish_at')
            ->limit(4)
            ->get();

        $title = $page->title;

        return view(
            'frontend.pages.pages.show',
            compact('page', 'relatedPages', 'title')
        );
    }
}
