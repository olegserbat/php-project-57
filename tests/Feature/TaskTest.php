<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;

class TaskTest extends TestCase
{
    private User $user;
    private TaskStatus $status;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->status = TaskStatus::factory()->create(['id' => 2]);
    }

    public function testIndex(): void
    {
        $response = $this->get('/tasks');
        $response->assertStatus(200);
    }

    public function testCreate(): void
    {
        $data1 = Task::factory()->for($this->user, 'creator')->for($this->status, 'status')
            ->state(new Sequence(
                ['assigned_to_id' => null],
            ))->make()->attributesToArray();
        $response = $this->actingAs($this->user)->post('/tasks', $data1);
        $response->assertStatus(302);
        $this->assertDatabaseHas('tasks', $data1);
        $response->assertSessionHas('task');

        $data2 = Task::factory()->for($this->user, 'creator')->for($this->status, 'status')
            ->state(new Sequence(
                ['assigned_to_id' => $this->user->id],
            ))->make()->attributesToArray();
        $response = $this->actingAs($this->user)->post('/tasks', $data2);
        $response->assertStatus(302);
        $this->assertDatabaseHas('tasks', $data2);
        $response->assertSessionHas('task');
    }

    public function testUpdate(): void
    {
        $dataOld = Task::factory()->for($this->user, 'creator')->for($this->status, 'status')
            ->make()->attributesToArray();
        $response = $this->actingAs($this->user)->post('/tasks', $dataOld);
        $dataNew = Task::factory()->for($this->user, 'creator')->for($this->status, 'status')
            ->make()->attributesToArray();
        $task = Task::where('name', $dataOld['name'])->first();
        $this->actingAs($this->user)->patch("/tasks/{$task->id}", $dataNew);
        $this->assertDatabaseHas('tasks', $dataNew);
        $response->assertSessionHas('task');
    }

    public function testDestroy(): void
    {
        $data = Task::factory()->for($this->user, 'creator')->for($this->status, 'status')
            ->make()->attributesToArray();
        $response = $this->actingAs($this->user)->post('/tasks', $data);
        $task = Task::where('name', $data['name'])->first();
        $this->actingAs($this->user)->delete("/tasks/{$task->id}");
        $response->assertSessionHas('task');
        $this->assertDatabaseMissing('tasks', [
            'name' => $task->name,
            'description' => $task->description,
        ]);
    }
}
