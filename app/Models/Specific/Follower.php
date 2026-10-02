<?php

namespace App\Models\Specific;

use App\Models\Base\User;
use App\Models\Specific\Shop;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Fields
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected $fillable=[
        'user_id',
        'followable_id',
        'followable_type'
    ];

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function followable()
    {
        return $this->morphTo('followable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
