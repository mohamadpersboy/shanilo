<?php

namespace App\Models\Specific;

use App\Traits\VisibilityTrait;
use Illuminate\Database\Eloquent\Model;
use Rutorika\Sortable\SortableTrait;

class OrderDetail extends Model
{
    use VisibilityTrait,SortableTrait;
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Fields
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected $fillable=[
        'order_id',
        'product_detail_id',
        'price',
        'discount',
        'count',
        'properties',
        'position',
        'display'
    ];

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    /**:::::::::::::::**| Order |**:::::::::::::::**/
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
    /**:::::::::::::::**| Product detail |**:::::::::::::::**/
    public function productDetail()
    {
        return $this->belongsTo(ProductDetail::class)->withTrashed();
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Mutator
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function getPurePriceAttribute()
    {
        $price = subPercent($this->price, $this->discount, true);
        return roundPrice($price);
    }

    public function getPropertiesAttribute()
    {
        return json_decode($this->attributes['properties']);
    }
}
