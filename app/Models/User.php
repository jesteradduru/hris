<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "surname",
        "first_name" ,
        "middle_name" ,
        "name_extension" ,
        'username',
        'dtr_user_id',
        'password',
        'plantilla_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $appends = ['name', 'role_name'];

    public function getNameAttribute() {
        return "{$this->surname}, {$this->first_name},  {$this->middle_name} {$this->name_extension}";
    }

    public function getRoleNameAttribute() {
        return $this->getRoleNames();
    }

    public function dtr() : BelongsTo {
        return $this->belongsTo(DailyTimeRecord::class, 'user_id', 'dtr_user_id');
    }

    // created job posting for admin and hr
    public function job_posting() : HasMany {
        return $this->hasMany(JobPosting::class, 'by_user_id');
    }

    public function position() : BelongsTo {
        return $this->belongsTo(PlantillaPosition::class, 'plantilla_id');
    }

    // PDS
    public function personal_information() : HasOne {
        return $this->hasOne(PersonalInformation::class, 'user_id');
    }
    public function family_background() : HasOne {
        return $this->hasOne(FamilyBackground::class, 'user_id');
    }
    public function children() : HasMany {
        return $this->hasMany(Children::class, 'user_id');
    }
    public function college_graduate_studies() : HasMany {
        return $this->hasMany(EducationalBackgroundCollegeGraduateStudy::class, 'user_id');
    }
    public function educational_background() : HasOne {
        return $this->hasOne(EducationalBackground::class, 'user_id');
    }
    public function civil_service_eligibility() : HasMany {
        return $this->hasMany(CivilServiceEligibility::class, 'user_id');
    }
    public function work_experience() : HasMany {
        return $this->hasMany(WorkExperience::class, 'user_id');
    }
    public function voluntary_work() : HasMany {
        return $this->hasMany(VoluntaryWork::class, 'user_id');
    }
    public function learning_and_development() : HasMany {
        return $this->hasMany(LearningAndDevelopment::class, 'user_id');
    }
    public function other_information() : HasOne {
        return $this->hasOne(OtherInformation::class, 'user_id');
    }
    public function page_four_questions() : HasOne {
        return $this->hasOne(PageFourQuestion::class, 'user_id');
    }
    public function references_id() : HasOne {
        return $this->hasOne(PageFourReferencesId::class, 'user_id');
    }

    // job applications 
    public function job_application() : HasMany {
        return $this->hasMany(JobApplication::class, 'user_id');
    }
    

    //reward and recognition
    public function reward() : HasMany {
        return $this->hasMany(EmployeeReward::class, 'user_id');
    }

    //spms
    public function spms() : HasMany {
        return $this->hasMany(SpmsForm::class, 'user_id');
    }
    
    //lnd
    public function lnd_form() : HasMany {
        return $this->hasMany(LndForm::class, 'user_id');
    }

    public function priority_for_training() : HasMany {
        return $this->hasMany(LndTargettedStaff::class, 'user_id');
    }
    
    public function scopeFilter(Builder $query, array $filters):Builder{
        return $query->when(
            $filters['name'] ?? false,
            fn($query, $value) => $query->where('first_name','LIKE','%'.$value.'%')
                ->orWhere('middle_name','LIKE','%'.$value.'%')
                ->orWhere('surname','LIKE','%'.$value.'%')
        )
        ->when(
            $filters['division'] ?? false, function($query, $value) {
               return $query
               ->join('plantilla_positions', 'users.plantilla_id', '=', 'plantilla_positions.id')
               ->where('plantilla_positions.division_id', $value);
            }
        );
    }
}
