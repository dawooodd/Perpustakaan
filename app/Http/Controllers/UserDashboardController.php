<?php

namespace App\Http\Controllers;

use App\Models\Read;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Reading history with progress
        $readingHistory = Read::where('user_id', $user->id)
            ->with(['book.author', 'book.chapters', 'chapter'])
            ->latest('last_read_at')
            ->take(10)
            ->get();

        // Bookmarked books
        $bookmarks = Bookmark::where('user_id', $user->id)
            ->with(['book.author'])
            ->latest()
            ->get();

        return view('user.dashboard', compact('readingHistory', 'bookmarks'));
    }
}
