<?php

namespace App\Models\Advertisement;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Advertisement\AdRequest
 *
 * @property int $id
 * @property string $name
 * @property string $family
 * @property string $mobile
 * @property string $tel
 * @property string $email
 * @property string $link
 * @property int|null $user_id
 * @property int $ad_plan_id
 * @property int $ad_time_id
 * @property int $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Advertisement\AdPlan $adplan
 * @property-read \App\Models\Advertisement\AdTime $adtime
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdRequest whereAdPlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdRequest whereAdTimeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdRequest whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdRequest whereFamily($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdRequest whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdRequest whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdRequest whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdRequest whereTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdRequest whereUserId($value)
 * @mixin \Eloquent
 */
class AdRequest extends Model
{
    protected $fillable = [
        'name',
        'family',
        'mobile',
        'tel',
        'email',
        'link',
        'user_id',
        'ad_plan_id',
        'ad_time_id',
        'status',
    ];

    public function adplan()
    {
        return $this->belongsTo(AdPlan::class,'ad_plan_id');
    }

    public function adtime()
    {
        return $this->belongsTo(AdTime::class,'ad_time_id');
    }
}
