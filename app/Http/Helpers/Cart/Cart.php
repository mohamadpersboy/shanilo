<?php
/**
 * Created by PhpStorm.
 * User: milad
 * Date: 11/14/2018
 * Time: 3:33 PM
 */

namespace App\Http\Helpers\Cart;

use App\Models\Specific\Cart as CartModel;
use App\Interfaces\CookieBaseModels;
use App\Models\Specific\CartDetail;
use App\Models\Specific\CartDetailProduct;
use Illuminate\Database\Eloquent\Builder;

class Cart implements CookieBaseModels
{
    protected $cart;

    public function __construct($cartId)
    {
        if ($cartId) {
            if ($cart = CartModel::find($cartId)) {
                $this->cart = $cart;
            } else {
                $this->cart = $this->make();
            }
        } else {
            $this->cart = $this->make();
        }
    }

    public function get()
    {
        return $this->cart;
    }

    public function make()
    {
        $cart = CartModel::create();
        \Cookie::queue('cart', $cart->id, 2628000);
        return $cart;
    }

    public function details()
    {
        return CartDetail::where('cart_id', $this->cart->id)->get();
    }

    public function has($object)
    {
        return CartDetailProduct::where(function (Builder $builder) use ($object) {
            $builder->whereHas('cartDetail', function (Builder $builder) {
                $builder->whereHas('cart', function (Builder $builder) {
                    $builder->where('id', $this->cart->id);
                });
            })->where('product_detail_id', $object->id);
        })->exists();
    }

    public function add($object)
    {
        $shop = $object->shop;
        $cartDetail = $this->cart->details()->where('shop_id', $shop->id)->first() ?:
            $this->cart->details()->create([
                'shop_id' => $shop->id
            ]);
        return $cartDetail->details()->create([
            'product_detail_id' => $object->id,
            'properties' => json_encode($object->properties)
        ]);
    }

    public function remove($object)
    {
        $cartDetailProduct=CartDetailProduct::where(function (Builder $builder) use ($object) {
            $builder->whereHas('cartDetail', function (Builder $builder) {
                $builder->whereHas('cart', function (Builder $builder) {
                    $builder->where('id', $this->cart->id);
                });
            })->where('product_detail_id', $object->id);
        })->first();
        if($cartDetailProduct){
            $cartDetailProduct->delete();
        }
        return true;
    }

    public function count()
    {
        return $this->cart->fresh()->details->flatMap(function (CartDetail $cartDetail) {
            return $cartDetail->fresh()->details;
        })->count();
    }

    public function products()
    {
        return $this->cart->fresh()->details->flatMap(function (CartDetail $cartDetail) {
            return $cartDetail->details->map(function (CartDetailProduct $cartDetailProduct){
                return $cartDetailProduct->productDetail;
            });
        });
    }

    public function sumProductsPrice()
    {
        $sum = 0;
        foreach ($this->details() as $detail) {
            $sum += $detail->total(true);
        }
        return $sum;
    }

}