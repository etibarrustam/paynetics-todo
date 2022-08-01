<?php

namespace App\Http\Resources\Task;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskStatusResourceCollection extends ResourceCollection
{
    public $resource = TaskResource::class;
}
