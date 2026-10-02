<?php

namespace App\Models\Advertisement;

use Illuminate\Database\Eloquent\Model;
use App\Traits\VisibilityTrait;
use Rutorika\Sortable\SortableTrait;
use App\Traits\AtlasLogActivityTrait;

/**
 * App\Models\Advertisement\AdTime
 *
 * @property int $id
 * @property string $title
 * @property string $day
 * @property int $position
 * @property int $display
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activity
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Advertisement\AdDetail[] $addetails
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdTime inVisible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdTime sorted()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdTime visible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdTime whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdTime whereDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdTime whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdTime whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdTime wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdTime whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Advertisement\AdTime whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AdTime extends Model
{
    use VisibilityTrait, SortableTrait, AtlasLogActivityTrait;

    protected $fillable = [
        'title',
        'day',
        'position',
        'display',
    ];

    protected static $logAttributes = [
    	'title',
        'day',
        'position',
        'display',
    ];

    const LOG_ACTIVITY_KEY="modelBase.adTime";

    public function addetails()
    {
        return $this->hasMany(AdDetail::class,'ad_time_id')->orderBy('position');
    }
}
