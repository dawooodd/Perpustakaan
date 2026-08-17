<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::withCount('books')->get();
        return view('authors.index', compact('authors'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Author::create($request->only('name'));
        return redirect()->route('authors.index');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $author = Author::findOrFail($id);
        $author->update($request->only('name'));
        return redirect()->route('authors.index');
    }

    public function destroy($id)
    {
        Author::findOrFail($id)->delete();
        return redirect()->route('authors.index');
    }
}
