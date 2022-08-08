<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskGetRequest;
use App\Http\Requests\Task\TaskPostRequest;
use App\Http\Resources\Task\TaskStatusResource;
use App\Http\Resources\Task\TaskResource;
use App\Http\Responses\ApiResponse;
use App\Http\Responses\HasJsonResponse;
use App\Models\Enums\TaskStatus;
use App\Models\Task\Task;
use App\Services\TaskService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class TaskController extends Controller
{
    use HasJsonResponse;

    /**
     * Get all data from Task.
     * @param TaskGetRequest $request
     * @return ApiResponse
     */
    public function all(TaskGetRequest $request): ApiResponse
    {
        $tasks = Task::whereProjectId($request->get('project_id'))
            ->with('employees')
            ->paginate($request->get('per_page'));

        return $this->successResponse(TaskResource::collection($tasks));
    }

    /**
     * Find the Task by id.
     * @param int $id
     * @return ApiResponse
     */
    public function getById(int $id): ApiResponse
    {
        try {
            $task = Task::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return $this->failResponse(['task' => __('exceptions.entity_not_found', ['entity' => 'Task'])]);
        } catch (Throwable $e) {
            return $this->serviceUnavailable();
        }

        return $this->successResponse(TaskResource::make($task));
    }

    /**
     * Get all Task statuses.
     * @return ApiResponse
     */
    public function getStatuses(): ApiResponse
    {
        return $this->successResponse(TaskStatusResource::collection(TaskStatus::cases()));
    }

    /**
     * Create new Task.
     * @param TaskPostRequest $request
     * @param TaskService $service
     * @return ApiResponse
     */
    public function store(TaskPostRequest $request, TaskService $service): ApiResponse
    {
        try {
            $task = $service->create($request->safe()->toArray());
        } catch (Throwable $e) {
            return $this->serviceUnavailable();
        }

        return $this->successResponse(TaskResource::make($task));
    }

    /**
     * Update Task via given ID.
     * @param int $id
     * @param TaskPostRequest $request
     * @param TaskService $service
     * @return ApiResponse
     */
    public function update(int $id, TaskPostRequest $request, TaskService $service): ApiResponse
    {
        try {
            $task = $service->update($id, $request->safe()->toArray());
        } catch (ModelNotFoundException $e) {
            return $this->failResponse(['task' => __('exceptions.entity_not_found', ['entity' => 'Task'])]);
        } catch (Throwable $e) {
            return $this->serviceUnavailable();
        }

        return $this->successResponse(TaskResource::make($task));
    }

    /**
     * Delete Task via given ID.
     * @param int $id
     * @return ApiResponse
     */
    public function delete(int $id): ApiResponse
    {
        try {
            Task::findOrFail($id)->delete();
        } catch (ModelNotFoundException $e) {
            return $this->failResponse(['task' => __('exceptions.entity_not_found', ['entity' => 'Task'])]);
        } catch (Throwable $e) {
            return $this->serviceUnavailable();
        }

        return $this->successResponse();
    }

    public function assignToEmployees()
    {

    }
}
