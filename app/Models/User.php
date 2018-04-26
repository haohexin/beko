<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function category()
    {
        return $this->hasOne(UserCategory::class, 'id', 'user_category');
    }

    public function district()
    {
        return $this->hasOne(Address::class, 'id', 'district_id');
    }

    public function province()
    {
        return $this->hasOne(Address::class, 'id', 'province_id');
    }

    public function city()
    {
        return $this->hasOne(Address::class, 'id', 'city_id');
    }
}
