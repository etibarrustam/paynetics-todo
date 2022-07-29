<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;

class TestController extends Controller
{
    public function basicResponse()
    {
        return new ApiResponse(['test']);
    }
}
