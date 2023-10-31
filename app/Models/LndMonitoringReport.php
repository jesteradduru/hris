<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class LndMonitoringReport extends Model
{
    use HasFactory;

    protected $fillable = ['year'];
    protected $appends = ['status'];

    public function target_staff() : HasMany {
        return $this->hasMany(LndTargettedStaff::class, 'report_id');
    } 

    // LndMonitoringReport::with(['target_staff' => fn($query) => $query->withCount('target_staff_training')])->get()

    public function getStatusAttribute (){

        $employees = LndTargettedStaff::where('report_id', $this->id)->get();
        $learning_intervention = 0;

        foreach($employees as $staff){
            if($staff->target_staff_training()->exists()){
                $learning_intervention += 1;
            }
        }
        
        return [
            'total_targetted_staff' => count($employees),
            'total_learning_intervention' => $learning_intervention,
            'percentage' => ($learning_intervention / count($employees) ) * 100
        ];
    }
}
