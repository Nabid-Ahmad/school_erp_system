<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;

use App\Mail\ContactUsMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Replace with your actual admin email
        $adminEmail = env('MAIL_FROM_ADDRESS', 'admin@example.com');

        try {
            Mail::to($adminEmail)->send(new ContactUsMail($validated));
            return redirect()->back()->with('success', 'Your message has been sent successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again later.');
        }
    }
}
