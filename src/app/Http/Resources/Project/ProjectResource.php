<?php

namespace App\Http\Resources\Project;

use App\Models\Project\ProjectStatus;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => ProjectStatus::getLabel(ProjectStatus::from($this->status)),
            'duration' => $this->duration,
            'created_at' => $this->created_at,
        ];
    }
}
