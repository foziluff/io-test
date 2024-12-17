<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;


    public function test_user_can_register_successfully()
    {
        $payload = [
            'name' => 'Test User',
            'email' => 'testtest@example.com',
            'password' => 'password123'
        ];

        $response = $this->postJson('/api/register', $payload);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'access_token'
            ]);

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'testtest@example.com'
        ]);
    }


    public function test_registration_fails_with_validation_errors()
    {
        $payload = [];

        $response = $this->postJson('/api/register', $payload);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'errors' => ['name', 'email', 'password']
            ]);
    }


    public function test_registration_fails_if_email_is_taken()
    {
        User::factory()->create([
            'email' => 'testtest@example.com',
        ]);

        $payload = [
            'name' => 'Test 2',
            'email' => 'testtest@example.com',
            'password' => 'password123'
        ];

        $response = $this->postJson('/api/register', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
