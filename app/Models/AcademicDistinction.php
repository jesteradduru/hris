<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class AcademicDistinction extends Model
{
    use HasFactory;

    protected $fillable = [
        'educ_id',
        'title',
        'category',
        'date_awarded',
        'points',
    ];

    protected $appends = ['included'];

    public function educ() : BelongsTo {
        return $this->belongsTo(EducationalBackgroundCollegeGraduateStudy::class, 'educ_id');
    }

    public function files(): MorphMany
    {
        return $this->morphMany(Document::class, 'fileable');
    }

    public function included() : MorphMany {
        return $this->morphMany(IncludedComputation::class, 'computable');
    }

    public function getIncludedAttribute() {
        return $this->included()->exists();
    }
}
