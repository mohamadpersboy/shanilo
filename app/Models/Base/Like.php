<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'likable_id',
        'likable_type',
        'user_id',
        'like',
    ];

    public function likable()
    {
        return $this->morphTo();
    }
}
