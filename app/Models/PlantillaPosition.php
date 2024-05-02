<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PlantillaPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'place_of_assignment',
        'position',
        'plantilla_item_no',
        'salary_grade',
        'monthly_salary',
        'eligibility',
        'education',
        'training',
        'work_experience',
        'competency',
        'division_id'
    ];

    protected $appends = ['division'];

    public function user() : HasOne {
        return $this->hasOne(User::class, 'plantilla_id');
    }

    public function job_posting() : HasOne {
        return $this->hasOne(JobPosting::class, 'plantilla_id');
    }

    public function division() : BelongsTo {
        return $this->belongsTo(Division::class, 'division_id');
    }

    public function eligibility() : HasMany {
        return $this->hasMany(PlantillaEligibilty::class, 'plantilla_id');
    }

    public function getDivisionAttribute(){
        return Division::find($this->division_id);
    }
}
