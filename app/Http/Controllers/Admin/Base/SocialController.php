<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\Setting;
use App\Http\Requests\Admin\Base\SocialRequest;

class SocialController extends Controller
{

    public function index()
    {
        $items = [
            ["title" => "تنظیمات شبکه های اجتماعی","link" => "#"]
        ];
        $data['objects'] = Setting::where('section', 'social')->orderBy('position')->get();
        if (!isset($data['objects'])) {
            $data['objects'] = false;
        }
        return view('admin.pages.setting.social', compact('items','data'));
    }

    public function update(SocialRequest $request, Setting $setting)
    {
        $input = $request->all();
        foreach ($input as $name => $value) {
            $setting->where('name', $name)->update(['value' => $value]);
        }
        return redirect()->back()->with('msg', 'ویرایش با موفقیت انجام شد.');
    }
}
