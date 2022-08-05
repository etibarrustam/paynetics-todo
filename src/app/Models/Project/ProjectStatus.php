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

    /**
     * Get cases as array.
     * @return ProjectStatus[]
     */
    public static function toArray(): array
    {
        return [
            self::NEW->value,
            self::PENDING->value,
            self::FAILED->value,
            self::DONE->value,
        ];
    }
}
