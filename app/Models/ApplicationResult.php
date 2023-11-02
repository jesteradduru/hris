<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class ApplicationResult extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'result_id',
        'published',
        'application_id',
        'user_id',
        'result',
        'notes'
    ];

    public function application() : BelongsTo {
        return $this->belongsTo(JobApplication::class, 'application_id');
    }

    public function results() : BelongsTo {
        return $this->belongsTo(JobApplicationResults::class, 'result_id');
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopePublished(Builder $query) : Builder {
        return $query->where('published', 1);
    }
}
