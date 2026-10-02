<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = [
        'noticable_id',
        'noticable_type',
        'user_id',
        'notice',
    ];

    public function noticable()
    {
        return $this->morphTo();
    }
}
