<?php

namespace App\Models\Project;

use App\Models\Company\Company;
use App\Models\HasOwner;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasOwner;

    protected $fillable = [
        'name',
        'description',
        'status',
        'duration'
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return ProjectStatus::getLabel($this->status);
    }

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_employees');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
