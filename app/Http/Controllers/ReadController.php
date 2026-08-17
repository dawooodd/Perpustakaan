<?php

namespace App\Http\Controllers;

use App\Models\Read;
use Illuminate\Http\Request;

class ReadController extends Controller
{
    public function index()
    {
        $reads = Read::with(['user', 'book'])->latest()->get();
        return view('reads.index', compact('reads'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'book_id' => 'required|exists:books,id',
        ]);

        Read::create([
            'user_id' => $request->user_id,
            'book_id' => $request->book_id,
            'last_read_at' => now(),
        ]);

        return redirect()->route('reads.index');
    }

    public function destroy($id)
    {
        Read::findOrFail($id)->delete();
        return redirect()->route('reads.index');
    }
}
