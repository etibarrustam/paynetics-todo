<?php

namespace App\Http\Resources\Task;

use App\Models\Project\ProjectStatus;
use App\Models\Task\TaskStatus;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * @inheritDoc
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'status' => TaskStatus::from($this->status),
            'name' => $this->name,
            'description' => $this->description,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'created_at' => $this->created_at,
        ];
    }
}
