<?php

namespace App\Exceptions;

use Exception;
use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;

class ApiCodeIsNotValid extends Exception
{
    public function __construct()
    {
        parent::__construct(__('exceptions.api_code_is_not_valid'));
    }
}
