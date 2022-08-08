<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectGetRequest;
use App\Http\Requests\Project\ProjectPostRequest;
use App\Http\Resources\Project\ProjectResource;
use App\Http\Resources\Project\ProjectStatusResource;
use App\Http\Responses\ApiResponse;
use App\Http\Responses\HasJsonResponse;
use App\Models\Enums\ProjectStatus;
use App\Models\Project\Project;
use App\Services\ProjectService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class ProjectController extends Controller
{
    use HasJsonResponse;

    /**
     * Get all data from Project.
     * @param ProjectGetRequest $request
     * @return ApiResponse
     */
    public function all(ProjectGetRequest $request): ApiResponse
    {
        $project = Project::with('employees')->paginate($request->get('per_page'));
        return $this->successResponse(ProjectResource::collection($project));
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
        return $this->successResponse(ProjectStatusResource::collection(ProjectStatus::cases()));
    }

    /**
     * Create new Project.
     * @param ProjectPostRequest $request
     * @param ProjectService $service
     * @return ApiResponse
     */
    public function store(ProjectPostRequest $request, ProjectService $service): ApiResponse
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
     * @param ProjectPostRequest $request
     * @param ProjectService $service
     * @return ApiResponse
     */
    public function update(int $id, ProjectPostRequest $request, ProjectService $service): ApiResponse
    {
        try {
            $project = $service->update($id, $request->safe()->toArray());
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
