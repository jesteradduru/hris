<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Division extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'abbreviation'];

    public function positions() : HasMany {
        return $this->hasMany(PlantillaPosition::class, 'division_id');
    }

    public function employees() : HasManyThrough {
        return $this->hasManyThrough(User::class, PlantillaPosition::class, 'division_id', 'plantilla_id');
    }
}
