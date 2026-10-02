<?php

namespace App\Models\Advertisement;

use Illuminate\Database\Eloquent\Model;
use App\Traits\VisibilityTrait;
use App\Traits\AttachmentTrait;
use Rutorika\Sortable\SortableTrait;
use App\Traits\AtlasLogActivityTrait;

/**
 * App\Models\Advertisement\Advertisement
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $family
 * @property string|null $mobile
 * @property string|null $tel
 * @property string|null $email
 * @property string $link
 * @property int|null $user_id
 * @property int $ad_plan_id
 * @property int $ad_time_id
 * @property int $position
 * @property int $display
 * @property string|null $expire_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activity
 * @property-read \App\Models\Advertisement\AdPlan $adplan
 * @property-read \App\Models\Advertisement\AdTime $adtime
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Base\Attachment[] $attachments
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\Advertisement inVisible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\Advertisement sorted()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\Advertisement visible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\Advertisement whereAdPlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\Advertisement whereAdTimeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\Advertisement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\Advertisement whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\Advertisement whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\Advertisement whereExpireAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\Advertisement whereFamily($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\Advertisement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\Advertisement whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\Advertisement whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\Advertisement whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\Advertisement wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\Advertisement whereTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\Advertisement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\Advertisement whereUserId($value)
 * @mixin \Eloquent
 */
class Advertisement extends Model
{
    use VisibilityTrait, AttachmentTrait, SortableTrait, AtlasLogActivityTrait;

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
        'position',
        'display',
        'expire_at',
    ];

    protected static $logAttributes = [
        'name',
        'family',
        'mobile',
        'tel',
        'email',
        'link',
        'position',
        'display',
        'expire_at',
    ];

    const LOG_ACTIVITY_KEY="modelBase.Advertisement";

    public function adplan()
    {
        return $this->belongsTo(AdPlan::class,'ad_plan_id');
    }

    public function adtime()
    {
        return $this->belongsTo(AdTime::class,'ad_time_id');
    }
}
