<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NonAcademicDistinction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category',
        'category_type',
        'points',
        'others'
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
}
