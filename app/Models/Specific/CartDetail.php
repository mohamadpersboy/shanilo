<?php

namespace App\Models\Specific;

use App\Models\Base\Address;
use App\Models\Base\PayType;
use App\Models\Base\SendType;
use Illuminate\Database\Eloquent\Model;
use function Symfony\Component\Debug\Tests\testHeader;

class CartDetail extends Model
{
    const TAX=0;
    protected $with=[
        'details'
    ];
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Fields
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected $fillable=[
        'cart_id',
        'shop_id',
        'address_id',
        'send_type_id',
        'pay_type_id',
        'show_as_customer',
        'tax',
        'transport_price'
    ];

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function sendType()
    {
        return $this->belongsTo(SendType::class);
    }

    public function payType()
    {
        return $this->belongsTo(PayType::class);
    }

    public function details()
    {
        return $this->hasMany(CartDetailProduct::class);
    }


    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Helpers
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function total($onlyProducts=false)
    {
        $sum=0;
        foreach ($this->details as $detail){
            $sum+=$detail->productDetail->pure_price*$detail->count;
        }
        return $onlyProducts?$sum:$sum+$this->tax+$this->transport_price;
    }

    public function getTaxAttribute()
    {
        return roundPrice(subPercent($this->total(true),self::TAX));
    }

    public function calculateTransportPrice(SendType $sendType)
    {
        if($sendType->id==1 && $this->address_id){
            $city=$this->shop->cities()->where('city_id',$this->address->city_id)->first();
            $price=$city?$city->pivot->price:0;
        }else{
           $products=[];
           foreach ($this->details as $cartDetailProduct){
              for ($i=1;$i<=$cartDetailProduct->count;$i++){
                  $products[]=$cartDetailProduct->productDetail->weight;
              }
           }
           $postApi=new \App\Http\Helpers\PostApi;
           
           $price=roundPrice((int)($postApi->price($products)/10));
        }
        return $price;
    }

    /**
     * @return Order
     *
     * @throws \Throwable
     */
    public function transmit()
    {
        return \DB::transaction(function (){
            $order=new Order([
                'shop_id'=>$this->shop_id,
                'user_id'=>auth()->id(),
                'address_id'=>$this->address_id,
                'send_type_id'=>$this->send_type_id,
                'tax'=>$this->tax,
                'total'=>$this->total(),
                'show_as_customer'=>$this->show_as_customer,
                'transport_price'=>$this->transport_price,
            ]);
            $order->save();
            $orderDetails=[];
            foreach ($this->details as $detail){
                $orderDetails[]=new OrderDetail([
                    'product_detail_id'=>$detail->product_detail_id,
                    'price'=>$detail->productDetail->price,
                    'count'=>$detail->count,
                    'discount'=>$detail->productDetail->discount,
                    'properties'=>$detail->properties
                ]);
            }
            $order->details()->saveMany($orderDetails);
            $order->fresh()->payment()->create([
                'pay_type_id'=>$this->pay_type_id,
                'price'=>$this->total()
            ]);
            $this->delete();
            return $order;
        });
    }
}
