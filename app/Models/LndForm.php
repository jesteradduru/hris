<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LndForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'filepath',
        'user_id',
        'type',
        'year'

    ];
    
    protected $appends = ['src'];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    } 

    public function getSrcAttribute()
    {
        return asset("storage/{$this->filepath}");
    }

    public function lnd_training() : HasMany {
        return $this->hasMany(LndTrainingsAttended::class, 'lnd_form_id');
    }


}
