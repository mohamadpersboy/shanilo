<?php

namespace App\Models\Specific;

use Illuminate\Database\Eloquent\Model;

class CartDetailProduct extends Model
{
    protected $with=[
        'productDetail'
    ];
    public static function boot()
    {
        parent::boot();
        static ::deleted(function (self $cartDetailProduct){
            $cartDetail = $cartDetailProduct->cartDetail;
            if(!$cartDetail->details()->count()){
                $cartDetail->delete();
            }
        });
    }
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Fields
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected $fillable=[
        'cart_detail_id',
        'product_detail_id',
        'count',
        'properties'
    ];

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function cartDetail()
    {
        return $this->belongsTo(CartDetail::class);
    }

    public function productDetail()
    {
        return $this->belongsTo(ProductDetail::class);
    }


}
