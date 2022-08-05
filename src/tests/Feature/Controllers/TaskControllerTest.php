<?php

namespace Tests\Feature\Controllers;

use App\Models\Task\Task;
use App\Models\Task\TaskStatus;
use App\Models\UserRole;
use Carbon\Carbon;
use Tests\Feature\ApiTestCase;

class TaskControllerTest extends ApiTestCase
{
    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        Task::truncate();

        $this->seedRoleAndPermissions();
        $this->loginUser(UserRole::CLIENT);
    }

    /**
     * Test get all Task method.
     * @return void
     */
    public function testGetAllData()
    {
        $tasks = Task::factory()->count(10)->create();
        $tasks = $tasks->map(fn($task) => $this->taskToArray($task));

        $this->getJson(
            route('api.v1.tasks.all'),
            ['Accept' => 'application/json']
        )
            ->assertOk()
            ->assertJson($this->getSuccessResponse($tasks->toArray()));
    }

    /**
     * Test get Task by id method.
     * @return void
     */
    public function testFindTaskByID()
    {
        $task = Task::factory()->create();

        $this->getJson(
            route('api.v1.tasks.get-by-id', ['id' => $task['id']]),
            ['Accept' => 'application/json']
        )
            ->assertOk()
            ->assertJson($this->getSuccessResponse($this->taskToArray($task)));
    }

    /**
     * Test get Task by id method.
     * @return void
     */
    public function testCreateNewTask()
    {
        $taskData = Task::factory()->make();

        $this->postJson(
            route('api.v1.tasks.store'),
            $taskData->toArray()
        )
            ->assertOk()
            ->assertJsonStructure(['data' => array_keys($this->taskToArray($taskData))]);
    }

    /**
     * Test delete Task.
     * @return void
     */
    public function testDeleteTask()
    {
        $task = Task::factory()->create();

        $this->deleteJson(
            route('api.v1.tasks.delete', ['id' => $task->id])
        )
            ->assertOk()
            ->assertJson($this->getSuccessResponse());

        $this->assertDatabaseMissing($task->getTable(), ['id' => $task->id, 'deleted_at' => null]);
    }


    /**
     * Transform Task model to array with necessary keys.
     * @param Task $task
     * @return array
     */
    private function taskToArray(Task $task): array
    {
        return [
            'id' => $task->id,
            'name' => $task->name,
            'description' => $task->description,
            'status' => $task->status->value,
            'start_at' => Carbon::create($task->start_at)->toJSON(),
            'end_at' => Carbon::create($task->end_at)->toJSON(),
            'created_at' => Carbon::create($task->created_at)->toJSON(),
        ];
    }
}
