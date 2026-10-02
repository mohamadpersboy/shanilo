<?php

namespace App\Http\Controllers\Front\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Base\Guide;

class GuideController extends Controller
{
    public function index()
    {
        $guides = Guide::visible()->with('attachments')->orderBy('position')->get();
        $data = [
            "breadcrumbs"=>[
                'active'=>'راهنمای سایت'
            ],
            'activeMenu' => 'encyclopedia',
            "guides" => $guides,
        ];
        return view('front.pages.guide.index',$data);
    }
}
