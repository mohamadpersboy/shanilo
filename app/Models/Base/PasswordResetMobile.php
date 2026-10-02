<?php

namespace App\Models\Base;

use Illuminate\Database\Eloquent\Model;

/**
 * @property \Carbon\Carbon $expired_at
 */
class PasswordResetMobile extends Model
{
    public $dates=['expired_at'];

    protected $fillable=[
        'mobile',
        'code',
        'token',
        'expired_at'
    ];
}
