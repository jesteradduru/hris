<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplicationResults;
use App\Notifications\PublishApplicationResult;
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
                        'phase' => 'NEDA_EXAM_SCHEDULE'
                    ]);
                break;
                case 'NEDA_EXAM_SCHEDULE':
                    $newResult = $job->results()->create([
                        'phase' => 'NEDA_EXAM'
                    ]);
                break;
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
                        'result' => 'FOR_EXAM'
                    ]);
                break;

                case 'FOR_EXAM':
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

       return back()->with('success', 'Result successfully published.');
    }

    private static function notifyPublishResult($user, $currentResult){
        $user->notify(new PublishApplicationResult($currentResult, "Job hiring result released."));
    }



}
