<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_it_can_list_authors()
    {
        Author::create(['name' => 'Author A']);
        Author::create(['name' => 'Author B']);

        $response = $this->actingAs($this->user)->get(route('authors.index'));

        $response->assertStatus(200);
        $response->assertSee('Author A');
        $response->assertSee('Author B');
    }

    public function test_it_can_create_an_author()
    {
        $response = $this->actingAs($this->user)->post(route('authors.store'), [
            'name' => 'Author C',
        ]);

        $response->assertRedirect(route('authors.index'));
        $this->assertDatabaseHas('authors', ['name' => 'Author C']);
    }

    public function test_it_can_update_an_author()
    {
        $author = Author::create(['name' => 'Old Name']);

        $response = $this->actingAs($this->user)->put(route('authors.update', $author), [
            'name' => 'New Name',
        ]);

        $response->assertRedirect(route('authors.index'));
        $this->assertDatabaseHas('authors', ['name' => 'New Name']);
    }

    public function test_it_can_delete_an_author()
    {
        $author = Author::create(['name' => 'To Be Deleted']);

        $response = $this->actingAs($this->user)->delete(route('authors.destroy', $author));

        $response->assertRedirect(route('authors.index'));
        $this->assertDatabaseMissing('authors', ['name' => 'To Be Deleted']);
    }
}
