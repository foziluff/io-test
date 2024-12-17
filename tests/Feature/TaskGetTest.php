<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskGetTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        Task::factory()->count(20)->create(
            [
                'user_id' => $this->user->id,
                'title' => 'title',
                'description' => 'description',
                'status' => 1,
            ]
        );
    }


    public function test_user_can_fetch_tasks_with_pagination()
    {
        $this->actingAs($this->user);

        $response = $this->getJson('/api/tasks');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'title',
                        'description',
                        'status',
                        'created_at',
                        'updated_at',
                    ]
                ],
            ]);

        $response->assertJsonFragment([
            'current_page' => 1,
            'per_page' => 10,
            'total' => 20,
        ]);
    }

    public function test_task_index_requires_authentication()
    {
        $response = $this->getJson('/api/tasks');

        $response->assertStatus(401);
    }
}
