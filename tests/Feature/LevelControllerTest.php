<?php

namespace Tests\Feature;

use App\Models\Level;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LevelControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Since we don't have Admin roles specifically defined yet, we'll just act as a normal user.
        // Or if there's an admin middleware, we need to pass it.
        $this->user = User::factory()->create();
    }

    public function test_it_can_list_levels()
    {
        Level::create(['name' => 'Beginner']);
        Level::create(['name' => 'Advanced']);

        $response = $this->actingAs($this->user)->get(route('levels.index'));

        $response->assertStatus(200);
        $response->assertSee('Beginner');
        $response->assertSee('Advanced');
    }

    public function test_it_can_create_a_level()
    {
        $response = $this->actingAs($this->user)->post(route('levels.store'), [
            'name' => 'Intermediate',
        ]);

        $response->assertRedirect(route('levels.index'));
        $this->assertDatabaseHas('levels', ['name' => 'Intermediate']);
    }

    public function test_it_can_update_a_level()
    {
        $level = Level::create(['name' => 'Old Name']);

        $response = $this->actingAs($this->user)->put(route('levels.update', $level), [
            'name' => 'New Name',
        ]);

        $response->assertRedirect(route('levels.index'));
        $this->assertDatabaseHas('levels', ['name' => 'New Name']);
    }

    public function test_it_can_delete_a_level()
    {
        $level = Level::create(['name' => 'To Be Deleted']);

        $response = $this->actingAs($this->user)->delete(route('levels.destroy', $level));

        $response->assertRedirect(route('levels.index'));
        $this->assertDatabaseMissing('levels', ['name' => 'To Be Deleted']);
    }
}
