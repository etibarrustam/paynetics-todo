<?php

namespace App\Http\Resources\User;

use App\Models\Enums\UserRole;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserResource extends JsonResource
{
    /**
     * @inheritdoc
     */
    public function toArray($request): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email
        ];

        if (isAdmin()) {
            $data['is_admin'] = true;
        }

        return $data;
    }
}
