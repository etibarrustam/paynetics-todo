<?php

namespace App\Http\Resources\Project;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Spatie\FlareClient\Api;

class ProjectStatusResourceCollection extends ResourceCollection
{
    /**
     * @inheritdoc
     */
    public $resource = ProjectStatusResource::class;
}
