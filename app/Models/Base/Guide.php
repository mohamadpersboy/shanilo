<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use App\Traits\VisibilityTrait;
use App\Traits\AttachmentTrait;
use Rutorika\Sortable\SortableTrait;

class Guide extends Model
{
    use VisibilityTrait, AttachmentTrait, SortableTrait;

    protected $fillable = [
        'title',
        'description',
        'position',
        'display',
    ];
}
