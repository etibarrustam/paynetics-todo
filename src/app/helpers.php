<?php

use App\Http\Responses\ApiResponse;
use Illuminate\Http\Resources\Json\JsonResource;

if (!function_exists('apiResponse')) {

    /**
     * @param JsonResource|null $resource
     * @param array $headers
     * @param int $options
     * @return \App\Http\Responses\ApiResponse
     */
    function apiResponse(JsonResource $resource = null, array $headers = [], int $options = 0): ApiResponse
    {
        return new ApiResponse($resource, $headers, $options);
    }
}
