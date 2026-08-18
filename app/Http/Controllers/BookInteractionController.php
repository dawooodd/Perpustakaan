<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Like;
use App\Models\Bookmark;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookInteractionController extends Controller
{
    public function toggleLike(Book $book)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'unauthenticated'], 401);
        }

        $existing = Like::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            Like::create([
                'user_id' => Auth::id(),
                'book_id' => $book->id,
            ]);
            $liked = true;
        }

        return response()->json([
            'status' => 'ok',
            'liked' => $liked,
            'count' => $book->likesCount(),
        ]);
    }

    public function toggleBookmark(Book $book)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'unauthenticated'], 401);
        }

        $existing = Bookmark::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $bookmarked = false;
        } else {
            Bookmark::create([
                'user_id' => Auth::id(),
                'book_id' => $book->id,
            ]);
            $bookmarked = true;
        }

        return response()->json([
            'status' => 'ok',
            'bookmarked' => $bookmarked,
        ]);
    }

    public function storeComment(Request $request, Book $book)
    {
        if (!Auth::check()) {
            return response()->json(['status' => 'unauthenticated'], 401);
        }

        $request->validate([
            'body' => 'required|string|max:2000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'body' => $request->body,
            'parent_id' => $request->parent_id,
        ]);

        $comment->load('user');

        return response()->json([
            'status' => 'ok',
            'comment' => [
                'id' => $comment->id,
                'body' => $comment->body,
                'user_name' => $comment->user->name,
                'user_initials' => $comment->user->initials,
                'created_at' => $comment->created_at->diffForHumans(),
                'parent_id' => $comment->parent_id,
            ],
        ]);
    }

    public function getComments(Book $book)
    {
        $comments = $book->comments()
            ->with(['user', 'replies.user'])
            ->latest()
            ->get()
            ->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'body' => $comment->body,
                    'user_name' => $comment->user->name,
                    'user_initials' => $comment->user->initials,
                    'created_at' => $comment->created_at->diffForHumans(),
                    'replies' => $comment->replies->map(function ($reply) {
                        return [
                            'id' => $reply->id,
                            'body' => $reply->body,
                            'user_name' => $reply->user->name,
                            'user_initials' => $reply->user->initials,
                            'created_at' => $reply->created_at->diffForHumans(),
                        ];
                    }),
                ];
            });

        return response()->json(['comments' => $comments]);
    }
}
