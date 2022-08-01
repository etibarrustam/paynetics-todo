<?php

namespace App\Http\Resources\Project;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectStatusResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'value' => $this->value
        ];
    }
}
