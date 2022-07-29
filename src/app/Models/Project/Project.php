<?php

namespace App\Models\Project;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'status',
        'duration'
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function getStatusLabel(): string
    {
        return ProjectStatus::getLabel($this->status);
    }
}
