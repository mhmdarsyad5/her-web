<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function create()
    {
        return view('frontend.pages.home.sections.contactmessage');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'whatsapp_number' => 'required|string|max:20',
            'subject' => 'nullable|string|max:150',
            'message' => 'required|string|max:1000',
        ]);

        ContactMessage::create($validated);

        // Tetap di halaman form dan kirim flash message
        return redirect()->route('contact.form')->with('success', 'Pesan berhasil dikirim!');
    }
}
