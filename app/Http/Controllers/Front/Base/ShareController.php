<?php

namespace App\Http\Controllers\Front\Base;

use App\Http\Controllers\Controller;
use App\Mail\ShopShare;
use App\Models\Specific\Shop;
use Illuminate\Http\Request;

use App\Mail\EmailUser;
use App\Mail\EmailVideoShare;
use App\Mail\EmailArticleShare;
use App\Mail\EmailNewsShare;

use Mail;

class ShareController extends Controller
{

    public function store(Request $request)
    {
        $this->validate($request,[
            'email'=>'required|email'
        ]);
        $id = $request->get('id');
        $model = $request->get('model');
        $query = $model::find($id);

        switch ($model) {
	        case Shop::class:
	            Mail::to($request->input('email'))->send(new ShopShare($query));
	            break;
	        default:
	            abort(404);
	    }
	    return [
	        'header'=>'موفق',
            'message'=>'لینک آیتم با موفقیت ارسال گردید',
            'type'=>'success'
        ];
	}
}
