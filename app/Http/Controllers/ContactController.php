<?php

namespace App\Http\Controllers;

class ContactController extends Controller
{
    public function index()
    {
        $siteName = strip_tags(setting('site_name', 'Website'));

        // Title
        $title = strip_tags(
            setting('contact_title', 'Contact Us')
        );

        $pageTitle = $title . ' - ' . $siteName;

        // Badge & description
        $badge = strip_tags(setting('contact_badge', 'Hubungi Kami'));
        $description = strip_tags(
            setting(
                'contact_description',
                'Pertanyaan, masukan, atau peluang kolaborasi? Kirim pesan dan tim kami akan menghubungi Anda.'
            )
        );

        // Contact info (TANPA HTML)
        $whatsapp = strip_tags(setting('whatsapp_number', '-'));
        $email    = strip_tags(setting('email', '-'));
        $address  = strip_tags(setting('address', '-'));

        return view('frontend.pages.contacts.index', compact(
            'pageTitle',
            'title',
            'badge',
            'description',
            'whatsapp',
            'email',
            'address'
        ));
    }
}
