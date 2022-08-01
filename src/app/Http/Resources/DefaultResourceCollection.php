<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DefaultResourceCollection extends JsonResource
{
    public $resource = DefaultResource::class;
}
