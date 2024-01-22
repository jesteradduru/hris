<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class RewardAndRecognition extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'category'];


    public function employee() : HasManyThrough {
        return $this->hasManyThrough(User::class, NonAcademicDistinction::class, 'reward_id', 'id', 'user_id', 'id');
    }
    
    public function non_academic() : HasMany {
        return $this->hasMany(NonAcademicDistinction::class, 'reward_id');
    }
}
