<?php

namespace App\Http\Requests\Task;

use App\Models\Project\ProjectStatus;
use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'project_id' => 'required|integer|exists:projects,id',
            'name' => 'required|string',
            'description' => 'required|string',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date'
        ];
    }
}
