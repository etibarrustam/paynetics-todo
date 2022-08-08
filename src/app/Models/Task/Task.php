<?php

namespace App\Models\Task;

use App\Models\Project\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Task\Task
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $title
 * @property string|null $description
 * @property string|null $start_at
 * @property string|null $end_at
 * @property int $project_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task query()
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\User|null $owner
 * @property int $status_id
 * @property string $name
 * @method static \Database\Factories\Task\TaskFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereStatusId($value)
 * @property int $project_status_id
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereProjectStatusId($value)
 * @property int $status
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $employees
 * @property-read int|null $employees_count
 * @property-read Project $project
 * @method static Builder|Task forWorkers()
 * @method static Builder|Task whereStatus($value)
 */
class Task extends Model
{
    use HasFactory;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'name',
        'project_id',
        'description',
        'status',
        'start_at',
        'end_at'
    ];

    /**
     * @inheritdoc
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'start_at',
        'end_at',
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

            return $query->select('tasks.*')->rightJoin('projects', fn($query) => (
                $query->on('projects.id', '=', 'tasks.project_id')
                    ->where('projects.user_id', auth()->id())
            ));
        });
    }

    /**
     * Get related Project.
     * @return BelongsTo
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Return Tasks which assigned to current Auth.
     * @param Builder $query
     * @return Builder
     */
    public function scopeForWorkers(Builder $query): Builder
    {
        return $query->rightJoin('task_employees', fn($query) => (
            $query->on('task_employees.task_id', '=', $this->getTable() . '.id')
                ->where('task_employees.user_id', auth()->id())
        ));
    }

    /**
     * Get employees of Task.
     * @return BelongsToMany
     */
    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'task_employees');
    }
}
