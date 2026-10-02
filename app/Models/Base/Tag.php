<?php

namespace App\Models\Base;

use Baum\Node;

/**
 * Tag
 */
class Tag extends Node
{

    /**
     * Table name.
     *
     * @var string
     */
    protected $table = 'tags';
    protected $fillable = [
        'name',
        'text',
        'position',
        'display',
        'parent_id',
    ];
    protected $orderColumn = 'position';

    public function scopeVisible($query){
        return $query->where('display',1);
    }

    public function scopeInVisible($query){
        return $query->where('display',0);
    }

    public function scopeDepth($query,$depth){
        return $query->where('depth',$depth);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

}
