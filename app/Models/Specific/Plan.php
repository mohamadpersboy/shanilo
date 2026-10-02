<?php

namespace App\Models\Specific;

use App\Traits\VisibilityTrait;
use Illuminate\Database\Eloquent\Model;
use Rutorika\Sortable\SortableTrait;

class Plan extends Model
{
    use SortableTrait,VisibilityTrait;
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Fields
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected $fillable=[
        'title',
        'func',
        'amount',
        'price',
        'position',
        'display'
    ];

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function firstPageSpecialSuggestions()
    {
        return $this->hasMany(FirstPageSpecialSuggestion::class);
    }

    public function firstPageSpecialSells()
    {
        return $this->hasMany(FirstPageSpecialSell::class);
    }

}
