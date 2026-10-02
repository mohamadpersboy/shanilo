<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;
use App\Traits\VisibilityTrait;
use Rutorika\Sortable\SortableTrait;

class ContactUs extends Model
{
    use VisibilityTrait, SortableTrait;

    protected $table = 'contact_uses';
    protected $fillable = [
        'name',
        'email',
        'description',
        'subject',
        'company',
        'mobile',
        'read',
        'position',
        'display',
    ];
}
