<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SwitchController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (\Session::get('lang') != null){
                \App::setLocale(\Session::get('lang'));
            }
            return $next($request);
        });
    }


    public function update(Request $request, $object)
    {
        $model = $request->get('model');
        $field = $request->get('field');
        $database = $request->get('database');
        $switchy = $request->get('switchy');
        if($model=='App\\Models\\Base\\Comment'){
            $switchy=$switchy?'confirmed':'pending';
        }else{
            $model::find($object)->update(['status'=>$switchy]);
        }
        $model::find($object)->update([
            $field => $switchy
        ]);

    }
}
