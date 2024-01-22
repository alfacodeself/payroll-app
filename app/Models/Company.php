<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use App\Enums\Status;
use Carbon\Carbon;

class Company extends Authenticatable
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'status' => Status::class,
    ];
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $slug = Str::slug($value) . '-' . Carbon::now()->format('Ymd-his') . '-' . rand(1000, 9999);
        $this->attributes['slug'] = $slug;
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public static function getUsername()
    {
        return 'username';
    }
    public function departements()
    {
        return $this->hasMany(Departement::class);
    }
}
