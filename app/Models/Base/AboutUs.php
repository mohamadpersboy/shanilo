<?php

namespace App\Models\Base;

use App\Traits\AtlasLogActivityTrait;
use App\Traits\AttachmentTrait;
use App\Traits\VisibilityTrait;
use Illuminate\Database\Eloquent\Model;
use Rutorika\Sortable\SortableTrait;

/**
 * App\Models\Base\AboutUs
 *
 * @property int $id
 * @property string $title
 * @property string|null $summery
 * @property string $subtitle
 * @property string $description
 * @property int $position
 * @property int $display
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Activitylog\Models\Activity[] $activity
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Base\Attachment[] $attachments
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\AboutUs inVisible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\AboutUs sorted()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\AboutUs visible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\AboutUs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\AboutUs whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\AboutUs whereDisplay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\AboutUs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\AboutUs wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\AboutUs whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\AboutUs whereSummery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\AboutUs whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base\AboutUs whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AboutUs extends Model
{
    use AttachmentTrait,VisibilityTrait,SortableTrait,AtlasLogActivityTrait;
    /******************************/
    //Fields
    /******************************/
    protected $fillable=['title','subtitle','summery','description','position','display'];

    public $table='about_uses';

    /******************************/
    //Log
    /******************************/
    protected static $logAttributes = [
        'title',
        'subtitle',
        'summery',
        'description',
        'position',
        'display',
    ];

    const LOG_ACTIVITY_KEY="model.aboutUses";
}
