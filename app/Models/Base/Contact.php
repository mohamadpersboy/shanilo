<?php

namespace App\Models\Base;

use App\Traits\VisibilityTrait;
use Illuminate\Database\Eloquent\Model;
use Rutorika\Sortable\SortableTrait;

/**
 * @property \Carbon\Carbon $created_at
 * @property int $id
 * @property \Carbon\Carbon $updated_at
 */
class Contact extends Model
{
    use VisibilityTrait, SortableTrait;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'phone',
        'mobile',
        'postal_code',
        'support_phone',
        'fax',
        'email',
        'address',
        'main',
        'latitude',
        'longitude',
        'position',
        'display'
    ];

    public function getItem($name, $index = false)
    {
        $item = $this->$name;
        if ($index!==false && is_numeric($index)) {
            $item = explode('/', $item);
            return $item[$index];
        }elseif (is_string($index) && $index=='all'){
            $item = explode('/', $item);
        }
        return $item;
    }
}
