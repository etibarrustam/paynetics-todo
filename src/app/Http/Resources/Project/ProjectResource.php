<?php

namespace App\Http\Resources\Project;

use App\Models\Enums\ProjectStatus;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * @inheritDoc
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'company_name' => $this->company_name,
            'company_address' => $this->company_address,
            'status' => ProjectStatus::from($this->status),
            'created_at' => Carbon::make($this->created_at)->toDateString(),
            'employees' => $this->employees,
        ];
    }
}
