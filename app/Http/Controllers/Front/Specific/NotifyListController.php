<?php

namespace App\Http\Controllers\Front\Specific;

use App\Http\Controllers\Front\Traits\Specific\CanGetObject;
use App\Models\Specific\ProductDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotifyListController extends Controller
{
    use CanGetObject;
    public function toggle($object,$id)
    {
        $object=$this->getObject($object,$id);
        if (auth()->user()->hasItInNotifyLists($object)) {
            $object->notifyLists()->where('user_id',auth()->id())->delete();
            return [
                'method'=>'removeClass',
                'class'=>'active',
                'text'=>'اطلاع رسانی'
            ];
        } else {
            $object->notifyLists()->create([
                'user_id' => auth()->id()
            ]);
            return [
                'method'=>'addClass',
                'class'=>'active',
                'text'=>'موجود در اطلاع رسانی'
            ];
        }
    }
}
