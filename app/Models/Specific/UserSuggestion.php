<?php

namespace App\Models\Specific;

use App\Models\Base\User;
use Illuminate\Database\Eloquent\Model;

class UserSuggestion extends Model
{
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Fields
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected $fillable=[
        'user_id',
        'offerer_id',
        'product_detail_id'
    ];

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Relations
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function offerer()
    {
        return $this->belongsTo(User::class,'offerer_id');
    }

    public function productDetail()
    {
        return $this->belongsTo(ProductDetail::class);
    }
}
