<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Ticket extends Model
{
    use SoftDeletes,LogsActivity;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'code',
        'title',
        'message',
        'user_id',
        'parent_id',
        'status',
        'priority',
        'seenStatus',
    ];

    protected static $logAttributes = [
        'code',
        'title',
        'message',
        'status',
        'priority',
        'seenStatus',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'parent_id')->with('user')->orderBy('created_at', 'desc');
    }

    public function ticketOne()
    {
        return $this->belongsTo(Ticket::class, 'parent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
