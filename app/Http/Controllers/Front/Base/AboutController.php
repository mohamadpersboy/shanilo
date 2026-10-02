<?php

namespace App\Http\Controllers\Front\Base;

use App\Http\Controllers\Controller;
use App\Models\Base\AboutUs;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $data=[
            'breadcrumbs'=>[
                'active'=>'درباره ما'
            ],
            'activeMenu' => 'about',
            'pageTitle'=>'درباره ما',
            'about'=>AboutUs::visible()->first(),
        ];
        return view('front.pages.about.index',$data);
    }
}
