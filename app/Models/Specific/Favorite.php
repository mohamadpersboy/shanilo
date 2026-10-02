<?php

namespace App\Models\Specific;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $with=[
        'details'
    ];
    protected $withCount=['details'];


    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function details()
    {
        return $this->hasMany(FavoriteDetail::class);
    }

}
