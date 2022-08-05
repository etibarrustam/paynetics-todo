<?php

namespace App\Http\Resources\Project;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProjectResourceCollection extends ResourceCollection
{
    /**
     * @inheritdoc
     */
    public $resource = ProjectResource::class;
}
