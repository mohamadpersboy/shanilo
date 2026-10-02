<?php

namespace App\Models\Base;

use App\Models\Specific\Product;
use Illuminate\Database\Eloquent\Model;
use App\Traits\VisibilityTrait;
use Rutorika\Sortable\SortableTrait;

class Country extends Model
{
    use VisibilityTrait, SortableTrait;

    protected $fillable = [
        'name',
        'display',
        'position',
    ];

    public function states()
    {
        return $this->hasMany(State::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
