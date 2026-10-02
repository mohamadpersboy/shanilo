<?php

namespace App\Models;

use App\Models\Base\User;
use App\Models\Specific\Shop;
use Illuminate\Database\Eloquent\Model;

class Msg extends Model
{
    const STATUS_SEND = 'send';

    const STATUS_REPLY = 'reply';

    protected $table = 'msg';

    protected $guarded = ['id'];

    protected $appends = ['status_msg'];

    public function details()
    {
        return $this->hasMany(MsgDetail::class, 'msg_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function getStatusMsgAttribute()
    {
        if ($this->status == self::STATUS_REPLY) {
            return 'پاسخ داده شده';
        } else {
            return 'ارسال شده';
        }
    }


}
