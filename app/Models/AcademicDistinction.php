<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AcademicDistinction extends Model
{
    use HasFactory;

    protected $fillable = [
        'educ_id',
        'title',
        'category',
        'points',
    ];

    public function educ() : BelongsTo {
        return $this->belongsTo(EducationalBackgroundCollegeGraduateStudy::class, 'educ_id');
    }
}
