<?php

namespace App\Models\Enums;

enum UserRole: string
{
    /**
     * Admin role.
     */
    case ADMIN = 'admin';

    /**
     * User role.
     */
    case USER = 'user';
}
