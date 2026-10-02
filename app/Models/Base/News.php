<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use App\Traits\VisibilityTrait;
use App\Traits\AttachmentTrait;
use Rutorika\Sortable\SortableTrait;

class News extends Model
{
    use VisibilityTrait, AttachmentTrait, SortableTrait;

    protected $table = 'news';
    protected $fillable = [
        'title',
        'source',
        'link',
        'summery',
        'description',
        'position',
        'display',
        'hit',
    ];

    public function relatedNews()
    {
        return $this->belongsToMany(self::class,'news_news','news_id','related_news_id');
    }
}
