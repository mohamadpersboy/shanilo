<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'notificable_id',
        'notificable_type',
        'master_id',
        'user_id',
        'status',
        'type',
        'more_id',
    ];

    public function notificable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
