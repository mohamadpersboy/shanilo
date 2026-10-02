<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use App\Traits\VisibilityTrait;
use App\Traits\AttachmentTrait;
use Rutorika\Sortable\SortableTrait;

class Member extends Model
{
    use VisibilityTrait, AttachmentTrait, SortableTrait;

    protected $fillable = [
        'name',
        'side',
        'member_category_id',
        'position',
        'display',
    ];

    public function member_category()
    {
        return $this->belongsTo(MemberCategory::class);
    }
}
