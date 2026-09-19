<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\LeaveApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $leaves = LeaveApplication::with('user')->latest()->get();
        } else {
            $leaves = LeaveApplication::where('user_id', $user->id)->latest()->get();
        }
        return view('hr.leaves.index', compact('leaves'));
    }

    public function create()
    {
        return view('hr.leaves.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'leave_type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:1000',
        ]);

        LeaveApplication::create(array_merge($validated, ['user_id' => Auth::id()]));

        return redirect()->route('hr.leaves.index')->with('success', 'Leave application submitted successfully.');
    }

    public function updateStatus(Request $request, LeaveApplication $leave)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate(['status' => 'required|in:approved,rejected']);
        $leave->update(['status' => $request->status]);

        return back()->with('success', 'Leave status updated successfully.');
    }
}
