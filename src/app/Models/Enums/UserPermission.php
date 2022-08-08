<?php

namespace App\Models\Enums;

use App\Models\Traits\ArrayableEnum;

enum UserPermission: string
{
    use ArrayableEnum;

    /**
     * Admin permission.
     */
    case ALL = '*';

    /**
     * Project permissions
     */
    case PROJECT_ALL = 'project_all';
    case PROJECT_SHOW = 'projects_show';
    case PROJECT_CREATE = 'project_create';
    case PROJECT_EDIT = 'project_edit';
    case PROJECT_DELETE = 'project_delete';
    case PROJECT_STATUSES = 'project_statuses';

    /**
     * Task permissions
     */
    case TASK_ALL = 'task_all';
    case TASK_SHOW = 'task_show';
    case TASK_CREATE = 'task_create';
    case TASK_EDIT = 'task_edit';
    case TASK_DELETE = 'task_delete';
    case TASK_STATUSES = 'task_statuses';

    /**
     * Employee permissions
     */
    case EMPLOYEE_ALL = 'employee_all';
    case EMPLOYEE_SHOW = 'employee_show';
    case EMPLOYEE_CREATE = 'employee_create';
    case EMPLOYEE_EDIT_ = 'employee_edit';
    case EMPLOYEE_DELETE = 'employee_delete';

    /**
     * User permissions
     */
    case USER_ALL = 'user_all';
    case USER_SHOW = 'user_show';
    case USER_CREATE = 'user_create';
    case USER_EDIT_ = 'user_edit';
    case USER_DELETE = 'user_delete';
}
