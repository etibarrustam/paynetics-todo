<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AuthRegisterRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed'
        ];
    }
}
