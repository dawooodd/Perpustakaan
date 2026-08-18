<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Read extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'book_id', 'last_read_at', 'last_page', 'last_chapter_id'];

    protected $casts = [
        'last_read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'last_chapter_id');
    }

    public function getProgressPercentAttribute()
    {
        $totalChapters = $this->book->chapters()->count();
        if ($totalChapters === 0) return 0;

        $currentChapter = $this->chapter;
        if (!$currentChapter) return 0;

        return round(($currentChapter->chapter_number / $totalChapters) * 100);
    }
}
