<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class EducationalBackgroundCollegeGraduateStudy extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_of_school',
        'basic_ed_degree_course',
        'period_from',
        'period_to',
        'highest_lvl_units_earned',
        'year_graduated',
        'type',
        'user_id',
        'level'
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function files(): MorphMany
    {
        return $this->morphMany(Document::class, 'fileable');
    }

    public function academic_award(): HasMany
    {
        return $this->hasMany(AcademicDistinction::class, 'educ_id');
    }

    public static function compute_education(int $user_id){
        $user = User::find($user_id);
        $doctorate = $user->college_graduate_studies()->where('level', 'DOCTORATE')->whereRaw('year_graduated IS NOT NULL')->get();
        $earned_doctoral = $user->college_graduate_studies()->where('level', 'DOCTORATE')->whereRaw('year_graduated IS NULL')->get();
        $masteral = $user->college_graduate_studies()->where('level', 'MASTERAL')->whereRaw('year_graduated IS NOT NULL')->get();
        $earned_masteral = $user->college_graduate_studies()->where('level', 'MASTERAL')->whereRaw('year_graduated IS NULL')->get();
        $diploma = $user->college_graduate_studies()->where('level', 'DIPLOMA')->whereRaw('year_graduated IS NOT NULL')->get();
        $bachelor = $user->college_graduate_studies()->where('level', 'BACHELOR')->whereRaw('year_graduated IS NOT NULL')->get();
        $two_year = $user->college_graduate_studies()->where('level', 'TWO_YEAR')->whereRaw('year_graduated IS NOT NULL')->get();
        $education = 0;
        $courses = "";

        if(count($two_year) == 1){
            $courses .= self::join_educ($two_year);
            $education = 70;
        }

        if(count($bachelor) == 1){
            $courses .= self::join_educ($bachelor);
            $education = 80;
        }else if(count($bachelor) > 1){
            $courses .= self::join_educ($bachelor);
            $education = 81.5;
        }

        if(count($earned_masteral) > 0){
            $courses .= self::join_educ($earned_masteral);
            foreach($earned_masteral as $earned){
                if($earned->highest_lvl_units_earned >= 18){
                    $education = 82.5;
                }
            }
        }
        
        if(count($diploma) == 1){
            $courses .= self::join_educ($diploma);
            $education = 83.5;
        }

        if(count($masteral) == 1 || count($diploma) >= 2){
            $courses .= self::join_educ($masteral);
            $courses .= self::join_educ($diploma);
            $education = 85;
        }

        if(count($masteral) >= 2){
            $courses .= self::join_educ($masteral);
            $education = 90;
        }

        if(count($earned_doctoral) > 0){
            $courses .= self::join_educ($earned_doctoral);
            foreach($earned_doctoral as $earned){
                if($earned->highest_lvl_units_earned >= 18){
                    $education = 92.5;
                }
            }
        }

        if(count($doctorate) == 1){
            $courses .= self::join_educ($doctorate);
            $education = 95;
        }

        if(count($doctorate) >= 2){
            $courses .= self::join_educ($doctorate);
            $education = 100;
        }


        return [
            'user' => $user->name,
            'courses' => $courses,
            'equivalent'=> $education,
            'education' => $education * .1
        ];
    }

    public static function join_educ($educs) {

        $courses = "";

        foreach($educs as $educ){
            $units = $educ->highest_lvl_units_earned !== null ? "-{$educ->highest_lvl_units_earned} units" : "";
            $courses .= "\n{$educ->basic_ed_degree_course}-{$educ->name_of_school}{$units}";
        }
        
        return $courses;
    }
}
