<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\Setting;
use App\Http\Requests\Admin\Base\AboutRequest;

class AboutController extends Controller
{

    public function index()
    {
        $items = [
            ["title" => "تنظیمات تماس با ما","link" => "#"]
        ];
        $data['objects'] = Setting::where('section', 'about')->orderBy('position')->get();
        if (!isset($data['objects'])) {
            $data['objects'] = false;
        }
        return view('admin.pages.setting.about', compact('items','data'));
    }

    public function update(AboutRequest $request, Setting $setting)
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
