<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Publisher;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(['author', 'publisher'])->get();
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $authors = Author::all();
        $publishers = Publisher::all();
        return view('books.create', compact('authors', 'publishers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'isbn' => 'required',
            'description' => 'required',
            'ebook' => 'file|mimes:pdf,doc,docx',
            'author_id' => 'required',
            'publisher_id' => 'required',
        ]);

        $path = null;
        if ($request->hasFile('ebook')) {
            $path = $request->file('ebook')->store('ebooks');
        }

        Book::create([
            'title' => $request->title,
            'isbn' => $request->isbn,
            'description' => $request->description,
            'ebook' => $path,
            'author_id' => $request->author_id,
            'publisher_id' => $request->publisher_id,
        ]);

        return redirect()->route('books.index');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $authors = Author::all();
        $publishers = Publisher::all();
        return view('books.edit', compact('book', 'authors', 'publishers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'isbn' => 'required',
            'description' => 'required',
            'ebook' => 'file|mimes:pdf,doc,docx',
            'author_id' => 'required',
            'publisher_id' => 'required',
        ]);

        $book = Book::findOrFail($id);

        $path = $book->ebook;
        if ($request->hasFile('ebook')) {
            $path = $request->file('ebook')->store('ebooks');
        }

        $book->update([
            'title' => $request->title,
            'isbn' => $request->isbn,
            'description' => $request->description,
            'ebook' => $path,
            'author_id' => $request->author_id,
            'publisher_id' => $request->publisher_id,
        ]);

        return redirect()->route('books.index');
    }

    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect()->route('books.index');
    }
}

