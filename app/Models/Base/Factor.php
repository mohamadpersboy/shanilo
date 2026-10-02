<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

class Factor extends Model
{
    protected $fillable = [
        'title',
        'price',
        'discount',
        'price_after_discount',
        'send_type_id',
        'send_type_price',
        'send_type_time',
        'pay_type_id',
        'address_id',
        'send_status',
        'log',
        'description',
        'price_returned',
        'visited',
        'factor_subject',
        'factor_status',
        'user_id',
    ];

    // protected static function boot()
    // {
    //     static::deleting(function ($object) {
    //         $object->orders()->delete();
    //     });
    // }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function send_type()
    {
        return $this->belongsTo(SendType::class);
    }

    public function pay_type()
    {
        return $this->belongsTo(PayType::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
