<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Status;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Departement extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'status' => Status::class,
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
    // public function getStatusAttribute($value)
    // {
    //     $bg = 'bg-success';
    //     switch ($value) {
    //         case Status::ACTIVE->value:
    //             $bg = 'bg-success';
    //             $text = 'text-white';
    //             break;
    //         case Status::INACTIVE->value:
    //             $bg = 'bg-danger';
    //             break;
            
    //         default:
    //             $bg = 'bg-secondary';
    //             break;
    //     }
    //     return '<span class="badge ' . $bg . ' py-2">' . Str::upper($value) . '</span>';
    // }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
