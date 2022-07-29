<?php

namespace App\Http\Responses;

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

    public static function all(): array
    {
        return [
            self::SUCCESS,
            self::ERROR
        ];
    }
}
