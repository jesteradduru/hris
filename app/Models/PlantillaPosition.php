<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PlantillaPosition extends Model
{
    use HasFactory;

    public function user() : HasOne {
        return $this->hasOne(User::class, 'plantilla_id');
    }

    public function division() : BelongsTo {
        return $this->belongsTo(Division::class, 'division_id');
    }
}
