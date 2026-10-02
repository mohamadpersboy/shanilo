<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use App\Traits\VisibilityTrait;
use Rutorika\Sortable\SortableTrait;

class MemberCategory extends Model
{
    use VisibilityTrait, SortableTrait;

    protected $fillable = [
        'title',
        'position',
        'display',
    ];

    public function members()
    {
        return $this->hasMany(Member::class);
    }
}
