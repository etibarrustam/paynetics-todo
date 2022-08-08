<?php

namespace App\Services;

use App\Models\Company\Company;
use App\Models\Project\Project;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProjectService
{
    public function create(array $data): Project
    {
        $data['user_id'] = auth()->id();

        $project = Project::create($data);

        if (isset($data['employees'])) {
            $project->employees()->sync(array_column($data['employees'], 'id'));
        }

        return $project;
    }

    public function update(int $id, array $data): Project
    {
        $project = Project::findOrFail($id);
        $project->fill($data)->save();

        if (isset($data['employees'])) {
            $project->employees()->sync(array_column($data['employees'], 'id'));
        }

        return $project;
    }

    public function getEmployeesByProjectId(int $projectId, array $params = []): LengthAwarePaginator|array
    {
        $users = User::where('id', '!=', auth()->id())->withoutGlobalScope('only_for_owners');

        if (isset($params['project_id'])){
            $users = $users->whereRelation('workProjects', 'projects.id', $projectId);
        }

        return $users->paginate($params['per_page']);
    }
}
