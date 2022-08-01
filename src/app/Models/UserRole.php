<?php

namespace App\Models;

enum UserRole: string
{
    case CLIENT = 'client';
    case PROJECT_MANAGER = 'project_manager';
    case EMPLOYEE = 'employee';
}
