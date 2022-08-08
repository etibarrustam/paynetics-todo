<?php

namespace App\Http\Requests\Task;

use App\Models\Enums\TaskStatus;
use App\Models\Project\Project;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskPostRequest extends FormRequest
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
        $employeeIds = [];
        $project = Project::withoutGlobalScope('only_for_owners')
            ->find($this->get('project_id'));

        if ($project) {
            $employeeIds = $project->employees->pluck('id')->toArray();
        }

        return [
            "status" => "required|in:" . implode(',', TaskStatus::toArray()),
            "name" => "required|string|max:255",
            "project_id" => "required|int|exists:projects,id",
            "description" => "required|string",
            "start_at" => "nullable|date|date_format:Y-m-d|after:" . date('Y-m-d'),
            "end_at" => "nullable|date|after:start_at|date_format:Y-m-d",
            "employees" => "sometimes|array",
            "employees.*.id" => [
                "int",
                Rule::exists('users', 'id')
                ->whereIn('id', $employeeIds)
            ],
        ];
    }
}
