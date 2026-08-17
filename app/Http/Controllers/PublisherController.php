<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function index()
    {
        $publishers = Publisher::withCount('books')->get();
        return view('publishers.index', compact('publishers'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Publisher::create($request->only('name'));
        return redirect()->route('publishers.index');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $publisher = Publisher::findOrFail($id);
        $publisher->update($request->only('name'));
        return redirect()->route('publishers.index');
    }

    public function destroy($id)
    {
        Publisher::findOrFail($id)->delete();
        return redirect()->route('publishers.index');
    }
}
