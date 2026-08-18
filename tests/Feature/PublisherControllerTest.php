<?php

namespace Tests\Feature;

use App\Models\Publisher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublisherControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_it_can_list_publishers()
    {
        Publisher::create(['name' => 'Publisher A']);
        Publisher::create(['name' => 'Publisher B']);

        $response = $this->actingAs($this->user)->get(route('publishers.index'));

        $response->assertStatus(200);
        $response->assertSee('Publisher A');
        $response->assertSee('Publisher B');
    }

    public function test_it_can_create_a_publisher()
    {
        $response = $this->actingAs($this->user)->post(route('publishers.store'), [
            'name' => 'Publisher C',
        ]);

        $response->assertRedirect(route('publishers.index'));
        $this->assertDatabaseHas('publishers', ['name' => 'Publisher C']);
    }

    public function test_it_can_update_a_publisher()
    {
        $publisher = Publisher::create(['name' => 'Old Name']);

        $response = $this->actingAs($this->user)->put(route('publishers.update', $publisher), [
            'name' => 'New Name',
        ]);

        $response->assertRedirect(route('publishers.index'));
        $this->assertDatabaseHas('publishers', ['name' => 'New Name']);
    }

    public function test_it_can_delete_a_publisher()
    {
        $publisher = Publisher::create(['name' => 'To Be Deleted']);

        $response = $this->actingAs($this->user)->delete(route('publishers.destroy', $publisher));

        $response->assertRedirect(route('publishers.index'));
        $this->assertDatabaseMissing('publishers', ['name' => 'To Be Deleted']);
    }
}
