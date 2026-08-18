<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;

    protected $fillable = ['book_id', 'chapter_number', 'title', 'content'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function getNextAttribute()
    {
        return static::where('book_id', $this->book_id)
            ->where('chapter_number', '>', $this->chapter_number)
            ->orderBy('chapter_number')
            ->first();
    }

    public function getPreviousAttribute()
    {
        return static::where('book_id', $this->book_id)
            ->where('chapter_number', '<', $this->chapter_number)
            ->orderByDesc('chapter_number')
            ->first();
    }
}
