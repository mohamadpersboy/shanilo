<?php

namespace App\Http\Controllers\Admin\Base;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (\Session::get('lang') != null){
                \App::setLocale(\Session::get('lang'));
            }
            return $next($request);
        });
    }
    public function index()
    {
        $header['list'] = ["title" => __('content.my_profile'),"description" => __('messages.change_profile')];

        return view('admin.pages.home.index', compact('header'));
    }
}
