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

        // Hardcoded SMTP Configuration as requested
        config([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.host' => 'smtp.gmail.com',
            'mail.mailers.smtp.port' => 465,
            'mail.mailers.smtp.encryption' => 'ssl',
            'mail.mailers.smtp.username' => 'nabidahmad.zidan@gmail.com',
            'mail.mailers.smtp.password' => 'bcjj mwgp jiou eepd',
            'mail.from.address' => 'nabidahmad.zidan@gmail.com',
            'mail.from.name' => 'School ERP',
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
