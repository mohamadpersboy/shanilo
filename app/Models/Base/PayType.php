<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use App\Traits\VisibilityTrait;
use App\Traits\AttachmentTrait;
use Rutorika\Sortable\SortableTrait;

class PayType extends Model
{
    use VisibilityTrait, AttachmentTrait, SortableTrait;

    protected $fillable = [
        'title',
        'description',
        "class_name",
        "type",
        'price_max',
        'position',
        'display',
    ];

    public function cities()
    {
        return $this->belongsToMany(City::class)->withPivot('price');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'pay_type');
    }
}
