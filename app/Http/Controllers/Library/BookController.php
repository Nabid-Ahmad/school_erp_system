<?php

namespace App\Http\Controllers\Library;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::latest()->paginate(10);
        return view('library.books.index', compact('books'));
    }

    public function create()
    {
        return view('library.books.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'total_copies' => 'required|integer|min:1',
        ]);

        $validated['available_copies'] = $validated['total_copies'];
        Book::create($validated);

        return redirect()->route('library.books.index')->with('success', 'Book added successfully.');
    }
}
