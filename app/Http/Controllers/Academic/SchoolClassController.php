<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    public function index()
    {
        $classes = \App\Models\SchoolClass::withCount('students', 'subjects')->get();
        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        return view('classes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:school_classes,name',
            'monthly_fee' => 'required|numeric|min:0',
            'admission_fee' => 'required|numeric|min:0',
        ]);

        $class = \App\Models\SchoolClass::create(['name' => $validated['name']]);

        // Save to fee_structures
        \App\Models\FeeStructure::create([
            'school_class_id' => $class->id,
            'fee_type' => 'Monthly Fee',
            'amount' => $validated['monthly_fee']
        ]);

        \App\Models\FeeStructure::create([
            'school_class_id' => $class->id,
            'fee_type' => 'Admission Fee',
            'amount' => $validated['admission_fee']
        ]);

        return redirect()->route('classes.index')->with('success', 'Class and Fee Structure created successfully.');
    }

    public function edit(\App\Models\SchoolClass $class)
    {
        $class->load('feeStructures');
        return view('classes.edit', compact('class'));
    }

    public function update(Request $request, \App\Models\SchoolClass $class)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:school_classes,name,' . $class->id,
            'monthly_fee' => 'required|numeric|min:0',
            'admission_fee' => 'required|numeric|min:0',
        ]);

        $class->update(['name' => $validated['name']]);

        // Update fee_structures
        \App\Models\FeeStructure::updateOrCreate(
            ['school_class_id' => $class->id, 'fee_type' => 'Monthly Fee'],
            ['amount' => $validated['monthly_fee']]
        );

        \App\Models\FeeStructure::updateOrCreate(
            ['school_class_id' => $class->id, 'fee_type' => 'Admission Fee'],
            ['amount' => $validated['admission_fee']]
        );

        return redirect()->route('classes.index')->with('success', 'Class and Fee Structure updated successfully.');
    }

    public function destroy(\App\Models\SchoolClass $class)
    {
        $class->delete();
        return redirect()->route('classes.index')->with('success', 'Class deleted successfully.');
    }
}
