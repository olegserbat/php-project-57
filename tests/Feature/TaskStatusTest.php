<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Tests\TestCase;

class TaskStatusTest extends TestCase
{
    private User $user;
    private $data = ['name' => 'normal'];

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function testIndex(): void
    {
        $response = $this->get('/task_statuses');
        $response->assertStatus(200);
    }

    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)->post('/task_statuses', $this->data);
        $response->assertStatus(302);
        $this->assertDatabaseHas('task_statuses', $this->data);
        $response->assertSessionHas('status');
    }

    public function testUpdate(): void
    {
        $this->actingAs($this->user)->post('/task_statuses', $this->data);
        $this->assertDatabaseHas('task_statuses', $this->data);
        $newData = ['name' => 'good'];
        $taskStatus = TaskStatus::where('name', 'normal')->first()->toArray();
        $id = $taskStatus['id'];
        $response = $this->actingAs($this->user)->patch("/task_statuses/{$id}", $newData);
        $newTaskStatus = TaskStatus::find($id)->toArray();
        $this->assertEquals('good', $newTaskStatus['name']);
        $response->assertSessionHas('status');
    }

    public function testDestroy(): void
    {
        //deleted
        $this->actingAs($this->user)->post('/task_statuses', $this->data);
        $taskStatus1 = TaskStatus::where('name', 'normal')->first();
        $response = $this->actingAs($this->user)->delete("/task_statuses/{$taskStatus1->id}");
        $this->assertDatabaseMissing('tasks', [
            'name' => $taskStatus1->name,
        ]);
        $response->assertSessionHas('status');

        //undeleted
        $this->actingAs($this->user)->post('/task_statuses', $this->data);
        $taskStatus2 = TaskStatus::where('name', 'normal')->first();
        Task::factory()->for($this->user, 'creator')->create(['status_id' => $taskStatus2->id]);
        $response = $this->actingAs($this->user)->delete("/task_statuses/{$taskStatus2->id}");
        $this->assertDatabaseHas('task_statuses', $this->data);
        $response->assertSessionHas('alert');
    }
}
