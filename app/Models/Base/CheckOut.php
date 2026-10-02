<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

class CheckOut extends Model
{
    protected $fillable = [
        'price',
        'price_check_out',
        'tracking_code',
        'pay_type',
        'pay_status',
        'user_bank_id',
        'user_id',
        'description',
    ];

    public function user_bank()
    {
        return $this->belongsTo(UserBank::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
