<?php

namespace App\Models;

trait HasOwner
{
    /**
     * Boot HasOwner trait on model booting.
     * @return void
     */
    public static function bootHasOwner(): void
    {
        static::saving(function ($model) {
            $model->{$this->getOwnerForeignKey()} = auth()->id();
        });
    }

    /**
     * Foreign key column name for related owner.
     * Override this column to set proper foreign key.
     * @return string
     */
    public function getOwnerForeignKey(): string
    {
        return 'user_id';
    }
}
