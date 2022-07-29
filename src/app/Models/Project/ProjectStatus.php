<?php

namespace App\Models\Project;

enum ProjectStatus: int
{
    case NEW = 0;
    case PENDING = 1;
    case FAILED = 2;
    case DONE = 3;

    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::NEW => 'New',
            self::PENDING => 'Pending',
            self::FAILED => 'Failed',
            self::DONE => 'Done',
        };
    }

    public static function all(): array
    {
        return [
            self::NEW,
            self::PENDING,
            self::FAILED,
            self::DONE,
        ];
    }
}
