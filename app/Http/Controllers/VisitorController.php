<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index()
    {
        $visitors = Visitor::orderBy('check_in_time', 'desc')->paginate(15);
        return view('admin.visitors.index', compact('visitors'));
    }

    public function create()
    {
        return view('admin.visitors.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'purpose' => 'required|string|max:255',
            'person_to_meet' => 'nullable|string|max:255',
            'check_in_time' => 'required|date',
            'note' => 'nullable|string',
        ]);

        Visitor::create($validated);

        return redirect()->route('visitors.index')->with('success', 'Visitor record created successfully.');
    }

    public function edit(Visitor $visitor)
    {
        return view('admin.visitors.edit', compact('visitor'));
    }

    public function update(Request $request, Visitor $visitor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'purpose' => 'required|string|max:255',
            'person_to_meet' => 'nullable|string|max:255',
            'check_in_time' => 'required|date',
            'check_out_time' => 'nullable|date|after_or_equal:check_in_time',
            'note' => 'nullable|string',
        ]);

        $visitor->update($validated);

        return redirect()->route('visitors.index')->with('success', 'Visitor record updated successfully.');
    }

    public function checkOut(Visitor $visitor)
    {
        $visitor->update([
            'check_out_time' => now()
        ]);

        return redirect()->route('visitors.index')->with('success', 'Visitor checked out successfully.');
    }

    public function destroy(Visitor $visitor)
    {
        $visitor->delete();
        return redirect()->route('visitors.index')->with('success', 'Visitor record deleted successfully.');
    }
}
