<?php

namespace Tests\Feature\Controllers;

use App\Models\Enums\UserPermission;
use App\Models\Enums\UserRole;
use App\Models\Project\Project;
use Carbon\Carbon;
use Tests\Feature\ApiTestCase;

class ProjectControllerTest extends ApiTestCase
{
    /**
     * @inheritDoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        Project::truncate();

        $this->seedRoleAndPermissions();
        $this->loginUser(UserRole::USER);
    }

    /**
     * Test get all Project method.
     * @return void
     */
    public function testGetAllData()
    {
        $limit = 10;
        $perPage = 10;
        $projects = Project::factory()->withUser($this->user)->count($limit)->create();
        $projects = $projects->map(fn($project) => $this->projectToArray($project));

        $this->getJson(
            route('api.v1.projects.all', ['per_page' => $perPage]),
            ['Accept' => 'application/json']
        )->assertOk()
            ->assertJson($this->getSuccessResponsePagination(
                $projects->toArray(),
                route('api.v1.projects.all'),
                $limit,
                $perPage
            ));
    }

    /**
     * Test get Project by id method.
     * @return void
     */
    public function testFindProjectByID()
    {
        $project = Project::factory()->withUser($this->user)->create();

        $this->getJson(
            route('api.v1.projects.get-by-id', ['id' => $project['id']]),
            ['Accept' => 'application/json']
        )
            ->assertOk()
            ->assertJson($this->getSuccessResponse($this->projectToArray($project)));
    }

    /**
     * Test get Project by id method.
     * @return void
     */
    public function testCreateNewProject()
    {
        $projectData = Project::factory()->withUser($this->user)->make();

        $this->postJson(
            route('api.v1.projects.store'),
            $projectData->toArray()
        )
            ->assertOk()
            ->assertJsonStructure(['data' => array_keys($this->projectToArray($projectData))]);
    }

    /**
     * Test delete Project.
     * @return void
     */
    public function testDeleteProject()
    {
        $project = Project::factory()->withUser($this->user)->create();

        $this->deleteJson(
            route('api.v1.projects.delete', ['id' => $project->id])
        )
            ->assertOk()
            ->assertJson($this->getSuccessResponse());

        $this->assertDatabaseMissing($project->getTable(), ['id' => $project->id, 'deleted_at' => null]);
    }

    /**
     * Transform Project model to array with necessary keys.
     * @param Project $project
     * @return array
     */
    private function projectToArray(Project $project): array
    {
        return [
            'id' => $project->id,
            'name' => $project->name,
            'status' => $project->status->value,
            'description' => $project->description,
            'created_at' => Carbon::create($project->created_at)->toDateString(),
        ];
    }
}
