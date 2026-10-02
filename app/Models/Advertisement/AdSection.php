<?php

namespace App\Models\Advertisement;

use Illuminate\Database\Eloquent\Model;
use App\Traits\VisibilityTrait;
use App\Traits\AttachmentTrait;
use Rutorika\Sortable\SortableTrait;
use App\Traits\AtlasLogActivityTrait;

/**
 * App\Models\Advertisement\AdSection
 *
 * @property int $id
 * @property string $title
 * @property string $width
 * @property string $height
 * @property string $name
 * @property string $max_count
 * @property int $position
 * @property int $display
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activity
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Advertisement\AdPlan[] $ad_plans
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Base\Attachment[] $attachments
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdSection inVisible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdSection sorted()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdSection visible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdSection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdSection whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdSection whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdSection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdSection whereMaxCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdSection whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdSection wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdSection whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdSection whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdSection whereWidth($value)
 * @mixin \Eloquent
 */
class AdSection extends Model
{
    use VisibilityTrait, AttachmentTrait, SortableTrait, AtlasLogActivityTrait;

    protected $fillable = [
        'title',
        'width',
        'height',
        'name',
        'max_count',
        'position',
        'display',
    ];

    protected static $logAttributes = [
    	'title',
        'width',
        'height',
        'name',
        'max_count',
        'position',
        'display',
    ];

    const LOG_ACTIVITY_KEY="modelBase.adSection";

    public function ad_plans()
    {
        return $this->belongsToMany(AdPlan::class);
    }
}
