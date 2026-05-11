<?php

namespace App\Http\Controllers;

use App\Models\Setting;

class TermConditionController extends Controller
{
    public function index()
    {
        $siteName = strip_tags(setting('site_name', 'Website'));

        $title = strip_tags(setting('terms_title', 'Terms & Conditions'));
        $pageTitle = $title . ' - ' . $siteName;

        $termsText = setting('terms-conditions', 'Belum ada ketentuan.');

        return view('frontend.pages.terms-conditions.index', compact(
            'pageTitle',
            'title',
            'termsText'
        ));
    }
}
