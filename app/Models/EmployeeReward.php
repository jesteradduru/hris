<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeReward extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'reward_id'];
    protected $table = 'employee_rewards';

    public function employee() : BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function reward() : BelongsTo {
        return $this->belongsTo(RewardAndRecognition::class, 'reward_id');
    }
}
