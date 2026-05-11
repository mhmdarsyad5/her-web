<?php

namespace App\Http\Controllers;

use App\Models\HeroSection;
use App\Models\Page;
use App\Models\ContactMessage;
use App\Models\Service;
use App\Models\Product;
use App\Models\DSSCriteria;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $heroes = HeroSection::all();
        $messages = ContactMessage::latest()->paginate(10);


        $pages = Page::where('is_published', true)
            ->whereNotNull('publish_at')
            ->orderByDesc('publish_at')
            ->take(3)
            ->get();

        $services = Service::where('is_active', true)->get();
        $products = Product::where('is_active', true)
            ->orderByDesc('created_at')
            ->take(3)
            ->get();

        // DSS Criteria for form
        $locations = DSSCriteria::getByFieldType('location')->toArray();
        $industries = DSSCriteria::getByFieldType('industry')->toArray();
        $cargoTypes = DSSCriteria::getByFieldType('cargo_type')->toArray();
        $weights = DSSCriteria::getByFieldType('weight')->toArray();
        $heights = DSSCriteria::getByFieldType('height')->toArray();
        $aisles = DSSCriteria::getByFieldType('aisle')->toArray();
        $energies = DSSCriteria::getByFieldType('energy')->toArray();
        $units = DSSCriteria::getByFieldType('unit')->toArray();
        $operators = DSSCriteria::getByFieldType('operator')->toArray();

        // Dynamic primary color for DSS form (default: tailwind primary-900 orange)
        $primaryColor = setting('primary_color', '#ff7f00');

        return view('frontend.pages.home.index', compact('heroes', 'pages', 'messages', 'services', 'products', 'locations', 'industries', 'cargoTypes', 'weights', 'heights', 'aisles', 'energies', 'units', 'operators', 'primaryColor'));
    }



    public function storeContact(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'whatsapp_number' => 'required|string|max:20',
            'email'   => 'required|email|max:100',
            'subject' => 'nullable|string|max:150',
            'message' => 'required|string|max:1000',
        ]);

        ContactMessage::create($validated);
        return back()->with('success', 'Terima kasih, pesan Anda telah berhasil dikirim.')->withFragment('form');
    }
}
