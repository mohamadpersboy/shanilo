<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    protected $fillable = [
        'email',
        'newsletter',
        'advertisement',
        'survey',
        'hashed',
        'token',
    ];
}
