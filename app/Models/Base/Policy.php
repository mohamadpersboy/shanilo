<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use App\Traits\VisibilityTrait;
use Rutorika\Sortable\SortableTrait;

class Policy extends Model
{
    use VisibilityTrait, SortableTrait;

    protected $fillable = [
        'title',
        'description',
        'position',
        'display',
    ];
}
