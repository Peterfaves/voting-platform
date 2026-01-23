<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Handle contact form submission
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // You can add email sending logic here
        // Mail::to('support@voteafrika.com')->send(new ContactFormMail($validated));

        return back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}