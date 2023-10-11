<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpmsForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'filepath',
        'type',
        'semester',
        'rating',
        'year'
    ];
    protected $appends = ['src'];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    } 

    public function scopeFilter(Builder $query, array $filters) : Builder {
        return $query->when(
                    $filters['year'] ?? false,
                    fn($query, $value) => $query->where('year', $value)
                )->when(
                    $filters['type'] ?? false,
                    fn($query, $value) => $query->where('type', $value)
                )->when(
                    $filters['semester'] ?? false,
                    fn($query, $value) => $query->where('semester', $value)
                );
    }


    public function getSrcAttribute()
    {
        return asset("storage/{$this->filepath}");
    }
}
