<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApplicationScore;
use App\Models\EducationalBackgroundCollegeGraduateStudy;
use App\Models\JobApplicationResults;
use App\Models\LearningAndDevelopment;
use App\Models\RewardAndRecognition;
use App\Models\SpmsForm;
use App\Models\WorkExperience;
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

        $application_id = $currentResult->application_id;
        $posting = $currentResult->results->job_posting_id;
        $user_id = $currentResult->user_id;

        $performance_rating = SpmsForm::compute_performance($user_id, $posting, $application_id);

        $application = $currentResult->application;
        $hrmpsb_points = $application->psb_points;
        $outstanding = RewardAndRecognition::outstanding_accoplishment($application_id);
        $education = EducationalBackgroundCollegeGraduateStudy::compute_education($user_id);
        $relevant_training = LearningAndDevelopment::compute_training($application_id);
        $experience = WorkExperience::compute_experience($application_id);
        $user = $currentResult->user;

        $pvei = $hrmpsb_points->org_competency + $hrmpsb_points->leadership_competency + $hrmpsb_points->technical_competency;
        $performance_rating = ($performance_rating['equivalent'] + $outstanding + ($pvei * .15)) * 0.25;
        $education_rating = $education['education'] + $relevant_training['score'];
        $experience_rating = $experience['score'];
        $personality_rating = ($hrmpsb_points->org_competency + $hrmpsb_points->leadership_competency + $hrmpsb_points->technical_competency ) * .15;
        $potential_rating = $hrmpsb_points->potential;

        if($user->hasRole('employee')){
            $personality_rating = ((($hrmpsb_points->org_competency + $hrmpsb_points->leadership_competency + $hrmpsb_points->technical_competency) * .8) + $hrmpsb_points->personality_peer) * .15;
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
}
