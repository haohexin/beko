<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintainPhone extends Model
{
    protected $fillable = ['device_id', 'phone'];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
