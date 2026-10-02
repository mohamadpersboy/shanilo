<?php

namespace App\Http\Controllers\Front\Advertisement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Advertisement\AdPlan;
use App\Models\Advertisement\AdTime;
use App\Models\Advertisement\AdDetail;
use App\Models\Advertisement\AdRequest;
use App\Http\Requests\Front\Advertisement\AdvertisementRequest;
use Auth;

class AdvertisementController extends Controller
{
    public function index()
    {
    	$items = [
            ["title" => "تبلیغات","link" => route('front.advertisement.index')]
        ];

    	$adPlans = AdPlan::visible()->wherehas('addetails')->orderBy('position')->get();
    	$adTimes = AdTime::visible()->wherehas('addetails')->orderBy('position')->get();

        $data = [
            "items" => $items,
            "adPlans" => $adPlans,
            "adTimes" => $adTimes,
        ];

        return view('front.pages.advertisement.index',$data);
    }

    public function choosePlan(Request $request)
    {
        $id = $request->get('id');
        $addetails = AdDetail::with('adtime')->where('ad_plan_id',$id)->get()->toArray();
        return json_encode(
        	array(
	            'addetails' => $addetails,
	        )
        );
    }

    public function chooseTime(Request $request)
    {
        $plan_id = $request->get('plan_id');
        $time_id = $request->get('time_id');
        $addetail = AdDetail::where([['ad_plan_id',$plan_id],['ad_time_id',$time_id]])->first()->toArray();
        return json_encode(
        	array(
	            'addetail' => $addetail,
	        )
        );
    }

    public function store(AdvertisementRequest $request)
    {
    	if(Auth::check()){
    		$request->request->add(['user_id' => Auth::user()->id]);
		}
        AdRequest::create($request->all());
        return redirect()->back()->with('msg', 'درخواست شما با موفقیت ثبت شد.');
    }
}
