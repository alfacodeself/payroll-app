<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Status;
use App\Enums\JobType;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Job extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'status' => Status::class,
        'job_type' => JobType::class,
    ];
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $slug = Str::slug($value) . '-' . Carbon::now()->format('Y-m-d-his') . '-' . rand(10000, 99999);
        $this->attributes['slug'] = $slug;
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function getLogoAttribute($value)
    {
        return $value ? asset($value) : null;
    }

    public function scopeByCompany($query, $companyId)
    {
        return $query->with('departement.company')->whereHas('departement.company', function ($q) use ($companyId) {
            $q->where('id', $companyId);
        });
    }
    public function employeeJobs()
    {
        return $this->hasMany(EmployeeJob::class);
    }
    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }
}
