<?php

use App\Models\Enums\UserPermission;
use App\Models\Enums\UserRole;

return [
    UserRole::ADMIN->value => [UserPermission::ALL->value],
    UserRole::USER->value => [
        UserPermission::PROJECT_ALL->value,
        UserPermission::PROJECT_SHOW->value,
        UserPermission::PROJECT_CREATE->value,
        UserPermission::PROJECT_EDIT->value,
        UserPermission::PROJECT_DELETE->value,
        UserPermission::PROJECT_STATUSES->value,

        UserPermission::TASK_ALL->value,
        UserPermission::TASK_SHOW->value,
        UserPermission::TASK_CREATE->value,
        UserPermission::TASK_EDIT->value,
        UserPermission::TASK_DELETE->value,
        UserPermission::TASK_STATUSES->value,

        UserPermission::EMPLOYEE_ALL->value,
    ]
];
