<?php

namespace App\Http\Resources\Project;

use App\Models\Project\ProjectStatus;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectStatusResource extends JsonResource
{
    /**
     * @inheritDoc
     */
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'value' => $this->value,
            'label' => ProjectStatus::from($this->value)->getLabel(),
        ];
    }
}
