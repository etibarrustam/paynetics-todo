<?php

namespace App\Models\Traits;

/**
 * @method static cases()
 */
trait ArrayableEnum
{
    /**
     * Get cases as array.
     * @return array
     */
    public static function toArray(): array
    {
        return array_map(static fn ($case) => $case->value, self::cases());
    }
}
