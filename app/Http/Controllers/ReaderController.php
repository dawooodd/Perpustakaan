<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Chapter;
use App\Models\Read;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReaderController extends Controller
{
    public function show(Book $book, Chapter $chapter = null)
    {
        $book->load(['author', 'chapters', 'likes', 'bookmarks']);

        // If no chapter specified, try to resume or start from first
        if (!$chapter) {
            if (Auth::check()) {
                $read = Read::where('user_id', Auth::id())
                    ->where('book_id', $book->id)
                    ->first();

                if ($read && $read->last_chapter_id) {
                    $chapter = Chapter::find($read->last_chapter_id);
                }
            }

            if (!$chapter) {
                $chapter = $book->chapters()->orderBy('chapter_number')->first();
            }
        }

        // If still no chapter, check if book has inline content
        if (!$chapter && !$book->content) {
            abort(404, 'Buku ini belum memiliki konten.');
        }

        $isLiked = Auth::check() ? $book->isLikedBy(Auth::user()) : false;
        $isBookmarked = Auth::check() ? $book->isBookmarkedBy(Auth::user()) : false;
        $likesCount = $book->likesCount();

        // Update read progress for authenticated users
        if (Auth::check() && $chapter) {
            Read::updateOrCreate(
                ['user_id' => Auth::id(), 'book_id' => $book->id],
                ['last_read_at' => now(), 'last_chapter_id' => $chapter->id]
            );
        }

        return view('books.reader', compact(
            'book', 'chapter', 'isLiked', 'isBookmarked', 'likesCount'
        ));
    }

    public function updateProgress(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'chapter_id' => 'required|exists:chapters,id',
            'last_page' => 'nullable|integer|min:0',
        ]);

        if (!Auth::check()) {
            return response()->json(['status' => 'guest'], 401);
        }

        Read::updateOrCreate(
            ['user_id' => Auth::id(), 'book_id' => $request->book_id],
            [
                'last_read_at' => now(),
                'last_chapter_id' => $request->chapter_id,
                'last_page' => $request->last_page ?? 0,
            ]
        );

        return response()->json(['status' => 'saved']);
    }
}
