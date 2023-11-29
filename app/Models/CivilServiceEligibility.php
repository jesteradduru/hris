<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class CivilServiceEligibility extends Model
{
    use HasFactory;

    protected $table = 'civil_service_eligibility';

    protected $fillable = [
        "cs_board_bar_ces_csee_barangay_drivers" ,
            "rating" ,
            "date_of_exam_conferment" ,
            "place_of_exam_conferment" ,
            "license_number" ,
            "license_date_of_validity" ,
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }
    
    public function files() : MorphMany {
        return $this->morphMany(Document::class, 'fileable');
    }
}
