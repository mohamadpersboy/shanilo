<?php

namespace App\Http\Controllers\Front\Base;

use App\Http\Controllers\Controller;
use App\Models\Base\Contact;
use Illuminate\Http\Request;

use App\Models\Base\ContactUs;
use App\Http\Requests\Front\Base\ContactRequest;
use App\Mail\EmailRequest;

use Mail;

class ContactController extends Controller
{
    public function index()
    {
        $data = [
            "breadcrumbs" => [
                'active'=>'تماس با ما',
            ],
            'pageTitle'=>'تماس باما',
            'activeMenu'=>'contact',
            'contact'=>Contact::visible()->first()
        ];

        return view('front.pages.contact.index',$data);
    }

    public function create()
    {
        $data=[
            'pageTitle'=>'ارسال ایمیل',
            'breadcrumbs'=>[
                'active'=>'ارسال ایمیل'
            ]
        ];
        return view('front.pages.contact.create',$data);
    }

    public function store(ContactRequest $request)
    {
        ContactUs::create($request->all());
        if($request->input('email')){
            Mail::to($request->input('email'))->send(new EmailRequest);
        }
        return response()->json([
            'message'=>'پیغام شما با موفقیت ارسال گردید.',
            'header'=>'ارسال پیغام موفق',
            'type'=>'success'
        ]);
    }
}
