<?php

namespace App\Models\Base;

use App\Models\Specific\ProductDetail;
use Illuminate\Database\Eloquent\Model;
use App\Traits\VisibilityTrait;
use Rutorika\Sortable\SortableTrait;

class Color extends Model
{
    use VisibilityTrait, SortableTrait;

    protected $fillable = [
        'title',
        'code',
        'position',
        'display',
    ];

    public function productDetails()
    {
        return $this->hasMany(ProductDetail::class);
    }   
}
