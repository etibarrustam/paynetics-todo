<?php

namespace App\Http\Responses;

/**
 * Api custom codes.
 */
enum ApiCode: int
{
    /**
     * Api success code.
     * @var int
     */
    case SUCCESS = 1;

    /**
     * Api error code.
     * @var int
     */
    case ERROR = 0;
}
