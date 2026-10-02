<?php

namespace App\Models\Specific;

use App\Traits\AddableToFirstPage;
use App\Traits\VisibilityTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Rutorika\Sortable\SortableTrait;

class SpecialSuggestion extends Model
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

    public function firstPageSpecialSuggestion()
    {
        return $this->hasOne(FirstPageSpecialSuggestion::class)->where('expires_at','>',Carbon::now());
    }

    public function inFirstPage()
    {
        return !!$this->firstPageSpecialSuggestion;
    }


}
