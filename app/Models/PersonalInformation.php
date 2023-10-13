<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PersonalInformation extends Model
{
    use HasFactory;

    protected $table = "personal_information";
    protected $fillable = [
    "surname",
    "first_name",
    "middle_name",
    "name_extension",
    "date_of_birth",
    "place_of_birth",
    "sex",
    "height",
    "weight",
    "blood_type",
    "gsis_id_number",
    "pagibig_id_number",
    "sss_number",
    "philhealth_number",
    "tin_number",
    "agency_employee_number",
    "r_address_house_block_lot_number",
    "r_address_street",
    "r_address_subdivision_village",
    "r_address_barangay",
    "r_address_city_municipality",
    "r_address_zipcode",
    "r_address_province",
    "p_address_house_block_lot_number",
    "p_address_street",
    "p_address_subdivision_village",
    "p_address_barangay",
    "p_address_city_municipality",
    "p_address_zipcode" =>"string|max:255|nullable",
    "p_address_province",
    "telephone_number",
    "mobile_number",
    "email_address",
    "duplicate_address",
    "civil_status",
    "other_civil_status",
    "dual_citizenship",
    "filipino",
    "by_birth",
    "by_naturalization",
    "country",
    "same_address",
    ];

    protected $appends = ['address'];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function getAddressAttribute (){
        return "{$this->r_address_house_block_lot_number} {$this->r_address_street}, {$this->r_address_barangay}, {$this->r_address_city_municipality}, {$this->r_address_province}";
    }
    
}
