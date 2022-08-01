<?php

namespace App\Exceptions;

use Exception;
use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;

class UserRoleDoesntExistException extends Exception
{
    public function __construct()
    {
        parent::__construct(__('exceptions.user_role_doesnt_exist'));
    }
}
