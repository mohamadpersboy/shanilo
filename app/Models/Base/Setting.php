<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable=[
        'section',
        'title',
        'name',
        'value',
        'type'
    ];
}
