<?php

namespace App\Http\Resources\Task;

use App\Models\Project\ProjectStatus;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'project_id' => $this->project_id,
            'name' => $this->name,
            'description' => $this->description,
            'start_at' => $this->duration,
            'end_at' => $this->duration,
            'created_at' => $this->created_at,
        ];
    }
}
