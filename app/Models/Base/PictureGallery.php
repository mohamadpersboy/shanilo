<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use App\Traits\VisibilityTrait;
use App\Traits\AttachmentTrait;
use Rutorika\Sortable\SortableTrait;

class PictureGallery extends Model
{
    use VisibilityTrait, AttachmentTrait, SortableTrait;

    protected $fillable = [
        'title',
        'position',
        'display',
        'location'
    ];

    /******************************/
    //Scopes
    /******************************/
    public function scopeGallery($query)
    {
        return $query->where('location','gallery');
    }

    public function scopeProducts($query)
    {
        return $query->where('location','products');
    }
}
