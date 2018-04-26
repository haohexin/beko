<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    public function category()
    {
        return $this->hasOne(DeviceCategory::class, 'id', 'category_id');
    }

    public function model()
    {
        return $this->hasOne(DeviceModel::class, 'id', 'model_id');
    }

    public function industry()
    {
        return $this->hasOne(Industry::class, 'id', 'industry_id');
    }

    public function status()
    {
        return $this->hasOne(DeviceStatus::class, 'id', 'status_id');
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

    public function warningphones()
    {
        return $this->hasMany(WarningPhone::class);
    }

    public function maintainphones()
    {
        return $this->hasMany(MaintainPhone::class);
    }

    public function maintains()
    {
        return $this->hasMany(Maintain::class);
    }
}
