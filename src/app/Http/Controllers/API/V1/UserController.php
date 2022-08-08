<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaginateRequest;
use App\Http\Requests\User\EmployeeGetRequest;
use App\Http\Resources\User\UserResource;
use App\Http\Responses\ApiResponse;
use App\Http\Responses\HasJsonResponse;
use App\Models\User;
use App\Services\ProjectService;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use HasJsonResponse;

    public function all(PaginateRequest $request): ApiResponse
    {
        return $this->successResponse(
            UserResource::collection(User::select(['id', 'name', 'email'])
                ->paginate($request->get('per_page')))
        );
    }

    public function employees(EmployeeGetRequest $request, ProjectService $projectService): ApiResponse
    {
        $users = $projectService->getEmployeesByProjectId(
            $request->get('project_id'),
            $request->safe()->toArray()
        );

        return $this->successResponse(UserResource::collection($users));
    }

    public function getUserData(): ApiResponse
    {
        dd(1);
        return $this->successResponse(UserResource::make(Auth::user()));
    }
}
