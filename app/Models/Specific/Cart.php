<?php

namespace App\Models\Specific;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $with=['details'];
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#

    public function details()
    {
        return $this->hasMany(CartDetail::class);
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Helpers
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#

    /**:::::::::::::::**| Static functions |**:::::::::::::::**/
    public static function getCart()
    {
        return self::makeCart();
    }

    public static function addToCart(ProductDetail $productDetail)
    {

        $shopId = $productDetail->product->shop_id;
        $cart = self::getCart();
        $cartDetail= $cart->details()->where('shop_id', $shopId)->first();
        if(!$cartDetail){
            $cartDetail=$cart->details()->create([
                'shop_id'=>$shopId
            ]);
        }
        $cartDetail->details()->create([
            'product_detail_id'=>$productDetail->id
        ]);
        return true;
    }

    public static function removeFromCart(ProductDetail $productDetail)
    {
        $shopId = $productDetail->product->shop_id;
        $cart = self::getCart();
        $cart->details()->where('shop_id',$shopId)->first()->details()->where('product_detail_id',$productDetail->id)->delete();
        return true;
    }

    public static function has(ProductDetail $productDetail)
    {
        $shopId = $productDetail->product->shop_id;
        $cart = self::getCart();
        return !!$cart->details()->where('shop_id',$shopId)->first()->details()->where('product_detail_id',$productDetail->id)->first();
    }

    public static function count()
    {
        return self::getCart()->details_count;
    }
    /**
     * @return mixed
     */
    protected static function makeCart()
    {
        if($cookie=\Cookie::get('cart')){
            $cart=Cart::find($cookie);
            if(!$cart){
                $cart = self::createCart();
            }
        }else{
            $cart=self::createCart();
        }
        return $cart;
    }

    /**
     * @return mixed
     */
    protected static function createCart()
    {
        $cart = self::create();
        \Cookie::queue('cart', $cart->id);
        return $cart;
    }

    public static function total($onlyProducts=false)
    {
        $sum=0;
        foreach (self::getCart()->details  as $detail){
            $sum+=$detail->total($onlyProducts);
        }
        return $sum;
    }
    /**:::::::::::::::**| Static functions end |**:::::::::::::::**/
}
