<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TasksCreateTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_user_can_create_a_task_successfully()
    {
        $this->actingAs($this->user);

        $payload = [
            'title'       => 'New Task',
            'description' => 'This is a test task',
            'status'      => 1,
        ];

        $response = $this->postJson('/api/tasks', $payload);

        $response->assertStatus(200)
        ->assertJson([
            'title'       => 'New Task',
            'description' => 'This is a test task',
            'status'      => 1,
        ]);

        $this->assertDatabaseHas('tasks', [
            'title'       => 'New Task',
            'description' => 'This is a test task',
            'status'      => 1,
        ]);
    }


    public function test_task_creation_fails_with_validation_errors()
    {
        $this->actingAs($this->user);

        $payload = [];

        $response = $this->postJson('/api/tasks', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'description', 'status']);
    }


    public function test_task_creation_fails_with_invalid_status()
    {
        $this->actingAs($this->user);

        $payload = [
            'title'       => 'Invalid Task',
            'description' => 'This task has invalid status',
            'status'      => 5,
        ];

        $response = $this->postJson('/api/tasks', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['status']);
    }
}
