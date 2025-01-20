<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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
        return $this->belongsTo(User::class, 'user_id');
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

    public function included() : MorphMany {
        return $this->morphMany(IncludedComputation::class, 'computable');
    }

    public static function compute_performance(int $user_id, int $posting_id, int $application_id){
        $user = User::find($user_id);
        $job_posting= JobPosting::find($posting_id);
        $job_application = JobApplication::find($application_id);
        
               

                if($user->hasRole('employee')){//employee
                    $computable = $job_application->included;
                    $posting_date = Carbon::parse($job_posting->posting_date);
                    $latestSpms = null;

                    $included_ipcr = $computable->filter(function ($value, int $key) {
                        return $value->computable_type == 'App\Models\SpmsForm';
                    });
            
                    $ipcrs = $included_ipcr->map(function ($value, int $key) {
                        return $value->computable->rating;
                    });

                    $ipcr_values = $ipcrs->values();
              
                    $applicant = [
                        'name' => $user->name,
                        'first' => count($ipcr_values) >= 1 ? round($ipcr_values[0], 2) : null,
                        'second' => count($ipcr_values) === 2 ? round($ipcr_values[1], 2) : null,
                        'equivalent' => count($ipcr_values) == 0 ? 50 : round($ipcrs->average() / 5 * 70, 2)
                    ];

                    // dd($applicant);
    
                    return $applicant;

                }//employee

                else{
                    if($job_application->pes_rating()->exists()){ // if outsider
                        $applicant = null;
                        $pesRatingOutsider = $job_application->pes_rating;
            
                        if(($pesRatingOutsider->first_rating && $pesRatingOutsider->second_rating)){
                            $performance_rating = ((($pesRatingOutsider->first_rating + $pesRatingOutsider->second_rating) / 2) / 5) * 70;
                            $applicant = [
                                'name' => $user->name,
                                'first' => $pesRatingOutsider->first_rating,
                                'second' =>  $pesRatingOutsider->second_rating,
                                'equivalent' => $performance_rating
                            ];
                        }else if($pesRatingOutsider->first_rating){
                            $performance_rating = ($pesRatingOutsider->first_rating / 5) * 70;
                            $applicant = [
                                'name' => $user->name,
                                'first' => $pesRatingOutsider->first_rating,
                                'second' => 0,
                                'equivalent' => $performance_rating
                            ];
                        }else if($pesRatingOutsider->second_rating){
                            $performance_rating = ($pesRatingOutsider->second_rating / 5) * 70;
                            $applicant = [
                                'name' => $user->name,
                                'second' =>  $pesRatingOutsider->second_rating,
                                'first' => 0,
                                'equivalent' => $performance_rating
                            ];
                        }
                        return $applicant;
                        
                    }else{
                        $performance_rating = 50;
                        $applicant = [
                            'name' => $user->name,
                            'second' =>  "NONE",
                            'first' => "NONE",
                            'equivalent' => $performance_rating
                        ];

                        return $applicant;
                    }//outsider
                }
    }
}
