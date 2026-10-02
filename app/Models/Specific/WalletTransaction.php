<?php

namespace App\Models\Specific;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    CONST ALLOW_CHECKOUT_AFTER_DAYS = 3;
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Fields
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected $fillable = [
        'wallet_id',
        'order_id',
        'type',
        'source',
        'destination',
        'price'
    ];

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Scope
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function scopeWaitForCheckout($query)
    {
        
        return $query->where('created_at', '>', Carbon::now()->subDays(self::ALLOW_CHECKOUT_AFTER_DAYS))->whereHas('order', function (Builder $builder) {
            $builder->whereIn('status',[1,2,3,4]);
        });
    }
}
