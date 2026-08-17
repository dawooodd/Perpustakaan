<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index()
    {
        $levels = Level::all();
        return view('levels.index', compact('levels'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Level::create($request->only('name'));
        return redirect()->route('levels.index');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $level = Level::findOrFail($id);
        $level->update($request->only('name'));
        return redirect()->route('levels.index');
    }

    public function destroy($id)
    {
        Level::findOrFail($id)->delete();
        return redirect()->route('levels.index');
    }
}
