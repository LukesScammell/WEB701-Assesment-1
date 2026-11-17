<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // Display the contact form
    public function create()
    {
        return view('contact');
    }

    // Validate and store a contact message
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'subject' => 'required|in:General Enquiry,Events,Donations,Sponsorship,Volunteering',
            'message' => 'required|string|max:2000',
        ]);

        ContactMessage::create($validated);

        return redirect()
            ->route('contact')
            ->with('success', 'Your message has been sent successfully!');
    }
}