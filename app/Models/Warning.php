<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warning extends Model
{
    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function category()
    {
        return $this->belongsTo(WarningCategory::class,'category_id');
    }
}
