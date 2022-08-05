<?php

namespace App\Services;

use App\Models\Company\Company;
use App\Models\Project\Project;

class ProjectService
{
    public function create(array $data): Project
    {
        return Project::create(array_merge($data, $this->getOwner($data['company_id'] ?? null)));
    }

    protected function getOwner(int $companyId = null): array
    {
        if ($companyId) {
            $company = Company::find($companyId);

            return [
                'projectable_id' => $company->id,
                'projectable_type' => Company::class,
            ];
        }

        return [
            'projectable_id' => auth()->id(),
            'projectable_type' => get_class(auth()->user()),
        ];
    }
}
