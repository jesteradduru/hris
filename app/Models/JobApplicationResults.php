<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobApplicationResults extends Model
{
    use HasFactory;

    protected $fillable = [
        'phase',
        'schedule',
        'job_posting_id',
        'start_time',
        'end_time',
    ];

    public function job_posting() : BelongsTo {
        return $this->belongsTo(JobPosting::class, 'job_posting_id');
    }

    public function result() : HasMany {
        return $this->hasMany(ApplicationResult::class, 'result_id');
    }

}
