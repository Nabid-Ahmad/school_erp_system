<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Mail\ContactUsMail;
use App\Models\Setting;
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

        $adminEmail = Setting::where('key', 'school_email')->value('value')
            ?: config('mail.from.address');

        try {
            Mail::to($adminEmail)->send(new ContactUsMail($validated));

            return redirect()->back()->with('success', 'Your message has been sent successfully!');
        } catch (\Exception $e) {
            \Log::error('Contact form email error: '.$e->getMessage());

            return redirect()->back()->with('error', 'Something went wrong. Please try again later.');
        }
    }
}
