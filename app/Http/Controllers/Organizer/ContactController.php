<?php

namespace App\Http\Controllers\Organizer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('organizer.contact.index');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|min:10',
        ]);
        
        // Send email to support
        Mail::send('emails.contact', $validated, function ($message) use ($validated) {
            $message->to('support@votenaija.ng')
                    ->subject('Contact Form Submission from ' . $validated['name']);
            $message->replyTo($validated['email']);
        });
        
        return redirect()
            ->back()
            ->with('success', 'Message sent successfully! We\'ll get back to you shortly.');
    }
}