<?php

namespace App\Http\Controllers\Front\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Base\Policy;

class PolicyController extends Controller
{
    public function index()
    {
        $data = [
            "breadcrumbs"=>[
                'active'=>'قوانین و سیاست ها'
            ],
            'pageTitle'=>'قوانین و سیاست ها',
            "policies" => Policy::visible()->orderBy('position')->get(),
        ];
        return view('front.pages.policy.index',$data);
    }
}
