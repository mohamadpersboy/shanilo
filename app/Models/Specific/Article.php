<?php

namespace App\Models\Specific;

use App\Models\Base\User;
use App\Traits\AttachmentTrait;
use App\Traits\VisibilityTrait;
use Illuminate\Database\Eloquent\Model;
use Rutorika\Sortable\SortableTrait;

/**
 * App\Models\Specific\Article
 *
 * @property int $id
 * @property int $user_id
 * @property int|null $shop_id
 * @property string $title
 * @property string|null $source
 * @property string|null $link
 * @property string $description
 * @property int $views
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Specific\Shop|null $shop
 * @property-read \App\Models\Base\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Specific\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Specific\Article whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Specific\Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Specific\Article whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Specific\Article whereShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Specific\Article whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Specific\Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Specific\Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Specific\Article whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Specific\Article whereViews($value)
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Base\Attachment[] $attachments
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Specific\Article inVisible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Specific\Article sorted()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Specific\Article visible()
 */
class Article extends Model
{
    use SortableTrait,VisibilityTrait,AttachmentTrait;

    protected $with=['user'];
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Fields
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected $fillable=[
        'user_id',
        'shop_id',
        'title',
        'source',
        'link',
        'description',
        'display',
        'position'
    ];
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Mutations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function getSummeryAttribute()
    {
        return substr(trim($this->description),0,200);
    }
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class)->withTrashed();
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Helpers
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function path()
    {
        $currentRoute=explode('.',\Route::getCurrentRoute()->getName())[1];
        if($currentRoute=='shop-page' && $this->shop_id){
            return route('front.shop-page.article',[$this->shop,$this,str_slug($this->title)]);
        }
         return route('front.user-page.article',[$this->user,$this,str_slug($this->title)]);
    }
}
