<?php

namespace App\Models\Base;

use App\Traits\AttachmentTrait;
use App\Traits\VisibilityTrait;
use Illuminate\Database\Eloquent\Model;
use Rutorika\Sortable\SortableTrait;

class Page extends Model
{
    use SortableTrait,AttachmentTrait,VisibilityTrait;

    protected $fillable = ['title', 'slug', 'summery', 'description', 'views', 'details', 'source', 'link'];

    protected $with=['items'];

    public function getDetailsAttribute()
    {
        return json_decode($this->attributes['details']);
    }
    //Relations
    public function items()
    {
        return $this->hasMany(PageItem::class);
    }

    public static function getPageWithSlug($slug)
    {
        return self::where('slug',$slug)->first();
    }
}
