<?php

namespace App\Http\Controllers\Front\Specific\Profile;

use App\Http\Controllers\Front\Base\ProfileController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Specific\AddressRequest;
use App\Models\Base\Address;
use App\Models\Base\State;
use Illuminate\Database\Eloquent\Builder;

class AddressController extends ProfileController
{
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Addresses
    # Handles address operations in front user profile
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function index()
    {
        $data = [
            'user' => $user = \Auth::user(),
            'activeMenu' => 'addresses',
            'pageTitle' => 'پروفایل من',
            'breadcrumbs' => [
                'active' => 'اطلاعات پستی',
            ],
            'addresses' => \Auth::user()->addresses()->orderBy('created_at', 'desc')->get(),
            'states' => State::visible()->orderBy('name')->get(),
        ];

        return view('front.pages.profile.address.index', $data);
    }

    public function store(AddressRequest $request)
    {
         \Auth::user()->addresses()->create($request->all());
         setSession([
             'header'=>'افزودن آدرس',
             'type'=>'success',
             'message'=>'آدرس جدید با موفقیت ثبت شد.'
         ]);
        return [
            'url'=>back()->getTargetUrl()
        ];
    }

    public function create()
    {
        $data = [
            'states' => State::whereHas('cities', function (Builder $builder) {
                $builder->whereHas('send_types');
            })->orderBy('name')->get(),
        ];
        return [
            'view' => \View::make('front.partial.ajax.create-address', $data)->render()
        ];
    }

    public function edit(Address $address)
    {
        if (\Auth::id() != $address->user_id) {
            abort(404);
        }
        $data = [
            'address' => $address,
            'edit' => true,
            'states' => State::whereHas('cities')->orderBy('name')->get(),
            'cities' => $address->state->cities()->whereHas('send_types')->orderBy('name')->get()
        ];
        return [
            'view' => \View::make('front.partial.ajax.edit-address', $data)->render()
        ];
    }

    public function update(AddressRequest $request, Address $address)
    {
        $address->update($request->all());
        setSession([
            'header' => 'ویرایش آدرس',
            'type' => 'success',
            'message' => 'آدرس با موفقیت ویرایش شد.'
        ], 'notification');
        return [
            'url' => back()->getTargetUrl()
        ];
    }

    public function destroy(Address $address)
    {
        if ($address->user_id != \Auth::id()) {
            abort(404);
        }
        $address->delete();
       if(!auth()->user()->addresses()->count()){
           return [
               'url'=>back()->getTargetUrl()
           ];
       }
        return ['deletedItem' => '#address-' . $address->id];
    }
}
