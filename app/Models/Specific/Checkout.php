<?php

namespace App\Models\Specific;


use App\Models\Traits\Specific\Mutator\CheckoutMutator;
use App\Models\Traits\Specific\Relation\CheckoutRelation;
use App\Traits\VisibilityTrait;
use Illuminate\Database\Eloquent\Model;
use Rutorika\Sortable\SortableTrait;

class Checkout extends Model
{
    use SortableTrait,VisibilityTrait,CheckoutRelation,CheckoutMutator;
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Fields
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected $fillable=[
        'wallet_id',
        'bank_cart_id',
        'price',
        'status',
        'tracking_code',
        'position',
        'display'
    ];

    protected $appends = ['format_price','condition_checkout','created_jalali','updated_jalali'];

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function bankCart()
    {
        return $this->belongsTo(BankCart::class);
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Scopes
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function scopeDone($query)
    {
        return $query->where('status','done');
    }

    public function scopePending($query)
    {
        return $query->where('status','pending');
    }

    public function scopeDenied($query)
    {
        return $query->where('status','denied');
    }
}
