<?php

namespace Tests\Feature;

use App\Http\Responses\ApiCode;
use Tests\TestCase;

class ApiTestCase extends TestCase
{
    /**
     */
    public function getSuccessResponse(array $data = []): array
    {
        return [
            'code' => ApiCode::SUCCESS,
            'data' => $data,
            'validation_errors' => []
        ];
    }

    public function getFailResponse(array $errors = []): array
    {
        return [
            'code' => ApiCode::SUCCESS,
            'data' => [],
            'validation_errors' => $errors
        ];
    }
}
