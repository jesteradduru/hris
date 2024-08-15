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
    
    public function scopeMostRecent(Builder $query) {
        return $query->orderBy('inclusive_date_from', 'desc');
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


    public static function compute_training(int $application_id){
        $application = JobApplication::find($application_id);
        $computable = $application->included;
        $plantilla = $application->job_posting->plantilla;
        $training = 0;

        $included_trainings = $computable->filter(function ($value, int $key) {
            return $value->computable_type == 'App\Models\LearningAndDevelopment';
        });

        $trainings = $included_trainings->map(function ($value, int $key) {
            return $value->computable;
        });
        
        $no_of_hours1 = $trainings->sum('number_of_hours');
        $no_of_hours = $trainings->sum('number_of_hours');
        
        if($plantilla->training){ // if training is required
            if($plantilla->training <= $no_of_hours){
                $training = 50;
                $no_of_hours = $no_of_hours - $plantilla->training;
            }
        }
        

        while($no_of_hours >= 12 && $training < 100) {
            if($no_of_hours >= 12){
                $training += 1;
            }
            $no_of_hours -= 12;
        }
    

        return [
            'user' => $application->user->name,
            'hours' => $no_of_hours1,
            'equivalent' => $training,
            'score' => round($training * .1, 2)
        ];
    }


}
