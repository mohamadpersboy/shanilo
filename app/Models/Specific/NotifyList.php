<?php

namespace App\Models\Specific;

use App\Models\Base\User;
use Illuminate\Database\Eloquent\Model;

class NotifyList extends Model
{
    protected $fillable=[
        'user_id',
        'notifiable_id',
        'notifiable_type'
    ];

    protected $with=['user'];
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function notifiable()
    {
        return $this->morphTo('notifiable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
