<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use App\Traits\VisibilityTrait;
use Rutorika\Sortable\SortableTrait;

class Education extends Model
{
    use VisibilityTrait, SortableTrait;

    protected $fillable = [
        'name',
        'position',
        'display',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
