<?php

namespace Tests\Feature;

use App\Http\Responses\ApiResponse;
use Tests\TestCase;

class ApiTestCase extends TestCase
{
    public function successResponse(array $data = []): ApiResponse
    {
        return (new ApiResponse($data))->toArray();
    }

    public function failResponse(array $errors = []): ApiResponse
    {
        return (new ApiResponse())->fail($errors)->toArray();
    }
}
