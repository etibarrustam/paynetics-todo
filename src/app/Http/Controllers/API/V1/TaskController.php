<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Repository;
use App\Http\Requests\Task\TaskRequest;
use App\Http\Resources\Task\TaskResource;
use App\Http\Resources\Task\TaskResourceCollection;
use App\Http\Responses\ApiResponse;
use App\Http\Responses\HasJsonResponse;
use App\Models\Task\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

class TaskController extends Controller
{
    use HasJsonResponse;

    /**
     * @var Repository
     */
    private Repository $repository;

    public function __construct()
    {
        $this->repository = Repository::make(Task::class);
    }

    public function all(): ApiResponse
    {
        return $this->successResponse(TaskResourceCollection::make($this->repository->all()));
    }

    public function getById(int $id): ApiResponse
    {
        try {
            $task = $this->repository->getById($id);
        } catch (ModelNotFoundException $e) {
            return $this->failResponse(['task' => __('exceptions.entity_not_found', ['entity' => 'Task'])]);
        } catch (Throwable $e) {
            return $this->serviceUnavailable();
        }

        return $this->successResponse(TaskResource::make($task));
    }

    public function store(TaskRequest $request): ApiResponse
    {
        try {
            $task = $this->repository->create($request->safe()->toArray());
        } catch (Throwable $e) {
            return $this->serviceUnavailable();
        }

        return $this->successResponse(TaskResource::make($task));
    }

    public function update(int $id, TaskRequest $request): ApiResponse
    {
        try {
            $task = $this->repository->update($id, $request->safe());
        } catch (ModelNotFoundException $e) {
            return $this->failResponse(['task' => __('exceptions.entity_not_found', ['entity' => 'Task'])]);
        } catch (Throwable $e) {
            return $this->serviceUnavailable();
        }

        return $this->successResponse(TaskResource::make($task));
    }

    public function delete(int $id): ApiResponse
    {
        try {
            $this->repository->delete($id);
        } catch (ModelNotFoundException $e) {
            return $this->failResponse(['task' => __('exceptions.entity_not_found', ['entity' => 'Task'])]);
        } catch (Throwable $e) {
            return $this->serviceUnavailable();
        }

        return $this->successResponse(TaskResource::make());
    }
}
