<?php

namespace App\Models\Project;

/**
 * Project statuses.
 */
enum ProjectStatus: int
{
    case NEW = 0;
    case PENDING = 1;
    case FAILED = 2;
    case DONE = 3;

    /**
     * Get status label by id.
     * @param ProjectStatus $value
     * @return string
     */
    public static function getLabel(self $value): string
    {
        return match ($value) {
            self::NEW => 'New',
            self::PENDING => 'Pending',
            self::FAILED => 'Failed',
            self::DONE => 'Done',
        };
    }
}
