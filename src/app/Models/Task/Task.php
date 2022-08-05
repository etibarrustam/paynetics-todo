<?php

namespace App\Models\Task;

use App\Models\Traits\DefaultDateTimeFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 */
class Task extends Model
{
    use HasFactory;
    use DefaultDateTimeFormat;

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'name',
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
}
