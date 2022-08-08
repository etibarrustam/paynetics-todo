<?php

namespace App\Models\Enums;

use App\Models\Traits\ArrayableEnum;

/**
 * Project statuses.
 */
enum ProjectStatus: int
{
    use ArrayableEnum;

    case NEW = 0;
    case PENDING = 1;
    case FAILED = 2;
    case DONE = 3;

    /**
     * Get status label.
     * @return string
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::NEW => __("statuses.project.new"),
            self::PENDING => __("statuses.project.pending"),
            self::FAILED => __("statuses.project.failed"),
            self::DONE => __("statuses.project.done"),
        };
    }
}
