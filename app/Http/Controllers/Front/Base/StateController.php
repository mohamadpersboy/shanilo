<?php

namespace App\Http\Controllers\Front\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Base\State;
use App\Models\Base\City;

class StateController extends Controller
{
    public function change(Request $request)
    {
        $id = $request->get('id');
        $cities = City::where([['state_id',$id],['display',1]])->orderBy('name','asc')->get()->toArray();
        if(empty($cities)){
            $cities = NULL;
        }
        return json_encode(array(
                'cities' => $cities,
            )
        );
    }
}
