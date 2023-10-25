<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LndTargettedStaff extends Model
{
    use HasFactory;

    protected $fillable = ['report_id', 'user_id'];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    } 

    public function report() : BelongsTo {
        return $this->belongsTo(LndMonitoringReport::class, 'report_id');
    } 

    public function target_staff_training() : HasMany {
        return $this->hasMany(LndTrainingsAttended::class, 'target_staff_id');
    } 
}
