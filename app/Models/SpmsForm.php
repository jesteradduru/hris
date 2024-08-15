<?php

namespace App\Models;

use Carbon\Carbon;
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

    public static function compute_performance(int $user_id, int $posting_id, int $application_id){
        $user = User::find($user_id);
        $job_posting= JobPosting::find($posting_id);
        $job_application = JobApplication::find($application_id);
               

                if($user->hasRole('employee')){//employee
                    $posting_date = Carbon::parse($job_posting->posting_date);
                    $latestSpms = null;

                    if($posting_date->month <= 6){
                        $previousYear = $posting_date->year - 1;
                        $latestSpms = $user->spms()
                                         ->where('user_id', $user->id)
                                        ->where('year', $previousYear)
                                        ->where(function (Builder $query) {
                                            $query->where('semester', 'FIRST')
                                                ->orWhere('semester', 'SECOND');
                                        })->get();
                    }else if($posting_date->month > 6 && $posting_date->month <= 12){
                        $currentYear = $posting_date->year;
                        $latestSpms = $user->spms()
                                        ->where(function (Builder $query) use($currentYear, $user) {
                                            $query->where('semester', 'FIRST')
                                                    ->where('user_id', $user->id)
                                                    ->where('year', $currentYear);
                                        })
                                        ->orWhere(function (Builder $query) use($currentYear, $user)  {
                                            $query->where('year', $currentYear - 1)
                                                 ->where('user_id', $user->id)
                                                ->where('semester', 'SECOND');
                                        })->get();
                    }

                    // dd($latestSpms->toArray());
                    if($latestSpms){
                        $performance_rating = $latestSpms->avg('rating') / 5 * 70;
                    }

                    $applicant = [
                        'name' => $user->name,
                        'first' => count($latestSpms) >= 1 ? $latestSpms[0]->rating : null,
                        'second' => count($latestSpms) === 2 ? $latestSpms[1]->rating : null,
                        'equivalent' => $performance_rating
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
