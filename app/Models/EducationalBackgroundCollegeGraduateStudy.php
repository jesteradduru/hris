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
}
