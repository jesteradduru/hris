<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobPosting extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['by_user_id', 'place_of_assignment', 'position', 'plantilla_item_no', 'salary_grade', 'monthly_salary', 'eligibility', 'education', 'training', 'work_experience', 'competency', 'posting_date', 'closing_date', 'documents'];

    public function encoder() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function job_application() : HasMany {
        return $this->hasMany(JobApplication::class, 'job_posting_id');
    }

    public function results() : HasMany {
        return $this->hasMany(JobApplicationResults::class, 'job_posting_id');
    }

    public function scopeFilter(Builder $query, array $filters) : Builder {
        return $query
            ->when(
                $filters['search'] ?? false,
                fn ($query, $value) => $query->where('position', 'like', '%' . $value . '%')
                ->orWhere('place_of_assignment', 'like', '%' . $value . '%')
                ->orWhere('plantilla_item_no', 'like', '%' . $value . '%')
            )
            ->unless(
                $filters['order_by'] ?? false,
                fn ($query) => $query->orderBy('posting_date', 'desc')
            )
            ->when(
                $filters['order_by'] ?? false,
                fn ($query, $value) => $query->orderBy($value, $filters['order'])
            )
            ;
    }

    public function scopeOpen(Builder $query) : Builder {
        // return $query;
        return $query->where('closing_date', '>=', Carbon::now()->format('Y-m-d'));
    }
}
