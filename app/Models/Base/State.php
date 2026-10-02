<?php

namespace App\Models\Base;

use App\Models\Specific\Accommodation;
use App\Models\Specific\TripInfo;
use Illuminate\Database\Eloquent\Model;
use App\Traits\VisibilityTrait;
use Rutorika\Sortable\SortableTrait;

class State extends Model
{
    use VisibilityTrait, SortableTrait;

    protected $fillable = [
        'name',
        'country_id',
        'code',
        'display',
        'position',
    ];

    public function cities()
    {
        return $this->hasMany(City::class)->orderBy('name','asc');
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function accommodations()
    {
        return $this->hasMany(Accommodation::class);
    }

    public function tripInfos()
    {
        return $this->morphMany(TripInfo::class,'destinationable');
    }
}
