<?php

namespace App\Http\Controllers\Communication;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $notices = Notice::latest()->get();
        } else {
            $audience = 'students';
            if ($user->role === 'teacher') $audience = 'teachers';
            if ($user->role === 'parent') $audience = 'parents';

            $notices = Notice::whereIn('target_audience', ['all', $audience])
                ->where(function($q) {
                    $q->whereNull('expires_at')->orWhere('expires_at', '>=', now()->toDateString());
                })
                ->latest()->get();
        }
        
        return view('communication.notices.index', compact('notices'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'admin') abort(403);
        return view('communication.notices.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') abort(403);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'target_audience' => 'required|in:all,teachers,students,parents',
            'expires_at' => 'nullable|date|after_or_equal:today',
        ]);

        Notice::create($validated);

        return redirect()->route('communication.notices.index')->with('success', 'Notice published successfully.');
    }

    public function destroy(Notice $notice)
    {
        if (Auth::user()->role !== 'admin') abort(403);
        $notice->delete();
        return back()->with('success', 'Notice deleted successfully.');
    }
}
