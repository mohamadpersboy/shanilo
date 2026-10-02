<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\Setting;
use App\Http\Requests\Admin\Base\MobilePreOrderRequest;

class MobilePreOrderController extends Controller
{

    public function index()
    {
        $items = [
            ["title" => "پیش شماره های موبایل","link" => "#"]
        ];
        $data['objects'] = Setting::where('section', 'mobile')->orderBy('position')->get();
        if (!isset($data['objects'])) {
            $data['objects'] = false;
        }
        return view('admin.pages.setting.mobile', compact('items','data'));
    }

    public function update(MobilePreOrderRequest $request, Setting $setting)
    {
        $input = $request->all();
        foreach ($input as $name => $value) {
            $setting->where('name', $name)->update(['value' => $value]);
        }
        return redirect()->back()->with('msg', 'ویرایش با موفقیت انجام شد.');
    }
}
