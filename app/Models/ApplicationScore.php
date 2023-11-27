<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApplicationScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'performance',
        'education',
        'experience',
        'personality',
        'potential',
        'total',
        'job_application_id',
    ];

    public function job_application() : BelongsTo {
        return $this->belongsTo(JobApplication::class, 'job_application_id');
    }
}
