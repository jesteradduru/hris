<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PlantillaEligibilty extends Model
{
    use HasFactory;

    public function plantilla() : BelongsToMany {
        return $this->belongsToMany(PlantillaPosition::class, 'plantilla_id');
    }
    
    public function eligibility() : BelongsToMany {
        return $this->belongsToMany(Eligibility::class, 'eligibility_id');
    }
}
