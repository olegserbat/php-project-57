<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Tests\TestCase;

class LabelTest extends TestCase
{
    private User $user;
    private array $data;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->data = Label::factory()->make()->toArray();
    }

    public function testIndex(): void
    {
        $response = $this->get('/labels');
        $response->assertStatus(200);
    }

    public function testCreate(): void
    {
        $response = $this->actingAs($this->user)->post('/labels', $this->data);
        $response->assertStatus(302);
        $this->assertDatabaseHas('labels', $this->data);
        $response->assertSessionHas('labels');
    }

    public function testUpdate(): void
    {
        $this->actingAs($this->user)->post('/labels', $this->data);
        $dataNew = Label::factory()->make()->toArray();
        $label = Label::where('name', $this->data['name'])->first();
        $response = $this->actingAs($this->user)->patch("/labels/{$label->id}", $dataNew);
        $this->assertDatabaseHas('labels', $dataNew);
        $response->assertSessionHas('labels');
    }

    public function testDestroy(): void
    {
        //deleted
        $tasStatus = TaskStatus::factory()->create();
        $this->actingAs($this->user)->post('/labels', $this->data);
        $label = Label::where('name', $this->data['name'])->first();
        $response = $this->actingAs($this->user)->delete("/labels/{$label->id}");
        $this->assertDatabaseMissing('labels', [
            'name' => $label->name,
        ]);
        $response->assertSessionHas('labels');
        //undeleted
        $label2 = Label::factory()->create();
        $task = Task::factory()->for($this->user, 'creator')->create(['status_id' => $tasStatus->id]);
        $task->labeles()->attach([$label2->id]);
        $response = $this->actingAs($this->user)->delete("/labels/{$label2->id}");
        $response->assertSessionHas('alert');
        $this->assertDatabaseHas('labels', ['name' => $label2->name]);
    }
}
