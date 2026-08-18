<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use App\Models\Publisher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->author = Author::create(['name' => 'Author Name']);
        $this->publisher = Publisher::create(['name' => 'Publisher Name']);
    }

    public function test_it_can_list_books()
    {
        Book::create([
            'title' => 'Test Book',
            'isbn' => '1234567890123',
            'description' => 'Test Description',
            'author_id' => $this->author->id,
            'publisher_id' => $this->publisher->id,
        ]);

        $response = $this->actingAs($this->user)->get(route('books.index'));

        $response->assertStatus(200);
        $response->assertSee('Test Book');
    }

    public function test_it_can_create_a_book()
    {
        $response = $this->actingAs($this->user)->post(route('books.store'), [
            'title' => 'New Book',
            'isbn' => '1234567890123',
            'description' => 'New Description',
            'author_id' => $this->author->id,
            'publisher_id' => $this->publisher->id,
        ]);

        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseHas('books', ['title' => 'New Book']);
    }

    public function test_it_can_update_a_book()
    {
        $book = Book::create([
            'title' => 'Old Book',
            'isbn' => '1234567890123',
            'description' => 'Old Description',
            'author_id' => $this->author->id,
            'publisher_id' => $this->publisher->id,
        ]);

        $response = $this->actingAs($this->user)->put(route('books.update', $book), [
            'title' => 'Updated Book',
            'isbn' => '1234567890123',
            'description' => 'Updated Description',
            'author_id' => $this->author->id,
            'publisher_id' => $this->publisher->id,
        ]);

        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseHas('books', ['title' => 'Updated Book']);
    }

    public function test_it_can_delete_a_book()
    {
        $book = Book::create([
            'title' => 'To Be Deleted',
            'isbn' => '1234567890123',
            'description' => 'Description',
            'author_id' => $this->author->id,
            'publisher_id' => $this->publisher->id,
        ]);

        $response = $this->actingAs($this->user)->delete(route('books.destroy', $book));

        $response->assertRedirect(route('books.index'));
        $this->assertDatabaseMissing('books', ['title' => 'To Be Deleted']);
    }
}
