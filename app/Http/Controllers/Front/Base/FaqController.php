<?php

namespace App\Http\Controllers\Front\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Base\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::visible()->orderBy('position')->get();

        $data = [
            'breadcrumbs'=>[
                'active'=>'پرسش و پاسخ متداول'
            ],
            'pageTitle'=>'پرسش و پاسخ متداول',
            "faqs" => $faqs,
        ];
        return view('front.pages.faq.index',$data);
    }
}
