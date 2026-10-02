<?php

namespace App\Models\Base;

use App\Traits\HasProductsCount;
use App\Traits\HasReports;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasProductsCount,HasReports;
    protected $fillable = [
        'commentable_id',
        'commentable_type',
        'user_id',
        'parent_id',
        'comment',
        'rate',
        'status'
    ];
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function commentable()
    {
        return $this->morphTo();
    }

    public function answers()
    {
        return $this->hasMany(Comment::class, 'parent_id')->with('user')->orderBy('created_at', 'desc');
    }

    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }



    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Scopes
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function scopeConfirmed($query)
    {
        return $query->where('status','confirmed');
    }

    public function scopePending($query)
    {
        return $query->where('status','pending');
    }

    public function scopeDenied($query)
    {
        return $query->where('status','denied');
    }

    public function scopeParents($query)
    {
        return $query->where('parent_id',null);
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Setters and getters
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function setRateAttribute($rate)
    {
        $this->attributes['rate']=$rate?:1;
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Helpers
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#

    public function isCommentedByAuth()
    {
        return  auth()->check() && $this->user_id==auth()->id();
    }


    public function getPersianName()
    {
        return [
            'name'=>'کامنت',
            'title'=>getUsersFullName($this->user),
            'url'=>$this->commentable->path()
        ];
    }
}
