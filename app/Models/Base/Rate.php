<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    protected $fillable = [
        'rateable_id',
        'rateable_type',
        'user_id',
        'rate',
    ];

    public function ratable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
