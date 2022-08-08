<?php

namespace App\Http\Responses;

use Illuminate\Http\Resources\Json\JsonResource;

trait HasJsonResponse
{
    /**
     * Success response method.
     * @param JsonResource|null $resource
     * @param array $headers
     * @param int $options
     * @return ApiResponse
     */
    public function successResponse(JsonResource $resource = null, array $headers = [], int $options = 0): ApiResponse
    {
        return new ApiResponse($resource, $headers, $options);
    }

    /**
     * Fail response method.
     * @param array $errors
     * @param array $headers
     * @param int $options
     * @return ApiResponse
     */
    public function failResponse(array $errors, array $headers = [], int $options = 0): ApiResponse
    {
        return (new ApiResponse(null, $headers, $options))->fail($errors);
    }

    /**
     * Error response method for unhandled exceptions.
     * @return ApiResponse
     */
    public function serviceUnavailable(): ApiResponse
    {
        return $this->failResponse([
            'server' => [__('exceptions.service_unavailable')]
        ]);
    }
}
