<?php

namespace App\Http\Controllers\Front\Specific;

use App\Http\Controllers\Front\Traits\Specific\CanGetObject;
use App\Http\Controllers\Front\Traits\Specific\HasForbiddenMessageAndView;
use App\Models\Base\Comment;
use App\Models\Specific\Shop;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    use HasForbiddenMessageAndView,CanGetObject;

    public function create($object,$id)
    {
        $route=route('front.report.store',[$object,$id]);
        return [
            'view'=>\View::make('front.partial.ajax.report-form',compact('route'))->render()
        ];
    }

    public function store(Request $request,$object,$id)
    {
        $object=$this->getObject($object,$id);
        if($object->isReportedByAuth()){
            return $this->forbiddenMessage();
        }
        if($request->has('description')){
            $this->validate($request,[
                'description'=>'required'
            ]);
        }
        $request->merge(['user_id'=>auth()->id()]);
        $object->reports()->create($request->all());
        if($request->has('redirect')){
            setSession([
                'header'=>'گزارش تخلف یا خرابی',
                'message'=>'گزارش شما با موفقیت ثبت گردید.',
                'type'=>'success'
            ]);
            return [
                'url'=>back()->getTargetUrl()
            ];
        }
        return [
            'text'=>'گزارش شد'
        ];
    }

}
