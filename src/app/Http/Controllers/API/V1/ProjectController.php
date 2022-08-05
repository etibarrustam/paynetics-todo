<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectRequest;
use App\Http\Resources\Project\ProjectResource;
use App\Http\Resources\Project\ProjectResourceCollection;
use App\Http\Resources\Project\ProjectStatusResourceCollection;
use App\Http\Responses\ApiResponse;
use App\Http\Responses\HasJsonResponse;
use App\Models\Project\Project;
use App\Models\Project\ProjectStatus;
use App\Services\ProjectService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class ProjectController extends Controller
{
    use HasJsonResponse;

    /**
     * Get all data from Project.
     * @return ApiResponse
     */
    public function all(): ApiResponse
    {
        return $this->successResponse(ProjectResourceCollection::make(Project::all()));
    }

    /**
     * Find the Project by id.
     * @param int $id
     * @return ApiResponse
     */
    public function getById(int $id): ApiResponse
    {
        try {
            $project = Project::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->failResponse(['project' => __('exceptions.entity_not_found', ['entity' => 'Project'])]);
        } catch (Throwable $e) {
            return $this->serviceUnavailable();
        }

        return $this->successResponse(ProjectResource::make($project));
    }

    /**
     * Get all Project statuses.
     * @return ApiResponse
     */
    public function getStatuses(): ApiResponse
    {
        return $this->successResponse(ProjectStatusResourceCollection::make(ProjectStatus::cases()));
    }

    /**
     * Create new Project.
     * @param ProjectRequest $request
     * @param ProjectService $service
     * @return ApiResponse
     */
    public function store(ProjectRequest $request, ProjectService $service): ApiResponse
    {
        try {
            $project = $service->create($request->safe()->toArray());
        } catch (Throwable $e) {
            return $this->serviceUnavailable();
        }

        return $this->successResponse(ProjectResource::make($project));
    }

    /**
     * Update Project via given ID.
     * @param int $id
     * @param ProjectRequest $request
     * @return ApiResponse
     */
    public function update(int $id, ProjectRequest $request): ApiResponse
    {
        try {
            $project = Project::findOrFail($id);
            $project->fill($request->safe()->toArray())->save();
        } catch (ModelNotFoundException $e) {
            return $this->failResponse(['project' => __('exceptions.entity_not_found', ['entity' => 'Project'])]);
        } catch (Throwable $e) {
            return $this->serviceUnavailable();
        }

        return $this->successResponse(ProjectResource::make($project));
    }

    /**
     * Delete Project via given ID.
     * @param int $id
     * @return ApiResponse
     */
    public function delete(int $id): ApiResponse
    {
        try {
            Project::findOrFail($id)->delete();
        } catch (ModelNotFoundException $e) {
            return $this->failResponse(['project' => __('exceptions.entity_not_found', ['entity' => 'Project'])]);
        } catch (Throwable $e) {
            return $this->serviceUnavailable();
        }

        return $this->successResponse();
    }
}
