<?php

namespace App\Models\DTR;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimesheetEntries extends Model
{
    use HasFactory;

    protected $fillable = [
        'timesheet_id',
        'employee',
        'purpose',
        'pass_type',
        'date',
        'pass_out',
        'pass_in',
        'supp_am_in',
        'supp_am_out',
        'supp_pm_in',
        'supp_pm_out',
        'off_title',
        'eo_start',
        'eo_end',
        'off_hours',
        'eo_sched_type',
        'remarks',
        'reg_multiday',
        'reg_start',
        'reg_end',
        
    ];

    public function draft() : BelongsTo {
        return $this->belongsTo(Timesheet::class, 'timesheet_draft_id');
    }

    public function user() : BelongsTo {
        return $this->belongsTo(User::class, 'employee');
    }
}
