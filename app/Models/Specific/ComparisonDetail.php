<?php

namespace App\Models\Specific;

use Illuminate\Database\Eloquent\Model;

class ComparisonDetail extends Model
{
    protected $with=['product'];
    protected $fillable=[
        'comparison_id',
        'product_id'
    ];
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function comparison()
    {
        return $this->belongsTo(Comparison::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
