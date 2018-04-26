<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceData extends Model
{
    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function controlMode()
    {
        return $this->hasOne(ControlMode::class, 'id', 'control_mode');
    }
}
