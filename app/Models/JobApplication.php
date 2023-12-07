<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = ['job_application_id', 'job_posting_id'];
    protected $appends = ['latest_result'];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function document() : HasMany
    {
        return $this->hasMany(JobApplicationAttachment::class);
    }
    
    public function job_posting() : BelongsTo
    {
        return $this->belongsTo(JobPosting::class);
    }

    public function result() : HasMany
    {
        return $this->hasMany(ApplicationResult::class, 'application_id');
    }

    public function score() : HasOne
    {
        return $this->hasOne(ApplicationScore::class, 'job_application_id');
    }
    
    public function pes_rating() : HasOne {
        return $this->hasOne(PesRating::class, 'application_id');
    }

    public function getLatestResultAttribute(){
        return Applicationresult::latest()->where('application_id', $this->id)->first();
    }
}
