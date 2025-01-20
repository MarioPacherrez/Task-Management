<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticate()
    {
        $user = User::factory()->create();
        $token = auth('api')->login($user);

        return ['Authorization' => "Bearer $token"];
    }

    public function test_authenticated_user_can_create_task()
    {
        $headers = $this->authenticate();

        $response = $this->postJson('/api/tasks', [
            'title' => 'Test Tarea',
            'description' => 'Test Descripción',
            'status' => 'pending',
        ], $headers);

        $response->assertStatus(201)
            ->assertJsonStructure(['id', 'title', 'description', 'status', 'user_id']);
    }

    public function test_authenticated_user_can_view_tasks()
    {
        $headers = $this->authenticate();

        Task::factory()->count(15)->create(['user_id' => auth('api')->user()->id]);

        $response = $this->getJson('/api/tasks', $headers);

        $response->assertStatus(200)
            ->assertJsonStructure(['data', 'links'])
            ->assertJsonCount(10, 'data');
    }

    public function test_authenticated_user_can_view_specific_task()
    {
        $headers = $this->authenticate();

        $task = Task::factory()->create(['user_id' => auth('api')->user()->id]);

        $response = $this->getJson("/api/tasks/{$task->id}", $headers);

        $response->assertStatus(200)
            ->assertJson(['id' => $task->id, 'title' => $task->title]);
    }

    public function test_user_cannot_access_others_tasks()
    {
        $headers = $this->authenticate();

        $user = User::factory()->create();

        $otherUserTask = Task::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->getJson("/api/tasks/{$otherUserTask->id}", $headers);

        $response->assertStatus(404)
            ->assertJson(['error' => 'Tarea no encontrada.']);
    }
}
