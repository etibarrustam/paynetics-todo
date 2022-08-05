<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AuthResourceCollection extends ResourceCollection
{
    /**
     * @inheritdoc
     */
    public $resource = AuthResource::class;
}
