<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\DSSCriteria;
use App\Models\HeroSection;
use App\Models\Page;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $heroes = HeroSection::all();
        $messages = ContactMessage::latest()->paginate(10);

        $pages = Page::where('status', 'published')
            ->whereNotNull('publish_at')
            ->orderByDesc('publish_at')
            ->take(3)
            ->get();

        $services = Service::where('is_active', true)->get();
        $products = Product::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('id', 'asc')
            ->take(10)
            ->get();

        $partners = \App\Models\Partner::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get();

        // DSS Criteria for form
        $industries = DSSCriteria::getByFieldType('industry')->toArray();
        $productTypes = DSSCriteria::getByFieldType('product_type')->toArray();
        $energies = DSSCriteria::getByFieldType('energy')->toArray();
        $weights = DSSCriteria::getByFieldType('weight')->toArray();
        $heights = DSSCriteria::getByFieldType('height')->toArray();

        // Dynamic primary color for DSS form (default: tailwind primary-900 orange)
        $primaryColor = setting('primary_color', '#ff7f00');

        return view('frontend.pages.home.index', compact('heroes', 'pages', 'messages', 'services', 'products', 'industries', 'productTypes', 'energies', 'weights', 'heights', 'primaryColor', 'partners'));
    }

    public function storeContact(Request $request)
    {
        // Honeypot spam protection
        if ($request->filled('company_website')) {
            return back()->with('success', 'Terima kasih, pesan Anda telah berhasil dikirim.')->withFragment('form');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'whatsapp_number' => 'required|string|max:20',
            'email' => 'required|email|max:100',
            'subject' => 'nullable|string|max:150',
            'message' => 'required|string|max:1000',
        ]);

        ContactMessage::create($validated);

        return back()->with('success', 'Terima kasih, pesan Anda telah berhasil dikirim.')->withFragment('form');
    }
}
