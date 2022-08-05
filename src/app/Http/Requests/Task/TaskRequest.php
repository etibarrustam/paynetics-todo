<?php

namespace App\Http\Requests\Task;

use App\Models\Task\TaskStatus;
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
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            "status" => "required|in:" . implode(',', TaskStatus::toArray()),
            "name" => "required|string|max:255",
            "description" => "required|string",
            "start_at" => "nullable|date",
            "end_at" => "nullable|date"
        ];
    }
}
