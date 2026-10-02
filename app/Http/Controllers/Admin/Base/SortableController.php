<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Rutorika\Sortable\SortableTrait;

class SortableController extends Controller
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

    public function update(Request $request)
    {
        $model_name = $request->get('entityName');
        $database = $request->get('database');
        $type = $request->get('type');
        $id = $request->get('id');
        $pid = $request->get('positionEntityId');
        $entity = $model_name::on($database)->find($id);
        $positionEntity = $model_name::on($database)->find($pid);
        $entity->$type($positionEntity);
    }
}
