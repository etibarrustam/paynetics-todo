<?php

namespace App\Models\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasOwner
{
    /**
     * Boot HasOwner trait on model booting.
     * @return void
     */
    protected static function bootHasOwner(): void
    {
        static::saving(function ($model) {
            $model->projectable_id = auth()->id();
        });
    }

    /**
     * Foreign key column name for related owner.
     * Override this column to set proper foreign key.
     * @return string
     */
    protected static function getOwnerForeignKey(): string
    {
        return 'user_id';
    }

    /**
     * Get Owner.
     * @return BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
