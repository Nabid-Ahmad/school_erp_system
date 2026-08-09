<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\FeeStructure;
use App\Models\SchoolClass;
use App\Services\FeeDuesService;
use Illuminate\Http\Request;

class FeeStructureController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::with('feeStructures')->get();
        $feeTypes = FeeDuesService::FEE_TYPES;

        return view('fee_structures.index', compact('classes', 'feeTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'fee_type' => 'required|string|in:'.implode(',', FeeDuesService::FEE_TYPES),
            'amount' => 'required|numeric|min:0',
        ]);

        FeeStructure::updateOrCreate(
            ['school_class_id' => $validated['school_class_id'], 'fee_type' => $validated['fee_type']],
            ['amount' => $validated['amount']]
        );

        return redirect()->back()->with('success', 'Fee structure updated successfully.');
    }
}
