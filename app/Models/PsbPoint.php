<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class PsbPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_application_id',
        'performance',
        'experience',
        'personality_hrmpsb',
        'personality_peer',
        'potential',
    ];

    public function user() : HasOneThrough {
        return $this->hasOneThrough(User::class, JobApplication::class, 'job_application', 'user_id');
    }

    public function job_application() : BelongsTo {
        return $this->belongsTo(JobApplication::class, 'job_application_id');
    }
}
