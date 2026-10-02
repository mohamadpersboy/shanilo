<?php

namespace App\Models\Base;

use App\Models\Specific\Cart;
use App\Models\Specific\Shop;
use Illuminate\Database\Eloquent\Model;
use App\Traits\VisibilityTrait;
use App\Traits\AttachmentTrait;
use Rutorika\Sortable\SortableTrait;

class SendType extends Model
{
    use VisibilityTrait, AttachmentTrait, SortableTrait;

    protected $fillable = [
        'title',
        'description',
        'price',
        'free_from',
        'position',
        'display',
    ];

    public function cities()
    {
        return $this->belongsToMany(City::class)->withPivot('price');
    }

    public function shops()
    {
        return $this->belongsToMany(Shop::class);
    }

    public function calculatePriceWithCart(Cart $cart)
    {
        $price=0;
        if($this->free_from>0 && Cart::totalProductsPrice()>= $this->free_from){
            return $price;
        }
        if($city=$this->cities()->where('city_id',$cart->address->city_id)->first()){
            $price=$city->pivot->price?:$this->price;
        }
        return $price;
    }
}
