<?php

namespace App\Models\Base;

use App\Models\Specific\Accommodation;
use App\Models\Specific\Shop;
use App\Models\Specific\TripInfo;
use Illuminate\Database\Eloquent\Model;
use App\Traits\VisibilityTrait;
use Rutorika\Sortable\SortableTrait;

class City extends Model
{
    use VisibilityTrait, SortableTrait;

    protected $fillable = [
        'name',
        'state_id',
        'code',
        'state_code',
        'display',
        'position',
    ];

    public function send_types()
    {
        return $this->belongsToMany(SendType::class)->withPivot('price');
    }

    public function pay_types()
    {
        return $this->belongsToMany(PayType::class)->withPivot('price');
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function shops()
    {
        return $this->hasMany(Shop::class);
    }

    public function accommodations()
    {
        return $this->hasMany(Accommodation::class);
    }

    public function tripInfos()
    {
        return $this->morphMany(TripInfo::class, 'destinationable');
    }
}
