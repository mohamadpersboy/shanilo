<?php

namespace App\Models\Advertisement;

use Illuminate\Database\Eloquent\Model;
use App\Traits\VisibilityTrait;
use App\Traits\AttachmentTrait;
use Rutorika\Sortable\SortableTrait;
use App\Traits\AtlasLogActivityTrait;

/**
 * App\Models\Advertisement\AdPlan
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $position
 * @property int $display
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activity
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Advertisement\AdSection[] $ad_sections
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Advertisement\AdDetail[] $addetails
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Base\Attachment[] $attachments
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdPlan inVisible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdPlan sorted()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdPlan visible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdPlan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdPlan whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdPlan whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdPlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdPlan wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdPlan whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdPlan whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AdPlan extends Model
{
    use VisibilityTrait, AttachmentTrait, SortableTrait, AtlasLogActivityTrait;

    protected $fillable = [
        'title',
        'description',
        'position',
        'display',
    ];

    protected static $logAttributes = [
    	'title',
        'description',
        'position',
        'display',
    ];

    const LOG_ACTIVITY_KEY="modelBase.adPlan";

    public function addetails()
    {
        return $this->hasMany(AdDetail::class,'ad_plan_id')->orderBy('position');
    }

    public function ad_sections()
    {
        return $this->belongsToMany(AdSection::class);
    }
}
