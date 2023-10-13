<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EducationalBackground extends Model
{
    use HasFactory;

    protected $table = 'educational_background';
    protected $fillable = [
        "elem_name_of_school",
        "elem_basic_ed_degree_course",
        "elem_period_from",
        "elem_period_to",
        "elem_highest_lvl_units_earned",
        "elem_year_graduated",
        "elem_scholarship_academic_honors",
        "second_name_of_school",
        "second_basic_ed_degree_course",
        "second_period_from",
        "second_period_to",
        "second_highest_lvl_units_earned",
        "second_year_graduated",
        "second_scholarship_academic_honors",
        "vocational_name_of_school",
        "vocational_basic_ed_degree_course",
        "vocational_period_from",
        "vocational_period_to",
        "vocational_highest_lvl_units_earned",
        "vocational_year_graduated",
        "vocational_scholarship_academic_honors",
        "college_name_of_school",
        "college_basic_ed_degree_course",
        "college_period_from",
        "college_period_to",
        "college_highest_lvl_units_earned",
        "college_year_graduated",
        "college_scholarship_academic_honors",
        "graduate_name_of_school",
        "graduate_basic_ed_degree_course",
        "graduate_period_from",
        "graduate_period_to",
        "graduate_highest_lvl_units_earned",
        "graduate_year_graduated",
        "graduate_scholarship_academic_honors",
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

}
