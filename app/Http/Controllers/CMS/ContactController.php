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

        // Resend API Configuration
        config([
            'resend.api_key' => 're_pzndZ47i_upogSZSNoxZndTvBdeiAY7ko',
            'mail.default' => 'resend',
            'mail.mailers.resend' => [
                'transport' => 'resend',
            ],
            'mail.from.address' => 'onboarding@resend.dev',
            'mail.from.name' => 'Bangla Model School',
        ]);

        $adminEmail = \App\Models\Setting::where('key', 'school_email')->value('value');
        if (!$adminEmail) {
            $adminEmail = 'nabidahmad.zidan@gmail.com'; // Fallback
        }

        try {
            Mail::to($adminEmail)->send(new ContactUsMail($validated));
            return redirect()->back()->with('success', 'Your message has been sent successfully!');
        } catch (\Exception $e) {
            \Log::error('SMTP Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again later. Error: ' . $e->getMessage());
        }
    }
}
