<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $title = setting('nav_service', 'Layanan');

        // DSS Criteria for form
        $industries = \App\Models\DSSCriteria::getByFieldType('industry')->toArray();
        $productTypes = \App\Models\DSSCriteria::getByFieldType('product_type')->toArray();
        $energies = \App\Models\DSSCriteria::getByFieldType('energy')->toArray();
        $weights = \App\Models\DSSCriteria::getByFieldType('weight')->toArray();
        $heights = \App\Models\DSSCriteria::getByFieldType('height')->toArray();
        $primaryColor = setting('primary_color', '#ff7f00');

        return view(
            'frontend.pages.services.index',
            compact('title', 'industries', 'productTypes', 'energies', 'weights', 'heights', 'primaryColor')
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
