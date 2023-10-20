<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LndMonitoringReport extends Model
{
    use HasFactory;

    protected $fillable = ['year'];

    public function target_staff() : HasMany {
        return $this->hasMany(LndTargettedStaff::class, 'report_id');
    } 
}
