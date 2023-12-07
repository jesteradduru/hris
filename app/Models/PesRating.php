<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PesRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'first_rating',
        'second_rating',
    ];

    public function job_application() : BelongsTo {
        return $this->belongsTo(JobApplication::class, 'application_id');
    }
}
