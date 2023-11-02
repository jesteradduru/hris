<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = ['job_application_id', 'job_posting_id'];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function document() : HasMany
    {
        return $this->hasMany(JobApplicationAttachment::class);
    }
    
    public function job_posting() : BelongsTo
    {
        return $this->belongsTo(JobPosting::class, 'job_posting_id');
    }

    public function result() : HasMany
    {
        return $this->hasMany(ApplicationResult::class, 'application_id');
    }
}
