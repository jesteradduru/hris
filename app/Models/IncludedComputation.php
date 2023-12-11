<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class IncludedComputation extends Model
{
    use HasFactory;
    protected $fillable = ['computable_type', 'computable_id', 'job_application_id'];

    public function computable() : MorphTo {
        return $this->morphTo();
    }
}
