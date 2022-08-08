<?php

namespace App\Http\Resources\Task;

use App\Models\Enums\TaskStatus;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskStatusResource extends JsonResource
{
    /**
     * @inheritDoc
     */
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'value' => $this->value,
            'label' => TaskStatus::from($this->value)->getLabel()
        ];
    }
}
