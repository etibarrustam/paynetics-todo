<?php

namespace Tests\Feature\Controllers;

use App\Models\Enums\UserRole;
use App\Models\Project\Project;
use App\Models\Task\Task;
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
        $this->loginUser(UserRole::USER);
    }

    /**
     * Test get all Task method.
     * @return void
     */
    public function testGetAllData()
    {
        $limit = 10;
        $perPage = 10;

        $project = Project::factory()->withUser($this->user)->create();
        $tasks = Task::factory()->withProject($project)->count(10)->create();
        $tasks = $tasks->map(fn($task) => $this->taskToArray($task));

        $this->getJson(
            route('api.v1.tasks.all', ['per_page' => $perPage, 'project_id' => $project->id]),
            ['Accept' => 'application/json']
        )
            ->assertOk()
            ->assertJson($this->getSuccessResponsePagination(
                $tasks->toArray(),
                route('api.v1.tasks.all'),
                $limit,
                $perPage
            ));
    }

    /**
     * Test get Task by id method.
     * @return void
     */
    public function testFindTaskByID()
    {
        $project = Project::factory()->withUser($this->user)->create();
        $task = Task::factory()->withProject($project)->create();

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
        $project = Project::factory()->withUser($this->user)->create();
        $taskData = Task::factory()->withProject($project)->make();

        $this->postJson(
            route('api.v1.tasks.store'),
            array_merge($this->taskToArray($taskData), ['project_id' => $project->id])
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
        $project = Project::factory()->withUser($this->user)->create();
        $task = Task::factory()->withProject($project)->create();

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
        $data = [
            'name' => $task->name,
            'description' => $task->description,
            'status' => $task->status->value,
            'start_at' => Carbon::create($task->start_at)->toDateString(),
            'end_at' => Carbon::create($task->end_at)->toDateString(),
            'created_at' => Carbon::create($task->created_at)->toDateString(),
        ];

        if ($task->id) {
            $data['id'] = $task->id;
        }

        return $data;
    }
}
