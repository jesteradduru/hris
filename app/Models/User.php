<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\DTR\Timesheet;
use App\Models\DTR\TimesheetEntries;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

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

    protected $appends = ['name', 'role_name', 'profile_pic', 'division'];

    public function getNameAttribute() {
        return "{$this->surname}, {$this->first_name},  {$this->middle_name} {$this->name_extension}";
    }

    public function getRoleNameAttribute() {
        return $this->getRoleNames();
    }

    public function getProfilePicAttribute() {
        if($this->profile_picture()->exists()){
            return $this->profile_picture->src;
        }else{
            return null;
        }
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

    public function academic_distinction() : HasManyThrough {
        return $this->hasManyThrough(AcademicDistinction::class, EducationalBackgroundCollegeGraduateStudy::class, 'user_id', 'educ_id');
    }

    public function non_academic_distinction() : HasMany {
        return $this->hasMany(NonAcademicDistinction::class, 'user_id');
    }

    // job applications 
    public function job_application() : HasMany {
        return $this->hasMany(JobApplication::class, 'user_id');
    }
    

    //reward and recognition
    public function reward() : HasMany {
        return $this->hasMany(EmployeeReward::class, 'user_id');
    }

    // pes
    public function pes_rating() : HasOneThrough {
        return $this->hasOneThrough(PesRating::class, JobApplication::class, 'user_id', 'application_id');
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


    // timesheet draft
    public function timesheet_draft() : HasMany {
        return $this->hasMany(Timesheet::class, 'user_id');
    }

     // timesheet draft entry
     public function timesheet_draft_entry() : HasMany {
        return $this->hasMany(TimesheetEntries::class, 'employee');
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
                if( $value === 'All' ){
                    return $query;
                }
               return $query
               ->select(['users.*'])
               ->join('plantilla_positions as pp1', 'users.plantilla_id', '=', 'pp1.id')
               ->where('pp1.division_id', $value);
            }
        )
        ->when(
            $filters['employee_type'] ?? false, function($query, $value) {
                if($value == 'non-tech'){
                    return $query
                    ->select(['users.*'])
                    ->join('plantilla_positions as pp2', 'users.plantilla_id', '=', 'pp2.id')
                    ->where('pp2.salary_grade', '<=', 11);
                }else{
                    return $query
                    ->select(['users.*'])
                    ->join('plantilla_positions as pp3', 'users.plantilla_id', '=', 'pp3.id')
                    ->where('pp3.salary_grade', '>', 11);
                }
            }
        );
    }

    public function profile_picture(): MorphOne
    {
        return $this->morphOne(Document::class, 'fileable');
    }

    public function getDivisionAttribute() {
        if($this->plantilla_id){
            $plantilla = PlantillaPosition::find($this->plantilla_id);
            return $plantilla->division;
        }else{
            return null;
        }
    }
}
