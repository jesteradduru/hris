<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FamilyBackground extends Model
{
    use HasFactory;

    protected $table = 'family_background';

    protected $fillable = [
        'spouse_surname',
        'spouse_first_name',
        'spouse_name_extension',
        'spouse_middle_name',
        'spouse_occupation',
        'spouse_employer_business_name',
        'spouse_business_address',
        'spouse_telephone_number',
        'fathers_surname',
        'fathers_first_name',
        'fathers_name_extension',
        'fathers_middle_name',
        'mothers_surname',
        'mothers_first_name',
        'mothers_middle_name',
        'spouse_deceased',
        'mothers_deceased',
        'fathers_deceased'
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }
}
