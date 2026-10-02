<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

class UserBank extends Model
{
    protected $fillable = [
        'title',
        'name',
        'account_number',
        'account_card',
        'account_shaba',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function check_out()
    {
        return $this->hasMany(CheckOut::class,'user_bank_id');
    }
}
