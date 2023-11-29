<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class PageFourReferencesId extends Model
{
    use HasFactory;

    protected $table = 'page_four_references_id';

    protected $fillable = [
        "references_name_one",
        "references_address_one",
        "references_telephone_one",
        "references_name_two",
        "references_address_two",
        "references_telephone_two",
        "references_name_three",
        "references_address_three",
        "references_telephone_three",
        "government_issued_id",
        "id_license_passport_number",
        "date_place_of_issuance",
        "co_government_issued_id",
        "co_id_license_passport_number",
        "co_date_place_of_issuance",
        "photo",
    ];

    public function user() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function files() : MorphMany {
        return $this->morphMany(Document::class, 'fileable');
    }

}
