<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\Setting;

class SiteContentController extends Controller
{

    public function index()
    {
        $items = [
            ["title" => "تنظیمات متن های سایت","link" => "#"]
        ];
        $data['objects'] = Setting::where('section', 'sitecontent')->orderBy('position')->get();
        if (!isset($data['objects'])) {
            $data['objects'] = false;
        }
        return view('admin.pages.setting.sitecontent', compact('items','data'));
    }

    public function update(Request $request, Setting $setting)
    {
        $input = $request->all();
        if($request->has('lat')){
            $input['latlong'] = $input['lat'] . ',' . $input['long'];
        }
        foreach ($input as $name => $value) {
            $setting->where('name', $name)->update(['value' => $value]);
        }
        return redirect()->back()->with('msg', 'ویرایش با موفقیت انجام شد.');
    }
}
