<?php

namespace App\Http\Controllers\Front\Specific\Profile;

use App\Http\Controllers\Front\Base\ProfileController;
use App\Http\Requests\Front\Specific\ShopRequest;
use App\Models\Base\City;
use App\Models\Specific\Order;
use App\Models\Base\SendType;
use App\Models\Base\State;
use App\Models\Base\User;
use App\Models\Specific\Shop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ShopController extends ProfileController
{
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Shops
    # Handles shop operations from user dashboard
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#

    const THUMBNAILS_SIZE = ['1200/500', '350/160', '255/100', '278/180', '60/60'];

    public function index()
    {
        $data = [
            'pageTitle' => 'پروفایل من | لیست فروشگاه ها',
            'user' => \Auth::user(),
            'activeMenu' => 'shops',
            'shops' => \Auth::user()->shops()->visible()->orderBy('created_at', 'desc')->get()
        ];
        return view('front.pages.profile.shop.index', $data);
    }

    public function create()
    {
        $data = [
            'pageTitle' => 'پروفایل من | ایجاد فروشگاه',
            'user' => \Auth::user(),
            'activeMenu' => 'shops',
            'sendTypes' => SendType::visible()->orderBy('position')->get()
        ];
        return view('front.pages.profile.shop.create', $data);
    }

    public function store(ShopRequest $request)
    {
        \DB::beginTransaction();
        $request->merge(['user_id' => \Auth::id()]);
        /** @var Shop $shop */
        $shop = Shop::query()->create($request->all());
        $cities = $request->get('cities') ?: City::whereHas('state')->pluck('id')->toArray();
        $shop->cities()->sync($cities);
        if ($request->has('background')) {
            $shop->createImage($request->file('background'), 'background', $request->get('cropper'), self::THUMBNAILS_SIZE);
        }
        $sendTypes = $request->get('send_types');
        $shop->sendTypes()->attach($sendTypes);
        setSession([
            'header' => 'افزودن فروشگاه',
            'message' => 'فروشگاه شما با موفقیت ثبت گردید.',
            'type' => 'success'
        ], 'notification');
        \DB::commit();
        return [
            'url' => route('front.profile.shop.index')
        ];
    }

    public function edit(Shop $shop)
    {
        if (!canEditShop($shop)) {
            abort(404);
        }
        $data = [
            'pageTitle' => 'پروفایل من | ویرایش فروشگاه',
            'user' => \Auth::user(),
            'activeMenu' => 'shops',
            'shop' => $shop,
            'edit' => true,
            'sendTypes' => SendType::visible()->orderBy('position')->get(),
            'shopSendTypes' => $shop->sendTypes()->pluck('id')->toArray()
        ];
        return view('front.pages.profile.shop.edit', $data);
    }

    public function update(ShopRequest $request, Shop $shop)
    {
        if (!canEditShop($shop)) {
            abort(403);
        }
        $reditect = false;
        $shop->update($request->all());
        $sendTypes = $request->get('send_types');
        $shop->sendTypes()->attach($sendTypes);
        if ($file = $request->file('background')) {
            $reditect = true;
            $shop->updateImage($file, 'background', $request->get('cropper'), self::THUMBNAILS_SIZE);
        }
        if ($reditect) {
            setSession([
                'header' => 'ویرایش فروشگاه',
                'message' => 'اطلاعات فروشگاه با موفقیت ویرایش گردید.',
                'type' => 'success'
            ], 'notification');
            return [
                'url' => back()->getTargetUrl()
            ];
        }

        return response()->json([
            'header' => 'ویرایش فروشگاه',
            'message' => 'اطلاعات فروشگاه با موفقیت ویرایش گردید.',
            'type' => 'success'
        ]);
    }

    public function destroy(Shop $shop)
    {
        if (!canEditShop($shop)) {
            abort(404);
        }
        if (env('APP_SOFT_DELETES')) {
            $shop->delete();
        } else {
            $shop->forceDelete();
        }
        if (\Auth::user()->shops->count()) {
            return [
                'deletedItem' => "#shop-{$shop->id}"
            ];
        } else {
            return [
                'url' => back()->getTargetUrl()
            ];
        }

    }

    public function clients(Shop $shop)
    {
        $objects = User::whereHas('orders', function (Builder $builder) use ($shop) {
            $builder->where(['shop_id' => $shop->id, 'show_as_customer' => 1]);
        })->get();
        return [
            'view' => \View::make('front.partial.ajax.followers-modal', compact('objects'))->render()
        ];
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Extra actions
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#

    public function getCoveredStates(Shop $shop)
    {
        if (!canEditShop($shop)) {
            abort(404);
        }
        $data = [
            'shop' => $shop,
            'states' => State::visible()->whereHas('cities')->orderBy('name')->get(),
            'shopStates' => State::whereHas('cities', function (Builder $builder) use ($shop) {
                $builder->whereIn('id', $shop->cities()->pluck('id')->toArray());
            })->pluck('id')->toArray()
        ];
        return [
            'view' => \View::make('front.partial.ajax.shop-states', $data)->render()
        ];
    }

    public function getCoveredCities(Shop $shop)
    {
        if (!canEditShop($shop)) {
            abort(404);
        }
        $data = [
            'shop' => $shop,
            'states' => State::visible()->whereHas('cities')->orderBy('name')->get(),
        ];
        return [
            'view' => \View::make('front.partial.ajax.shop-cities', $data)->render()
        ];
    }

    public function getCoveredCitiesList(Shop $shop, State $state)
    {
        if (!canEditShop($shop)) {
            abort(404);
        }
        $data = [
            'shop' => $shop,
            'state' => $state,
            'cities' => $state->cities()->orderBy('name')->get(),
            'shopCities' => $shop->cities()->pluck('city_shop.price', 'id')->toArray(),
        ];
        return [
            'view' => \View::make('front.partial.ajax.shop-cities-list', $data)->render()
        ];
    }

    public function setCoveredStates(Shop $shop, Request $request)
    {
        $states = $request->get('states') ?: [];
        $data = [];
        foreach ($states as $index => $state) {
            $cities = State::findOrFail($state)->cities;
            foreach ($cities as $city) {
                $price = $request->get('price_' . $state);
                if (!$price && $price !== "0") {
                    $currentCities = $shop->cities()->where('state_id', $state)->get();
                    foreach ($currentCities as $index => $currentCity) {
                        $data[$currentCity->id] = ['price' => $currentCity->pivot->price];
                    }
                } else {
                    $data[$city->id] = ['price' => str_replace(',', '', $price)];
                }

            }
        }
        $shop->cities()->sync($data);
        return [
            'type' => 'success',
            'header' => 'ثبت استانهای تحت پوشش',
            'message' => 'تغییرات با موفقیت اعمال گردید.'
        ];
    }

    public function setCoveredCities(Shop $shop, State $state, Request $request)
    {
        $detachableCities = $state->cities()->pluck('id')->toArray();
        $shop->cities()->detach($detachableCities);
        $data = [];
        $cities = $request->get('cities') ?: [];
        foreach ($cities as $index => $city) {
            $data[$city] = [
                'price' => str_replace(',', '', $request->get('price_' . $city))
            ];
        }
        $shop->cities()->attach($data);
        return [
            'type' => 'success',
            'header' => 'ثبت شهرهای تحت پوشش',
            'message' => 'تغییرات با موفقیت اعمال گردید.'
        ];
    }
}
