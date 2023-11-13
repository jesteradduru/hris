<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Eligibility extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function plantilla() : HasMany {
        return $this->hasMany(PlantillaEligibilty::class, 'eligibility_id');
    }
}
