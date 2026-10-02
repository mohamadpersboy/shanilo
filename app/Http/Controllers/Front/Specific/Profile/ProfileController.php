<?php

namespace App\Http\Controllers\Front\Specific\Profile;

use \App\Http\Controllers\Front\Base\ProfileController as ParentProfileController;
use App\Models\Base\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Specific\ProfileRequest;

class ProfileController extends ParentProfileController
{
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Profile
    # Handles profile edition in users dashboard
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function index()
    {
        $data = [
            'breadcrumbs' => [
                'active' => 'پروفایل من'
            ],
            'user' => \Auth::user(),
            'activeMenu' => 'index',
            'pageTitle' => 'پروفایل من',
        ];
      
        return view('front.pages.profile.index', $data);
    }

    public function update(ProfileRequest $request)
    {

        $request->merge(['show_info'=>$request->has('show_info')]);
        $redirect = false;
        $user = \Auth::user();
        if ($request->get('mobile') != $user->mobile) {
            $user->confirm = 0;
            $user->save();
            $redirect = true;
        }
        if ($request->get('birth_year') && $request->get('birth_month') && $request->get('birth_day')) {
            $date = $request->get('birth_year') . '/' . $request->get('birth_month') . '/' . $request->get('birth_day');
            $date = jalaliToCarbon($date);
            $request->merge(['birth_date' => $date]);
        }
        $user->update($request->all());
        if ($redirect) {
            setSession([
                'message' => 'اطلاعات کاربری با موفقیت ویرایش گردید.',
                'type' => 'success',
                'header' => 'ویرایش پروفایل'
            ], 'notification');
            return [
                'url' => back()->getTargetUrl()
            ];
        } else {
            return [
                'message' => 'اطلاعات کاربری با موفقیت ویرایش گردید.',
                'type' => 'success',
                'header' => 'ویرایش پروفایل'
            ];
        }
    }



}
