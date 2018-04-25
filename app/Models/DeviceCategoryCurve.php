<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceCategoryCurve extends Model
{
    public function category()
    {
        return $this->belongsTo(DeviceCategory::class, 'category_id');
    }

    public function field()
    {
        return $this->belongsTo(DeviceField::class, 'field_id');
    }
}
