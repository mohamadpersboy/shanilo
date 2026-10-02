<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table = 'home_sliders';
    public function getPathAttribute()
    {
        return url('storage/app/public/'.$this->attributes['path']);
    }
}
