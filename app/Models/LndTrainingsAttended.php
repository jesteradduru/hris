<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LndTrainingsAttended extends Model
{
    use HasFactory;

    protected $table = 'lnd_trainings_attended';
    protected $appends = ['training'];
    protected $fillable = ['training_id', 'lnd_form_id', 'target_staff_id'];
    

    public function lnd_form() : BelongsTo {
        return $this->belongsTo(LndForm::class, 'lnd_form_id');
    }

    public function learning_and_development() : BelongsTo {
        return $this->belongsTo(LearningAndDevelopment::class, 'training_id');
    }

    public function getTrainingAttribute() {
        return LearningAndDevelopment::find($this->training_id);
    }

    public function target_staff() : BelongsTo {
        return $this->belongsTo(LndTargettedStaff::class);
    } 
}
