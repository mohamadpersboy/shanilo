<?php

namespace App\Models\Specific;

use App\Http\Helpers\Status;
use App\Models\Base\PayType;
use App\Traits\VisibilityTrait;
use Illuminate\Database\Eloquent\Model;
use Rutorika\Sortable\SortableTrait;

class Payment extends Model
{
    use SortableTrait,VisibilityTrait;
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Fields
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected $fillable=[
        'pay_type_id',
        'payable_id',
        'payable_type',
        'transaction_id',
        'tracking_code',
        'ref_id',
        'status',
        'price',
        'position',
        'display'
    ];
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function payType()
    {
        return $this->belongsTo(PayType::class);
    }

    public function payable()
    {
        return $this->morphTo('payable');
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Mutator
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function getFrontStatusAttribute()
    {
        $statuses=[
            'successful'=>new Status('موفق','green'),
            'unsuccessful'=>new Status('ناموفق','red'),
            'pending'=>new Status('در انتظار پرداخت','orange')
        ];
        return isset($statuses[$this->status])?$statuses[$this->status]:new Status('تعریف نشده','');
    }
}
