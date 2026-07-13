<?php

namespace App\Http\Controllers;

class PrivacyPolicyController extends Controller
{
    public function index()
    {
        $siteName = strip_tags(setting('site_name', 'Website'));

        $title = strip_tags(
            setting('privacy-policy_title', 'Kebijakan Privasi')
        );

        $pageTitle = $title.' - '.$siteName;

        $privacyText = setting('privacy-policy', 'Belum ada kebijakan privasi.');

        return view('frontend.pages.privacy-policy.index', compact(
            'pageTitle',
            'title',
            'privacyText'
        ));
    }
}
