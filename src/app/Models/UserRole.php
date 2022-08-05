<?php

namespace App\Models;

enum UserRole: string
{
    /**
     * User role: Client.
     */
    case CLIENT = 'client';

    /**
     * User role: Project Manager.
     */
    case PROJECT_MANAGER = 'project_manager';

    /**
     * User role: Employee.
     */
    case EMPLOYEE = 'employee';
}
