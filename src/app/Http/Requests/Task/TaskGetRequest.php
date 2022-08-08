<?php

namespace App\Http\Requests\Task;

use App\Http\Requests\PaginateRequest;

class TaskGetRequest extends PaginateRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return array_merge(
            parent::rules(),
            [
                'project_id' => 'required|int|exists:projects,id'
            ]
        );
    }
}
