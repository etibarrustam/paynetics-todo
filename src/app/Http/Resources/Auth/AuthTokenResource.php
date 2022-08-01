<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthTokenResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'token' => $this->access_token,
            'token_type' => 'bearer'
        ];
    }
}
