<?php

namespace App\Models\Specific;

use App\Traits\AddableToFirstPage;
use App\Traits\VisibilityTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Rutorika\Sortable\SortableTrait;

class SpecialSell extends Model
{
    use SortableTrait,VisibilityTrait,AddableToFirstPage;
    protected $with=[
        'productDetail'
    ];
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Fields
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected $fillable=[
        'product_detail_id',
        'position',
        'display'
    ];
    
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function productDetail()
    {
        return $this->belongsTo(ProductDetail::class)->withTrashed();
    }

    public function firstPageSpecialSell()
    {
        return $this->hasOne(FirstPageSpecialSell::class)->where('expires_at','>',Carbon::now());
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Helpers
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function inFirstPage()
    {
        return !!$this->firstPageSpecialSell;
    }
}
