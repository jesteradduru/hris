<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class NonAcademicDistinction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category',
        'classification',
        'points',
        'title',
        'office',
        'date_awarded'
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function files() : MorphMany {
        return $this->morphMany(Document::class, 'fileable');
    }
}
