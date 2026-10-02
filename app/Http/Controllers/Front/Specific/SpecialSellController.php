<?php

namespace App\Http\Controllers\Front\Specific;

use App\Models\Specific\FirstPageSpecialSell;
use App\Models\Specific\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpecialSellController extends Controller
{
    public function index()
    {
        $firstPageSpecialSells=FirstPageSpecialSell::remaining();
        $selectedPlan=\request()->get('plan');
        if($selectedPlan){
            $firstPageSpecialSells->where('plan_id',$selectedPlan);
        }
        $limit = \request()->get('limit') ?: 12;
        $data=[
            'pageTitle'=>'پیشنهادات ویژه',
            'specialSells'=>$firstPageSpecialSells->offset(0)->limit($limit)->orderBy('created_at','desc')->get(),
            'hasMorePage'=>$firstPageSpecialSells->offset($limit)->limit($limit)->get()->count(),
            'plans'=>Plan::visible()->orderBy('position')->get(),
            'selectedPlan'=>$selectedPlan,
            'limit'=>$limit
        ];
        return view('front.pages.specialsell.index',$data);
    }
}
