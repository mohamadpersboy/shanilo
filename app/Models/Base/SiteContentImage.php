<?php

namespace App\Models\Base;

use App\Traits\AttachmentTrait;
use App\Traits\VisibilityTrait;
use Illuminate\Database\Eloquent\Model;
use Rutorika\Sortable\SortableTrait;

class SiteContentImage extends Model
{
    use VisibilityTrait,SortableTrait,AttachmentTrait;

    protected $fillable=['title','name','url','position','display'];

    public static function getImage($name,$default='')
    {
        $siteContentImage=self::where('name',$name)->first();
        return $siteContentImage?$siteContentImage->takeImage('main'):$default;
    }

    public static function getObject($name)
    {
       return self::where('name',$name)->visible()->first();
    }
    public static function has($name)
    {
       return self::where('name',$name)->visible()->exists();
    }

}
