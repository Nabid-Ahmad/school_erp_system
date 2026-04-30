<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;

use App\Models\Student;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::all();
        return view('promotions.index', compact('classes'));
    }

    public function promote(Request $request)
    {
        $request->validate([
            'from_class_id' => 'required|exists:school_classes,id',
            'to_class_id' => 'required|exists:school_classes,id',
        ]);

        if ($request->from_class_id == $request->to_class_id) {
            return redirect()->back()->with('error', 'From and To classes cannot be the same!');
        }

        $students = Student::where('school_class_id', $request->from_class_id)->get();
        
        if ($students->isEmpty()) {
            return redirect()->back()->with('error', 'No students found in the selected class.');
        }

        foreach ($students as $student) {
            $student->update([
                'school_class_id' => $request->to_class_id
            ]);
        }

        return redirect()->route('promotions.index')->with('success', count($students) . ' students promoted successfully.');
    }
}
