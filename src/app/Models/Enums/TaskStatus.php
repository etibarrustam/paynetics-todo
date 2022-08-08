<?php

namespace App\Models\Enums;

use App\Models\Traits\ArrayableEnum;

/**
 * Task statuses.
 */
enum TaskStatus: int
{
    use ArrayableEnum;

    case TODO = 0;
    case IN_PROGRESS = 1;
    case REVIEW = 2;
    case DONE = 3;

    /**
     * Get status label.
     * @return string
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::TODO => __("statuses.task.todo"),
            self::IN_PROGRESS => __("statuses.task.in_progress"),
            self::REVIEW => __("statuses.task.review"),
            self::DONE => __("statuses.task.done"),
        };
    }
}
