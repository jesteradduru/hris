<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class WorkExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        "inclusive_date_from",
        "inclusive_date_to",
        "position_title",
        "dept_agency_office_company",
        "name_of_office_unit",
        "office_address",
        "immediate_supervisor",
        "monthly_salary",
        "paygrade",
        "status_of_appointment",
        "govt_service",
        "list_of_accomplishments",
        "summary_of_duties",
        'to_present',
        'user_id'
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function included() : MorphMany {
        return $this->morphMany(IncludedComputation::class, 'computable');
    }

    public function scopeMostRecent(Builder $query) {
        return $query->orderBy('inclusive_date_to', 'desc');
    }
}
