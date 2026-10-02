<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\Base\AppLinkRequest;
use App\Models\Base\Setting;

class AppLinkController extends Controller
{

    public function index()
    {
        $items = [
            ["title" => "تنظیمات لینک اپلیکیشن و انجمن","link" => "#"]
        ];
        $data['objects'] = Setting::where('section', 'applink')->orderBy('position')->get();
        if (!isset($data['objects'])) {
            $data['objects'] = false;
        }
        return view('admin.pages.setting.applink', compact('items','data'));
    }

    public function update(AppLinkRequest $request, Setting $setting)
    {
        $input = $request->all();
        foreach ($input as $name => $value) {
            $setting->where('name', $name)->update(['value' => $value]);
        }
        return redirect()->back()->with('msg', 'ویرایش با موفقیت انجام شد.');
    }
}
