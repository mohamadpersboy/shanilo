<?php

namespace App\Models\Specific;

use App\Traits\VisibilityTrait;
use Illuminate\Database\Eloquent\Model;
use Rutorika\Sortable\SortableTrait;

class Wallet extends Model
{

    use SortableTrait, VisibilityTrait;

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Fields
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected $fillable = [
        'shop_id',
        'position',
        'display'
    ];

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function checkouts()
    {
        return $this->hasMany(Checkout::class);
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Mutators
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function getTotalAttribute()
    {

        return $this->walletTransactions()->where('type', 'add')->sum('price')
            -
            $this->walletTransactions()->where('type', 'sub')->sum('price')
            -
            $this->checkouts()->done()->sum('price');
    }

    public function getRemoveableAttribute()
    {
        $waitingPrice= $this->walletTransactions()->where('type','add')->waitForCheckout()->sum('price')
            - $this->walletTransactions()->where('type','sub')->waitForCheckout()->sum('price');
        return $this->total -$waitingPrice;
    }

    public function getCheckoutingAttribute()
    {
        $checkout=$this->checkouts()->where('status','pending')->latest()->first();
        return $checkout?$checkout->price:0;
    }

}
