<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;

class TestController extends Controller
{
    public function basicResponse()
    {
        dd(route('api.v1.auth.register'));
        return new ApiResponse(['test']);
    }
}
