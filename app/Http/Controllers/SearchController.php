<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Expense;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->input('q', ''));

        $results = [
            'students' => new Collection,
            'teachers' => new Collection,
            'classes' => new Collection,
            'subjects' => new Collection,
            'events' => new Collection,
            'expenses' => new Collection,
        ];

        if (strlen($query) >= 2) {
            $term = '%'.$query.'%';

            if (auth()->user()->can('manage students')) {
                $results['students'] = Student::where('name', 'like', $term)
                    ->orWhere('roll', 'like', $term)
                    ->limit(10)
                    ->get();
            }

            if (auth()->user()->can('manage teachers')) {
                $results['teachers'] = Teacher::where('name', 'like', $term)
                    ->orWhere('teacher_id_number', 'like', $term)
                    ->limit(10)
                    ->get();
            }

            if (auth()->user()->can('manage classes')) {
                $results['classes'] = SchoolClass::where('name', 'like', $term)
                    ->limit(10)
                    ->get();
            }

            if (auth()->user()->can('manage subjects')) {
                $results['subjects'] = Subject::with('schoolClass')
                    ->where('name', 'like', $term)
                    ->limit(10)
                    ->get();
            }

            if (auth()->user()->can('manage events')) {
                $results['events'] = Event::where('title', 'like', $term)
                    ->limit(10)
                    ->get();
            }

            if (auth()->user()->can('manage expenses')) {
                $results['expenses'] = Expense::where('title', 'like', $term)
                    ->limit(10)
                    ->get();
            }
        }

        $total = collect($results)->flatten()->count();

        return view('search.index', compact('query', 'results', 'total'));
    }
}
