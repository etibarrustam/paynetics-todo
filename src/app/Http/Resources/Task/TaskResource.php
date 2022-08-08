<?php

namespace App\Http\Resources\Task;

use App\Models\Enums\TaskStatus;
use Carbon\Carbon;
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
            'project_id' => $this->project_id,
            'status' => TaskStatus::from($this->status),
            'name' => $this->name,
            'description' => $this->description,
            'start_at' => Carbon::make($this->start_at)->toDateString(),
            'end_at' => Carbon::make($this->end_at)->toDateString(),
            'created_at' => Carbon::make($this->created_at)->toDateString(),
            'employees' => $this->employees->toArray()
        ];
    }
}
