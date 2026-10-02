<?php

namespace App\Models;

use App\Models\Base\User;
use Illuminate\Database\Eloquent\Model;

class MsgDetail extends Model
{
    protected $guarded = ['id'];

    protected $table = 'msg_details';

    protected $appends = ['show_file'];

    public function getShowFileAttribute()
    {
        return \Storage::disk('public')->url('/app/public/'.$this->file);
    }

    public function msg()
    {
        return $this->belongsTo(Msg::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
