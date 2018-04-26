<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarningPhone extends Model
{
    protected $fillable = ['device_id', 'phone'];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
