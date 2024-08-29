<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class RewardAndRecognition extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'category'];


    public function employee() : HasManyThrough {
        return $this->hasManyThrough(User::class, EmployeeReward::class, 'reward_id', 'id', 'user_id', 'id');
    }
    
    public function non_academic() : HasMany {
        return $this->hasMany(NonAcademicDistinction::class, 'reward_id');
    }

    public static function outstanding_accoplishment($application_id) {
        $application = JobApplication::find($application_id);
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
}
