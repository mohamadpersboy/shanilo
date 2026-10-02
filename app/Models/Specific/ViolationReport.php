<?php

namespace App\Models\Specific;

use App\Models\Base\User;
use App\Traits\VisibilityTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Rutorika\Sortable\SortableTrait;

class ViolationReport extends Model
{
    use SortableTrait,VisibilityTrait;
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Fields
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected $fillable=[
        'user_id',
        'reportable_id',
        'reportable_type',
        'description',
        'seen',
        'position',
        'display'
    ];
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reportable()
    {
        return $this->morphTo('reportable');
    }


    public function scopeNotSeen(Builder $builder)
    {
        return $builder->where('seen',0);
    }
}
