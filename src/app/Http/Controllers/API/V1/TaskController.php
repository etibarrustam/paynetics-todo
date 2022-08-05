<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskRequest;
use App\Http\Resources\Task\TaskStatusResourceCollection;
use App\Http\Resources\Task\TaskResource;
use App\Http\Resources\Task\TaskResourceCollection;
use App\Http\Responses\ApiResponse;
use App\Http\Responses\HasJsonResponse;
use App\Models\Task\Task;
use App\Models\Task\TaskStatus;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class TaskController extends Controller
{
    use HasJsonResponse;

    /**
     * Get all data from Task.
     * @return ApiResponse
     */
    public function all(): ApiResponse
    {
        return $this->successResponse(TaskResourceCollection::make(Task::all()));
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
        return $this->successResponse(TaskStatusResourceCollection::make(TaskStatus::cases()));
    }

    /**
     * Create new Task.
     * @param TaskRequest $request
     * @return ApiResponse
     */
    public function store(TaskRequest $request): ApiResponse
    {
        try {
            $task = Task::create($request->safe()->toArray());
        } catch (Throwable $e) {
            return $this->serviceUnavailable();
        }

        return $this->successResponse(TaskResource::make($task));
    }

    /**
     * Update Task via given ID.
     * @param int $id
     * @param TaskRequest $request
     * @return ApiResponse
     */
    public function update(int $id, TaskRequest $request): ApiResponse
    {
        try {
            $task = Task::findOrFail($id);
            $task->fill($request->safe()->toArray())->save();
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
}
