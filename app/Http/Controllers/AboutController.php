<?php

namespace App\Http\Controllers;

class AboutController extends Controller
{
    public function index()
    {
        // Site name (BERSIH)
        $siteName = strip_tags(setting('site_name', 'Nama Website'));

        // Konten
        $aboutText = strip_tags(setting('about', 'Tidak ada deskripsi'));
        $historyText = setting('history', 'Belum ada sejarah perusahaan.');
        $visionText = setting('vision', 'Belum ada visi perusahaan.');
        $missionText = setting('mission', 'Belum ada misi perusahaan.');

        // ===== TITLE =====
        $rawTitle = setting('nav_about', 'Tentang Kami');

        // Bersihkan HTML (WAJIB)
        $title = strip_tags($rawTitle);

        // Full page title (AMAN)
        $pageTitle = $title.' - '.$siteName;

        return view('frontend.pages.abouts.index', compact(
            'siteName',
            'title',
            'pageTitle',
            'aboutText',
            'historyText',
            'visionText',
            'missionText'
        ));
    }
}
