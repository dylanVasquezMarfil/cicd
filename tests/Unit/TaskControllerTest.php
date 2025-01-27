<?php

namespace Tests\Unit;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_no_tasks(): void
    {
        $response = $this->getJson('/api/v1/tasks');

        $response->assertStatus(404)
            ->assertJsonStructure([
                'message',
                'data'
            ]);
    }

    public function test_index_returns_tasks(): void
    {
        Task::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/tasks');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => [
                    '*' => ['id', 'name', 'description', 'status']
                ],
            ]);
    }

    public function test_show_returns_task(): void
    {
        $task = Task::factory()->create();

        $response = $this->getJson("/api/v1/tasks/{$task->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'data' => ['id', 'name', 'description', 'status']
            ]);
    }

    public function test_show_returns_not_found(): void
    {
        $response = $this->getJson('/api/v1/tasks/1');

        $response->assertStatus(404)
            ->assertJsonStructure([
                'message',
                'data'
            ]);
    }

    public function test_store_creates_task(): void
    {
        $task = Task::factory()->make();

        $response = $this->postJson('/api/v1/tasks', $task->toArray());

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Task created successfully'
            ]);

        $this->assertDatabaseHas('tasks', $task->toArray());
    }

    public function test_store_validates_request(): void
    {
        $response = $this->postJson('/api/v1/tasks', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'description']);
    }

    public function test_update_updates_task(): void
    {
        $task = Task::factory()->create();
        $newTask = Task::factory()->make();

        $response = $this->putJson("/api/v1/tasks/{$task->id}", $newTask->toArray());

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Task updated successfully'
            ]);

        $this->assertDatabaseHas('tasks', $newTask->toArray());
    }
}
