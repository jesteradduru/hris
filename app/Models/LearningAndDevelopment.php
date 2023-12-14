<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class LearningAndDevelopment extends Model
{
    use HasFactory;

    protected $table = 'learning_and_development';

    protected $fillable = [
        "title_of_learning",
        "inclusive_date_from",
        "inclusive_date_to",
        "number_of_hours",
        "type_of_ld",
        "conducted_sponsored_by",
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function lnd_training() : HasMany {
        return $this->hasMany(LndTrainingsAttended::class, 'training_id');
    }

    public function scopeFilter(Builder $query, array $filters) : Builder {
        return $query
            ->when(
                $filters['from'] ?? false,
                fn ($query, $value) => $query->where('inclusive_date_from', '>=', $filters['from'])
            )
            ->when(
                $filters['to'] ?? false,
                fn ($query, $value) => $query->where('inclusive_date_to', '<=', $filters['to'])
            )
            ;
    }

    public function files() : MorphMany {
        return $this->morphMany(Document::class, 'fileable');
    }

    public function included() : MorphMany {
        return $this->morphMany(IncludedComputation::class, 'computable');
    }


}
