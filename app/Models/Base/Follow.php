<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable = [
        'followable_id',
        'followable_type',
        'user_id',
        'follow',
    ];

    public function followable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function follow_user()
    {
        return $this->belongsTo(User::class,'followable_id');
    }
}
