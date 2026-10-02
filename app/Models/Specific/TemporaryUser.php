<?php

namespace App\Models\Specific;

use App\Models\Base\User;
use Illuminate\Database\Eloquent\Model;

class TemporaryUser extends Model
{
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Fields
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected $fillable = [
        'name',
        'family',
        'email',
        'uid',
        'mobile',
        'password',
        'hashed',
        'show_info'
    ];
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Helpers
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function transmit()
    {
        $data=$this->toArray();
        $data['confirm']=1;
        $data['password']=$this->password;
        $user=User::create($data);
        $this->delete();
        return $user;
    }
}
