<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class ApplicationScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'performance',
        'performance_rank',
        'education',
        'education_rank',
        'experience',
        'experience_rank',
        'personality',
        'personality_rank',
        'potential',
        'potential_rank',
        'total',
        'total_rank',
        'job_application_id',
    ];

    public function job_application() : BelongsTo {
        return $this->belongsTo(JobApplication::class, 'job_application_id');
    }

    public function user() : HasOneThrough {
        return $this->hasOneThrough(User::class, JobApplication::class, 'job_application_id', 'user_id');
    }

    public function scopeFilter(Builder $query, array $filters) : Builder {
        return $query
            ->when(
                $filters['rank_by'] ?? false,
                fn ($query, $value) => $query->orderBy($value, 'desc')
            );
    }
}
