<?php

namespace App\Models\Project;

use App\Models\Company\Company;
use App\Models\Task\Task;
use App\Models\Traits\Searchable;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Project\Project
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $company_id
 * @property string $name
 * @property string|null $description
 * @property int $status
 * @property string|null $duration
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read Company $company
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $employees
 * @property-read int|null $employees_count
 * @property-read string $status_label
 * @property-read User|null $owner
 * @method static \Database\Factories\Project\ProjectFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Project newQuery()
 * @method static \Illuminate\Database\Query\Builder|Project onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Project query()
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|Project withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Project withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|Task[] $tasks
 * @property-read int|null $tasks_count
 * @property-read Model|\Eloquent $projectable
 * @property int $projectable_id
 * @property string $projectable_type
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereProjectableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereProjectableType($value)
 * @property string $company_name
 * @property string|null $company_address
 * @method static Builder|Project search(?string $search = null)
 * @method static Builder|Project whereCompanyAddress($value)
 * @method static Builder|Project whereCompanyName($value)
 */
class Project extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Searchable;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'name',
        'user_id',
        'description',
        'status',
        'company_name',
        'company_address',
    ];

    /**
     * @inheritdoc
     */
    protected static function boot(): void
    {
        parent::boot();

        static::addGlobalScope('only_for_owners', function ($query) {
            if (isAdmin()) {
                return $query;
            }

            return $query->where('projects.user_id', auth()->id());
        });
    }

    /**
     * Get related tasks.
     * @return HasMany
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get related employees.
     * @return BelongsToMany
     */
    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_employees');
    }
}
