<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApplicationScore;
use App\Models\JobApplicationResults;
use App\Models\SpmsForm;
use App\Notifications\PublishApplicationResult;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PublishHiringResultController extends Controller
{
    public function __invoke(JobApplicationResults $results)
    {
       $applicationResults = $results->result;
       $job = $results->job_posting;
       $newResult = null;
        // create new result
       switch($results->phase){
                case 'SHORTLISTING':
                    $newResult = $job->results()->create([
                        'phase' => 'NEDA_EXAM'
                    ]);
                break;
                // case 'NEDA_EXAM_SCHEDULE':
                //     $newResult = $job->results()->create([
                //         'phase' => 'NEDA_EXAM'
                //     ]);
                // break;
                case 'NEDA_EXAM':
                    $newResult = $job->results()->create([
                        'phase' => 'INTERVIEW_SCHEDULE'
                    ]);
                break;
                case 'INTERVIEW_SCHEDULE':
                    $newResult = $job->results()->create([
                        'phase' => 'FOR_INTERVIEW'
                    ]);
                break;
                case 'FOR_INTERVIEW':
                    $newResult = $job->results()->create([
                        'phase' => 'FINAL'
                    ]);
                break;
                case 'FINAL':
                    $newResult = $job->results()->create([
                        'phase' => 'SELECTION'
                    ]);
                break;
                default:
                    $newResult = $job->results()->create([
                        'phase' => 'SHORTLISTING'
                    ]);
                break;
        }

       foreach($applicationResults as $currentResult) {
            $currentResult->update([
                'published' => true
            ]);

            $user = $currentResult->user;

            // self::compute($currentResult);

            self::notifyPublishResult($user, $currentResult);

            switch($currentResult->result){

                case 'QUALIFIED':
                    $currentResult->create([
                        'result_id' => $newResult->id,
                        'application_id' => $currentResult->application_id,
                        'user_id' => $currentResult->user_id,
                    ]);
                break;

                case 'SHORTLISTED':
                    $currentResult->create([
                        'result_id' => $newResult->id,
                        'application_id' => $currentResult->application_id,
                        'user_id' => $currentResult->user_id,
                    ]);
                break;

                case 'EXAM_PASSED':
                    $currentResult->create([
                        'result_id' => $newResult->id,
                        'application_id' => $currentResult->application_id,
                        'user_id' => $currentResult->user_id,
                        'result' => 'FOR_INTERVIEW'
                    ]);
                break;

                case 'FOR_INTERVIEW':
                    $currentResult->create([
                        'result_id' => $newResult->id,
                        'application_id' => $currentResult->application_id,
                        'user_id' => $currentResult->user_id,
                        'result' => 'SELECTION'
                    ]);
                break;
                
                case 'SELECTION':
                    self::compute($currentResult);
                    $currentResult->create([
                        'result_id' => $newResult->id,
                        'application_id' => $currentResult->application_id,
                        'user_id' => $currentResult->user_id,
                    ]);
                break;

                case 'SELECTED':
                    $currentResult->create([
                        'result_id' => $newResult->id,
                        'application_id' => $currentResult->application_id,
                        'user_id' => $currentResult->user_id,
                    ]);
                break;

                default:
                break;
            }
       }

    //    RANK THE SCORES
       $score_table_column = [ 'performance', 'education', 'experience', 'personality', 'potential', 'total'];
            foreach($score_table_column as $column ) {
                $candidates = $results->job_posting->scores->sortByDesc($column);

                $rank = 1;
        
                foreach ($candidates as $candidate) {
                    // dd($candidate);
                    $candidate->update([
                        $column . '_rank' => $rank,
                    ]);
        
                    $rank++;
                }
            }
       
    //    dd($computeResult);

    sweetalert()->addSuccess('Result successfully published!');

       return back();
    }

    private static function notifyPublishResult($user, $currentResult){
        // $user->notify(new PublishApplicationResult($currentResult, "Job hiring result released."));
    }


    private static function compute($currentResult){
        $performance_rating = self::performance($currentResult);
        $application = $currentResult->application;
        $hrmpsb_points = $application->psb_points;
        $outstanding = self::outstanding_accoplishment($currentResult);
        $education = self::compute_education($currentResult);
        $relevant_training = self::compute_training($currentResult);
        $experience = self::compute_experience($currentResult);
        $user = $currentResult->user;

        $performance_rating = ($performance_rating + $outstanding + $hrmpsb_points->performance) * 0.25;
        $education_rating = $education + $relevant_training;
        $experience_rating = ($experience + $hrmpsb_points->experience) * .25;
        $personality_rating = ($hrmpsb_points->org_competency + $hrmpsb_points->leadership_competency + $hrmpsb_points->technical_competency ) * .15;
        $potential_rating = $hrmpsb_points->potential;

        if($user->hasRole('employee')){
            $personality_rating = ($hrmpsb_points->org_competency + $hrmpsb_points->leadership_competency + $hrmpsb_points->technical_competency) * .15;
        }

        $total =  $performance_rating + $education_rating + $experience_rating + $personality_rating + $potential_rating;

        $score = ApplicationScore::create([
            "performance" => $performance_rating,
            "education" => $education_rating,
            "experience" => $experience_rating,
            "personality" => $personality_rating,
            "potential" => $hrmpsb_points->potential,
            "total" => $total,
            "job_application_id" => $application->id
        ]);
        
        return $score;
    }

    // compute performance 
    private static function performance($currentResult){
        $performance_rating = 50;
        $application = $currentResult->application;
        $user = $application->user;
        $job_posting = $application->job_posting;

        if($user->hasRole('employee')){
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
            

            if($latestSpms){
                $performance_rating = $latestSpms->avg('rating') / 5 * 70;
            }
        }else if($application->pes_rating()->exists()){ // if outsider
            $pesRatingOutsider = $application->pes_rating;

            if(($pesRatingOutsider->first_rating && $pesRatingOutsider->second_rating)){
                $performance_rating = ((($pesRatingOutsider->first_rating + $pesRatingOutsider->second_rating) / 2) / 5) * 70;
            }else if($pesRatingOutsider->first_rating){
                $performance_rating = ($pesRatingOutsider->first_rating / 5) * 70;
            }else if($pesRatingOutsider->second_rating){
                $performance_rating = ($pesRatingOutsider->second_rating / 5) * 70;
            }
        }

        return ($performance_rating);
    }
    

    // compute outstanding accomplishment

    private static function outstanding_accoplishment($currentResult) {
        $application = $currentResult->application;
        $computable = $application->included;
        $outstanding = 0;
        
        $non_acad_award = $computable->filter(function ($value, int $key) {
            return $value->computable_type == 'App\Models\NonAcademicDistinction';
        });

        $acad_award = $computable->filter(function ($value, int $key) {
            return $value->computable_type == 'App\Models\AcademicDistinction';
        });

        $non_acad_award_major_national = $non_acad_award->filter(function ($value, int $key) {
            $award = $value->computable;
            return $award->category == 'MAJOR_NATIONAL';
        });

        $non_acad_award_major_local = $non_acad_award->filter(function ($value, int $key) {
            $award = $value->computable;
            return $award->category == 'MAJOR_LOCAL';
        });

        $non_acad_award_minor = $non_acad_award->filter(function ($value, int $key) {
            $award = $value->computable;
            return $award->category == 'MINOR';
        });

        $non_acad_award_special = $non_acad_award->filter(function ($value, int $key) {
            $award = $value->computable;
            return $award->category == 'SPECIAL';
        });


        $acad_award_special = $acad_award->filter(function ($value, int $key) {
            $award = $value->computable;
            return $award->category == 'SPECIAL';
        });
        $acad_award_latin = $acad_award->filter(function ($value, int $key) {
            $award = $value->computable;
            return $award->category == 'LATIN';
        });

        // 1 major award national or 3 major local award
        if(count($non_acad_award_major_national) >= 1 || count($non_acad_award_major_local) == 3 ){
            $outstanding = 100;
         }

         // 2 major or 1 major + 2 or more minor
         if(count($non_acad_award_major_local) == 2 || (count($non_acad_award_major_local) == 1) && count($non_acad_award_minor) >= 2){
            $outstanding = $outstanding + 80;
         }

         if(count($non_acad_award_major_local) == 1){
            $outstanding = $outstanding + 60;
         }

        //  special awards more than 2
         if(count($non_acad_award_special) >= 2){
            $outstanding = $outstanding + 30;
         }

         // special awards only 1
         if(count($non_acad_award_special) == 1){
            $outstanding = $outstanding + 20;
         }

         // ACADEMIC AWARDS
         if(count($acad_award_latin) == 1){
            $outstanding = $outstanding + 20;
        }
         // ACADEMIC AWARDS
        if(count($acad_award_special) == 1){
            $outstanding = $outstanding + 10;
        }

        if($outstanding > 100){
            $outstanding = 100;
        }

        $outstanding = $outstanding * .15;

        return $outstanding;
    }

    // compute education and training

    // 1. education
    public static function compute_education($currentResult){
        $user = $currentResult->user;
        $doctorate = $user->college_graduate_studies()->where('level', 'DOCTORATE')->whereRaw('year_graduated IS NOT NULL')->get();
        $earned_doctoral = $user->college_graduate_studies()->where('level', 'DOCTORATE')->whereRaw('year_graduated IS NULL')->get();
        $masteral = $user->college_graduate_studies()->where('level', 'MASTERAL')->whereRaw('year_graduated IS NOT NULL')->get();
        $earned_masteral = $user->college_graduate_studies()->where('level', 'MASTERAL')->whereRaw('year_graduated IS NULL')->get();
        $diploma = $user->college_graduate_studies()->where('level', 'DIPLOMA')->whereRaw('year_graduated IS NOT NULL')->get();
        $bachelor = $user->college_graduate_studies()->where('level', 'BACHELOR')->whereRaw('year_graduated IS NOT NULL')->get();
        $two_year = $user->college_graduate_studies()->where('level', 'TWO_YEAR')->whereRaw('year_graduated IS NOT NULL')->get();
        $education = 0;


        if(count($two_year) == 1){
            $education = 70;
        }

        if(count($bachelor) == 1){
            $education = 80;
        }else if(count($bachelor) > 1){
            $education = 81.5;
        }

        if(count($earned_masteral) > 0){
            foreach($earned_masteral as $earned){
                if($earned->highest_lvl_units_earned >= 18){
                    $education = 82.5;
                }
            }
        }
        
        if(count($diploma) == 1){
            $education = 83.5;
        }

        if(count($masteral) == 1 || count($diploma) >= 2){
            $education = 85;
        }

        if(count($masteral) >= 2){
            $education = 90;
        }

        if(count($earned_doctoral) > 0){
            foreach($earned_doctoral as $earned){
                if($earned->highest_lvl_units_earned >= 18){
                    $education = 92.5;
                }
            }
        }

        if(count($doctorate) == 1){
            $education = 95;
        }

        if(count($doctorate) >= 2){
            $education = 100;
        }


        return $education * .1;
    }

    // 2. relevant trainings
    public static function compute_training($currentResult){
        $application = $currentResult->application;
        $computable = $application->included;
        $plantilla = $application->job_posting->plantilla;
        $training = 0;

        $included_trainings = $computable->filter(function ($value, int $key) {
            return $value->computable_type == 'App\Models\LearningAndDevelopment';
        });

        $trainings = $included_trainings->map(function ($value, int $key) {
            return $value->computable;
        });
        

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
    

        return $training * .1;
    }

    // EXPERIENCE
    public static function compute_experience($currentResult){
        $application = $currentResult->application;
        $computable = $application->included;
        $posting = $application->job_posting;
        $plantilla = $posting->plantilla;
        $work_points = 0;

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
                $work_points = 50;
                $total_years = $total_years - $plantilla->work_experience;
            }
        }

        $excess_points = $total_years *  3.5;

        if($excess_points >= 35){
            $excess_points = 35;
        }

        return $work_points + $excess_points;
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
}
