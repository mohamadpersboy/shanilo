<?php

namespace App\Http\Controllers\Front\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Base\Newsletter;
use App\Http\Requests\Front\Base\NewsletterRequest;
use App\Mail\EmailNewsletter;

use Mail;

class NewsletterController extends Controller
{
    public function index()
    {
        $data=[
            'pageTitle'=>'عضویت در خبرنامه',
            'breadcrumbs'=>[
                'active'=>'عضویت در خبرنامه'
            ]
        ];
        return view('front.pages.newsletter.index',$data);
    }

    public function store(NewsletterRequest $request)
    {
        if($newsletter=Newsletter::where('email',$request->get('email'))->first()){
            $newsletter->update($request->all());
            return response()->json([
                'header'=>'ویرایش خبرنامه موفق',
                'message'=>"اطلاعات خبرنامه با موفقیت ویرایش شد.",
                'type'=>'success'
            ]);
        }else{
            $newsletter = Newsletter::create($request->all());
            $hash = md5($newsletter->id);
            $newsletter->update(['hashed' => $hash]);
            Mail::to($request->input('email'))->send(new EmailNewsletter($newsletter));
            return response()->json([
                'header'=>'ثبت نام موفق',
                'message'=>"شما با موفقیت در خبر نامه ".__('content.site_name')."  ثبت نام نمودید.",
                'type'=>'success'
            ]);
        }
    }

    function destroy($newsletter)
    {
        if(strlen($newsletter) > 10){
            $find = Newsletter::where('hashed', $newsletter)->get();
            if(isset($find) && $find->count()) {
                Newsletter::where('hashed', $newsletter)->delete();
            } else{
                return redirect()->route('front.home.index');
            }
        } else {
            Newsletter::find($newsletter)->delete();
        }
        \Session::flash('notification',[
            'type'=>'success',
            'message'=>'عضویت شما در خبرنامه وبسایت '.__('content.site_name').' لغو شد.',
            'header'=>'لغو عضویت'
        ]);
        return redirect()->route('front.home.index');
    }
}
