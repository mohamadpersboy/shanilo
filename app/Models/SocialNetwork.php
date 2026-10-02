<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialNetwork extends Model
{
    protected $guarded = ['id'];

    public function getIconAttribute($value)
    {
        return url('storage/app/public/'.$value);
    }
}
