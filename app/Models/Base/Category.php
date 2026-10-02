<?php

namespace App\Models\Base;

use Baum\Node;

class Category extends Node
{

    protected $table = 'categories';
    protected $fillable = [
        'title',
        'description',
        'display',
        'position',
        'parent_id'
    ];
    protected $orderColumn = 'position';

    protected static $logAttributes = [
        'title',
        'description',
        'position',
        'display',
    ];

    const LOG_ACTIVITY_KEY="modelBase.category";

    public function scopeDepth($query,$depth){
        return $query->where('depth',$depth);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function brands()
    {
        return $this->belongsToMany(Brand::class);
    }
}
