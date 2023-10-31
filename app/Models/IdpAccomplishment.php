<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IdpAccomplishment extends Model
{
    use HasFactory;

    protected $fillable = ['lnd_form_id', 'activity', 'filepath'];

    protected $appends = ['src'];

    public function getSrcAttribute()
    {
        return asset("storage/{$this->filepath}");
    }

    public function lnd_form() : BelongsTo {
        return $this->belongsTo(LndForm::class, 'lnd_form_id');
    }
}
