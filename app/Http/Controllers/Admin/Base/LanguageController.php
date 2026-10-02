<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;
use App;

class LanguageController extends Controller
{
    public function show($lang)
    {
        $lang_session = Session::put('lang', $lang);
        App::setLocale($lang);
        return redirect()->route('admin.home.index')->with($lang_session);
    }
}
