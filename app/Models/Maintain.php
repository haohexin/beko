<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintain extends Model
{
    protected $fillable = ['category_id','early_time'];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }

    public function category()
    {
        return $this->belongsTo(MaintainCategory::class,'category_id');
    }
}
