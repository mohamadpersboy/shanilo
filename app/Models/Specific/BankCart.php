<?php

namespace App\Models\Specific;


use App\Models\Base\User;
use App\Models\ModelTrait\Mutator\BankCartMutator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankCart extends Model
{
    use SoftDeletes,BankCartMutator;
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Fields
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected $fillable=[
        'user_id',
        'sheba_no',
        'cart_no',
        'owner',
        'expire_month',
        'expire_year'
    ];

    protected $appends = ['format_cart_no'];

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function checkouts()
    {
        return $this->hasMany(Checkout::class);
    }

    public function bankCarts()
    {
        return $this->hasMany(BankCart::class);
    }
}
