<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Enums\UserPermission;

class TestController extends Controller
{
    public function basicResponse()
    {
        dd(UserPermission::toArray());
        return new ApiResponse(['test']);
    }
}
