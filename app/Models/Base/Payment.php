<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'price',
        'account_name',
        'card_code',
        'tracking_code',
        'deposit_date',
        'source_bank_name',
        'destination_bank_name',
        'pay_type',
        'pay_status',
        'pay_subject',
        'dargah_id',
        'factor_id',
        'admin_bank_id',
        'user_id',
        'description',
    ];

    public function factor()
    {
        return $this->belongsTo(Factor::class);
    }

    public function admin_bank()
    {
        return $this->belongsTo(AdminBank::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pay_type_relation()
    {
        return $this->belongsTo(PayType::class,'pay_type');
    }
}
