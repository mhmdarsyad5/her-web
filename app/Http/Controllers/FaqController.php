<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::where('is_published', true)
            ->orderBy('order_column')
            ->paginate(10);

        $title = setting('nav_faq', 'FAQ');

        return view(
            'frontend.pages.faq.index',
            compact('faqs', 'title')
        );
    }
}
