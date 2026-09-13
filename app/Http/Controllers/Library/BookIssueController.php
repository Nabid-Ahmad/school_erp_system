<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookIssue;
use App\Models\Student;
use Illuminate\Http\Request;

class BookIssueController extends Controller
{
    public function index()
    {
        $issues = BookIssue::with(['book', 'student'])->latest()->paginate(10);
        return view('library.issues.index', compact('issues'));
    }

    public function create()
    {
        $books = Book::where('available_copies', '>', 0)->get();
        $students = Student::all();
        return view('library.issues.create', compact('books', 'students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'student_id' => 'required|exists:students,id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
        ]);

        $book = Book::findOrFail($validated['book_id']);
        
        if ($book->available_copies < 1) {
            return back()->with('error', 'Book is not available.');
        }

        $book->decrement('available_copies');
        BookIssue::create($validated);

        return redirect()->route('library.issues.index')->with('success', 'Book issued successfully.');
    }

    public function returnBook(BookIssue $issue)
    {
        if ($issue->status === 'returned') {
            return back()->with('error', 'Book is already returned.');
        }

        $issue->update([
            'status' => 'returned',
            'return_date' => now(),
        ]);

        $issue->book()->increment('available_copies');

        return back()->with('success', 'Book returned successfully.');
    }
}
