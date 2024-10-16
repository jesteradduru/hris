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

        // 1 major award national or more
        if(count($non_acad_award_major_national) >= 1 ){
            foreach($non_acad_award_major_national as $x){
                $outstanding += 80;
            }
         }

         // 1 or more major awards local
         if(count($non_acad_award_major_local) >= 1 ){
            $outstanding = $outstanding + 50;
         }

         // 1 minor award local
         if(count($non_acad_award_minor) == 1){
            $outstanding = $outstanding + 30;
         }

         // 2 or more minor awards local
         if(count($non_acad_award_minor) >= 2){
            $outstanding = $outstanding + 40;
         }

        // 1 special awards 
         if(count($non_acad_award_special) == 1){
            $outstanding = $outstanding + 10;
         }

         // 2 or more special awards only
         if(count($non_acad_award_special) >= 2){
            $outstanding = $outstanding + 20;
         }

         // ACADEMIC AWARDS
         if(count($acad_award_latin) > 0){
            foreach($acad_award_latin as $acad_awards){
                $outstanding = $outstanding + 10;
            }
        }
         // ACADEMIC AWARDS
        if(count($acad_award_special)> 0){
            foreach($acad_award_special as $acad_awards){
                $outstanding = $outstanding + 5;
            }
        }

        if($outstanding > 100){
            $outstanding = 100;
        }

        $outstanding = $outstanding * .15;

        return $outstanding;
    }
}
