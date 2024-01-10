<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Children extends Model
{
    use HasFactory;
    
    protected $table = 'name_of_children';
    protected $fillable = ['fullname', 'date_of_birth', 'deceased'];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }
}
