<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'filepath',
        'fileable_id',
        'fileable_type',
    ];

    protected $appends = ['src'];

    public function getSrcAttribute()
    {
        return asset("storage/{$this->filepath}");
    }

    public function fileable() : MorphTo {
        return $this->morphTo();
    }
}
