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

    protected $fillable = [
        'archived_at',
        'by_user_id', 
        // 'place_of_assignment', 
        // 'position', 
        // 'plantilla_item_no', 
        // 'salary_grade', 
        // 'monthly_salary', 
        // 'eligibility', 
        // 'education', 
        // 'training', 
        // 'work_experience', 
        // 'competency',
        'plantilla_id',
        'posting_date', 
        'closing_date', 
        'documents'
    ];
    protected $appends = ['isClosed', 'plantilla'];

    public function encoder() : BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function plantilla() : BelongsTo {
        return $this->belongsTo(PlantillaPosition::class, 'plantilla_id');
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
                fn ($query, $value) => $query
                ->join('plantilla_positions', 'plantilla_positions.id', '=', 'job_postings.plantilla_id')
                // ->join('divisions', 'divisions.id', '=', 'plantilla_positions.division_id')
                ->where('plantilla_positions.position', 'like', '%' . $value . '%')
                ->orWhere('plantilla_positions.place_of_assignment', 'like', '%' . $value . '%')
                ->orWhere('plantilla_positions.plantilla_item_no', 'like', '%' . $value . '%')
                // ->orWhere('divisions.name', 'like', '%' . $value . '%')
                // ->orWhere('divisions.abbreviation', 'like', '%' . $value . '%')
            )
            ->unless(
                $filters['order_by'] ?? false,
                fn ($query) => $query->orderBy('posting_date', 'desc')
            )
            ->when(
                $filters['order_by'] ?? false,
                fn ($query, $value) => $query->orderBy($value, $filters['order'])
            )
            ->when(
                $filters['show'] ?? 'open',
                function($query, $value){
                    if($value == 'closed'){
                        return $query->where('closing_date', '<', 'now()');
                    }else if($value == 'archived'){
                        return $query->where('archived_at', 'IS NOT', null);
                    }else{
                        return $query->notArchived();
                    }
                }
            )
            ;
    }

    public function scopeOpen(Builder $query) : Builder {
        // return $query;
        return $query->where('closing_date', '>=', Carbon::now()->format('Y-m-d'));
    }
    public function scopeNotArchived(Builder $query) : Builder {
        // return $query;
        return $query->where('archived_at', null);
    }

    public function getIsClosedAttribute(){
        return $this->closing_date < now();
    }
    public function getPlantillaAttribute(){
        return PlantillaPosition::find($this->plantilla_id);
    }
    
}
