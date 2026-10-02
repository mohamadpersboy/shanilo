<?php

namespace App\Models\Specific;

use App\Traits\VisibilityTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Rutorika\Sortable\SortableTrait;

class FirstPageSpecialSuggestion extends Model
{
    use SortableTrait, VisibilityTrait;

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Fields
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected $dates = ['expires_at'];
    protected $fillable = [
        'special_suggestion_id',
        'plan_id',
        'expires_at',
        'position',
        'display'
    ];

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function specialSuggestion()
    {
        return $this->belongsTo(SpecialSuggestion::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function productDetail()
    {
        return $this->specialSuggestion->productDetail();
    }

    public function payment()
    {
        return $this->morphOne(Payment::class, 'payable');
    }
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Scopes
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function scopeRemaining(Builder $builder)
    {
        return $builder->where('expires_at', '>', Carbon::now());
    }

    public function scopeExpired(Builder $builder)
    {
        return $builder->where('expires_at', '<', Carbon::now());
    }
}
