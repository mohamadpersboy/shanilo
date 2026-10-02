<?php

namespace App\Models\Base;

use App\Traits\VisibilityTrait;
use Illuminate\Database\Eloquent\Model;
use Rutorika\Sortable\SortableTrait;

class PageItem extends Model
{
    use SortableTrait,VisibilityTrait;
    protected $fillable=['name','title','subtitle','icon','link','position','display'];

    //Relations
    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}
