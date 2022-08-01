<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Repository;
use App\Http\Requests\Project\ProjectRequest;
use App\Http\Resources\Project\ProjectResource;
use App\Http\Resources\Project\ProjectResourceCollection;
use App\Http\Resources\Project\ProjectStatusResourceCollection;
use App\Http\Responses\ApiResponse;
use App\Http\Responses\HasJsonResponse;
use App\Models\Project\Project;
use App\Models\Project\ProjectStatus;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class ProjectController extends Controller
{
    use HasJsonResponse;

    /**
     * @var Repository
     */
    private Repository $repository;

    public function __construct()
    {
        $this->repository = Repository::make(Project::class);
    }

    public function all(): ApiResponse
    {
        return $this->successResponse(
            ProjectResourceCollection::make($this->repository->all())
        );
    }

    public function getById(int $id): ApiResponse
    {
        try {
            $project = $this->repository->getById($id);
        } catch (ModelNotFoundException $e) {
            return $this->failResponse(['project' => __('exceptions.entity_not_found', ['entity' => 'Project'])]);
        } catch (Throwable $e) {
            return $this->serviceUnavailable();
        }

        return $this->successResponse(ProjectResource::make($project));
    }

    public function getStatuses(): ApiResponse
    {
        return $this->successResponse(ProjectStatusResourceCollection::make(ProjectStatus::cases()));
    }

    public function store(ProjectRequest $request): ApiResponse
    {
        try {
            $project = $this->repository->create($request->safe()->toArray());
        } catch (Throwable $e) {
            return $this->serviceUnavailable();
        }

        return $this->successResponse(ProjectResource::make($project));
    }

    public function update(int $id, ProjectRequest $request): ApiResponse
    {
        try {
            $project = $this->repository->update($id, $request->safe());
        } catch (ModelNotFoundException $e) {
            return $this->failResponse(['project' => __('exceptions.entity_not_found', ['entity' => 'Project'])]);
        } catch (Throwable $e) {
            return $this->serviceUnavailable();
        }

        return $this->successResponse(ProjectResource::make($project));
    }

    public function delete(int $id): ApiResponse
    {
        try {
            $this->repository->delete($id);
        } catch (ModelNotFoundException $e) {
            return $this->failResponse(['project' => __('exceptions.entity_not_found', ['entity' => 'Project'])]);
        } catch (Throwable $e) {
            return $this->serviceUnavailable();
        }

        return $this->successResponse(ProjectResource::make());
    }
}
