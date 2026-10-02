<?php

namespace App\Models\Specific;

use Illuminate\Database\Eloquent\Model;

class Comparison extends Model
{
    protected $with=[
        'details'
    ];
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relattions
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function details()
    {
        return $this->hasMany(ComparisonDetail::class);
    }
}
