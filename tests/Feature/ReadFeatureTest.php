<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use App\Models\Chapter;
use App\Models\Publisher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $author = Author::create(['name' => 'Author Name']);
        $publisher = Publisher::create(['name' => 'Publisher Name']);
        
        $this->book = Book::create([
            'title' => 'Read Test Book',
            'isbn' => '1234567890124',
            'description' => 'Read Test Description',
            'author_id' => $author->id,
            'publisher_id' => $publisher->id,
        ]);

        $this->chapter = Chapter::create([
            'book_id' => $this->book->id,
            'chapter_number' => 1,
            'title' => 'Chapter 1',
            'content' => 'Chapter Content',
        ]);
    }

    public function test_user_can_access_reader()
    {
        // Depending on ReaderController logic, this should either create a Read or update it.
        $response = $this->actingAs($this->user)->get(route('books.read', ['book' => $this->book, 'chapter' => $this->chapter->id]));

        $response->assertStatus(200);
        $this->assertDatabaseHas('reads', [
            'user_id' => $this->user->id,
            'book_id' => $this->book->id,
        ]);
    }

    public function test_user_can_update_read_progress()
    {
        $response = $this->actingAs($this->user)->postJson(route('reader.progress'), [
            'book_id' => $this->book->id,
            'chapter_id' => $this->chapter->id,
            'last_page' => 5,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('reads', [
            'user_id' => $this->user->id,
            'book_id' => $this->book->id,
            'last_page' => 5,
            'last_chapter_id' => $this->chapter->id,
        ]);
    }

    public function test_user_can_like_a_book()
    {
        $response = $this->actingAs($this->user)->postJson(route('books.like', $this->book));

        $response->assertStatus(200);
        $this->assertDatabaseHas('likes', [
            'user_id' => $this->user->id,
            'book_id' => $this->book->id,
        ]);

        // Second click should unlike
        $response2 = $this->actingAs($this->user)->postJson(route('books.like', $this->book));
        $response2->assertStatus(200);
        $this->assertDatabaseMissing('likes', [
            'user_id' => $this->user->id,
            'book_id' => $this->book->id,
        ]);
    }

    public function test_user_can_bookmark_a_book()
    {
        $response = $this->actingAs($this->user)->postJson(route('books.bookmark', $this->book));

        $response->assertStatus(200);
        $this->assertDatabaseHas('bookmarks', [
            'user_id' => $this->user->id,
            'book_id' => $this->book->id,
        ]);
    }

    public function test_user_can_comment_on_a_book()
    {
        $response = $this->actingAs($this->user)->postJson(route('books.comment', $this->book), [
            'body' => 'This is a test comment',
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('comments', [
            'user_id' => $this->user->id,
            'book_id' => $this->book->id,
            'body' => 'This is a test comment',
        ]);
    }
}
