<?php

namespace App\Models\Specific;

use App\Traits\AttachmentTrait;
use App\Traits\VisibilityTrait;
use Illuminate\Database\Eloquent\Model;
use Rutorika\Sortable\SortableTrait;

class ProductProperty extends Model
{
    use SortableTrait,VisibilityTrait;
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Fields
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected $fillable=[
        'product_id',
        'title',
        'position',
        'display'
    ];

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function details()
    {
        return $this->hasMany(ProductPropertyDetail::class);
    }
}
