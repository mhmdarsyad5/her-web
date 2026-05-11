<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where('is_active', true)
            ->orderBy('sort_order')
            ->paginate(9);

        $title = setting('nav_service', 'Layanan');

        return view(
            'frontend.pages.services.index',
            compact('services', 'title')
        );
    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');

        $services = Service::where('is_active', true)
            ->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('description', 'LIKE', "%{$keyword}%");
            })
            ->orderBy('sort_order')
            ->paginate(9);

        return response()->json([
            'html' => view(
                'frontend.pages.services.partials.services-list',
                compact('services')
            )->render(),

            'pagination' => $services
                ->links('pagination::tailwind')
                ->toHtml(),

            'empty' => view(
                'frontend.pages.services.partials.empty'
            )->render(),
        ]);
    }
}
