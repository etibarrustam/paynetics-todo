<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AuthResourceCollection extends ResourceCollection
{
    public $resource = AuthResource::class;
}
