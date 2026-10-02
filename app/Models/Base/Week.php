<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    protected $fillable = [
        'week',
        'from',
        'to',
    ];
}
