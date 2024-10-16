<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class WorkExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        "inclusive_date_from",
        "inclusive_date_to",
        "position_title",
        "dept_agency_office_company",
        "name_of_office_unit",
        "office_address",
        "immediate_supervisor",
        "monthly_salary",
        "paygrade",
        "status_of_appointment",
        "govt_service",
        "list_of_accomplishments",
        "summary_of_duties",
        'to_present',
        'user_id'
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function included() : MorphMany {
        return $this->morphMany(IncludedComputation::class, 'computable');
    }

    public static function compute_experience($application_id){
        $application = JobApplication::find($application_id);
        $computable = $application->included;
        $posting = $application->job_posting;
        $plantilla = $posting->plantilla;
        $work_points = 0;
        $total_year_excess_count = 0;
        $psb_point_experience = $application->psb_points()->exists() ? $application->psb_points->experience : 0;

        $included_work = $computable->filter(function ($value, int $key) {
            return $value->computable_type == 'App\Models\WorkExperience';
        });

        $works = $included_work->map(function ($value, int $key) {
            return $value->computable;
        });

       

        $total_years = 0;

        foreach($works as $work){
            $years = 0;

            if($work->to_present){
                $years = self::calculateTotalYears($work->inclusive_date_from, $posting->closing_date);
            }else{
                $years = self::calculateTotalYears($work->inclusive_date_from, $work->inclusive_date_to);
            }

            $total_years += $years;
        }

        
        
        if($plantilla->work_experience) { // if work experience is required
            if($total_years >= $plantilla->work_experience){
                $work_points = 30;
                $total_year_excess_count = $total_years - $plantilla->work_experience;
            }
        }

        $excess_points = $total_year_excess_count *  3.5;

        if($excess_points >= 35){
            $excess_points = 35;
        }

        return [
            'user' => $application->user->name,
            'equivalent'=> $work_points + $excess_points,
            'years' => $total_years,
            'psb' =>  $psb_point_experience,
            'score' =>  round(($work_points + $excess_points + $psb_point_experience ) * .25, 2)
        ];
    }

    private static function calculateTotalYears($startDate, $endDate)
    {
        // Parse the input dates using Carbon
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        // Calculate the difference in years and months
        $diffInDays = $start->diffInDays($end);

        // Convert the difference to decimal years
        $totalYears = $diffInDays / 365.25;

        return round($totalYears, 2);
    }

    public function scopeMostRecent(Builder $query) {
        return $query->orderBy('inclusive_date_to', 'desc');
    }
}
