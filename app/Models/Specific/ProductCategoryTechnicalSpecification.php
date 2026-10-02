<?php

namespace App\Models\Specific;

use App\Traits\VisibilityTrait;
use Illuminate\Database\Eloquent\Model;
use Rutorika\Sortable\SortableTrait;

class ProductCategoryTechnicalSpecification extends Model
{
    use SortableTrait,VisibilityTrait;
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Fields
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected $fillable=[
        'product_category_id',
        'technical_specification_id',
        'position',
        'display'
    ];
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function technicalSpecification()
    {
        return $this->belongsTo(TechnicalSpecification::class);
    }
}
