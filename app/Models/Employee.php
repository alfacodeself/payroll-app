<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Enums\Status;
use Carbon\Carbon;

class Employee extends Authenticatable
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'status' => Status::class,
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->generateEmployeeNumbers();
        });
    }

    protected function generateEmployeeNumbers()
    {
        $this->attributes['employee_number'] = Carbon::now()->format('Ymdhi');
    }

    public static function getUsername()
    {
        return 'employee_number';
    }

    public function employeeJobs()
    {
        return $this->hasMany(EmployeeJob::class);
    }
}