<?php

namespace App\Models\Advertisement;

use Illuminate\Database\Eloquent\Model;
use App\Traits\VisibilityTrait;
use Rutorika\Sortable\SortableTrait;
use App\Traits\AtlasLogActivityTrait;

/**
 * App\Models\Advertisement\AdDetail
 *
 * @property int $id
 * @property string $price
 * @property string|null $discount
 * @property string|null $price_discount
 * @property int $ad_plan_id
 * @property int $ad_time_id
 * @property int $position
 * @property int $display
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activity
 * @property-read \App\Models\Advertisement\AdPlan $adplan
 * @property-read \App\Models\Advertisement\AdTime $adtime
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdDetail inVisible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdDetail planTime($plan, $time)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdDetail sorted()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdDetail visible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdDetail whereAdPlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdDetail whereAdTimeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdDetail whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdDetail whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdDetail wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdDetail wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdDetail wherePriceDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdDetail whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AdDetail extends Model
{
    use VisibilityTrait, SortableTrait, AtlasLogActivityTrait;

    protected $fillable = [
        'price',
        'discount',
        'price_discount',
        'ad_plan_id',
        'ad_time_id',
        'position',
        'display',
    ];

    protected static $logAttributes = [
    	'price',
        'discount',
        'price_discount',
        'ad_plan_id',
        'ad_time_id',
        'position',
        'display',
    ];

    const LOG_ACTIVITY_KEY="modelBase.adDetail";

    public function adplan()
    {
        return $this->belongsTo(AdPlan::class,'ad_plan_id');
    }

    public function adtime()
    {
        return $this->belongsTo(AdTime::class,'ad_time_id');
    }

    public function scopePlanTime($query,$plan,$time){
        return $query->where([['ad_plan_id',$plan],['ad_time_id',$time]])->first();
    }
}
