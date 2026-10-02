<?php

namespace App\Models;

use App\Models\Base\User;
use Illuminate\Database\Eloquent\Model;

class ProductMessage extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class,'sender_id','id');
    }
}
