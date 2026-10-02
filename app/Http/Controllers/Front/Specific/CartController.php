<?php

namespace App\Http\Controllers\Front\Specific;

use App\Http\Helpers\Cart\Facade\Cart;
use App\Models\Base\PayType;
use App\Models\Base\SendType;
use App\Models\Base\State;
use App\Models\Specific\CartDetail;
use App\Models\Specific\CartDetailProduct;
use App\Models\Specific\Order;
use App\Models\Specific\ProductDetail;
use App\Models\Specific\ProductPropertyDetail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{

    public function __construct()
    {
        $this->middleware(['check.exists.product'])->only(['step1','step2', 'step3', 'step4', 'step5', 'step6']);
    }
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Steps
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function step1()
    {
        $data = [
            'pageTitle' => 'سبد خرید',
            'activeMenu' => 1,
            'checked' => []
        ];
        return view('front.pages.cart.step1', $data);
    }

    public function step2(CartDetail $cartDetail)
    {
        $this->checkIfCartBelongsToUser($cartDetail);
        $data = [
            'pageTitle' => 'ورود / عضویت',
            'activeMenu' => 2,
            'checked' => [1],
            'cartDetail' => $cartDetail
        ];
        if (auth()->check()) {
            return redirect()->route('front.cart.step3', $cartDetail);
        } else {
            return view('front.pages.cart.step2', $data);
        }
    }

    public function step3(CartDetail $cartDetail)
    {
        $this->checkIfCartBelongsToUser($cartDetail);
        if (!$cartDetail->details()->count()) {
            return $this->step1();
        }
        if ($cartDetail->shop->user_id == auth()->id()) {
            return $this->userCannotOrderFromThemShop($cartDetail);
        }
        $states = State::visible()->orderBy('name')->get();
        $addresses = \Auth::user()->addresses;
        $data = [
            'pageTitle' => 'اطلاعات پستی گیرنده',
            'activeMenu' => 3,
            'checked' => [1, 2],
            'states' => $states,
            'addresses' => $addresses,
            'cartDetail' => $cartDetail
        ];
        return view('front.pages.cart/step3', $data);
    }

    public function step4(CartDetail $cartDetail)
    {
        $this->checkIfCartBelongsToUser($cartDetail);
        if (!$cartDetail->address_id) {
            return $this->cartMustHaveAddressMessage($cartDetail);
        }
        $data = [
            'pageTitle' => 'نحوه ارسال سفارش',
            'activeMenu' => 4,
            'checked' => [1, 2, 3],
            'cartDetail' => $cartDetail,
            'sendTypes' => SendType::visible()->whereHas('shops', function (Builder $builder) use ($cartDetail) {
                $builder->where('id', $cartDetail->shop_id);
            })->orderBy('position')->get()
        ];
        return view('front.pages.cart.step4', $data);
    }

    public function step5(CartDetail $cartDetail)
    {
        $this->checkIfCartBelongsToUser($cartDetail);
        if (!$cartDetail->address_id) {
            return $this->cartMustHaveAddressMessage($cartDetail);
        }
        if (!$cartDetail->send_type_id) {
            return $this->cartMustHaveSendTypeMessage($cartDetail);
        }
        $data = [
            'pageTitle' => 'باز بینی سفارش',
            'activeMenu' => 5,
            'checked' => [1, 2, 3, 4],
            'cartDetail' => $cartDetail,
        ];
        return view('front.pages.cart.step5', $data);
    }

    public function step6(CartDetail $cartDetail)
    {
        $this->checkIfCartBelongsToUser($cartDetail);
        if (!$cartDetail->address_id) {
            return $this->cartMustHaveAddressMessage($cartDetail);
        }
        if (!$cartDetail->send_type_id) {
            return $this->cartMustHaveSendTypeMessage($cartDetail);
        }
        $data = [
            'pageTitle' => 'انتخاب نحوه پرداخت',
            'activeMenu' => 6,
            'checked' => [1, 2, 3, 4, 5],
            'cartDetail' => $cartDetail,
            'payTypes' => PayType::visible()->orderBy('position')->get()
        ];
        return view('front.pages.cart.step6', $data);
    }




    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Actions
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function updateCount(CartDetailProduct $cartDetailProduct, Request $request)
    {
        $this->validate($request, [
            'count' => 'required|numeric|min:1|max:' . $cartDetailProduct->productDetail->count
        ], [
            'count.max' => 'تعداد انتخاب محصول بیشتر از حد مجاز است.',
        ], []);
        $cartDetailProduct->update([
            'count' => $request->get('count')
        ]);
        return [
            'total_cart_price' => showPrice($cartDetailProduct->cartDetail->total(true), null, null),
            'total_product_price' => showPrice($cartDetailProduct->count * $cartDetailProduct->productDetail->pure_price),
            'view' => \View::make('front.partial.parts.cart')->render()
        ];
    }

    public function toggle(ProductDetail $productDetail, Request $request)
    {
        $added = true;
        if (Cart::has($productDetail)) {
            Cart::remove($productDetail);
            $added = false;
        } else {
            $this->validator($productDetail, $request);
            $this->addProperties($productDetail, $request);
            Cart::add($productDetail);
        }
        return [
            'view' => \View::make('front.partial.parts.cart')->render(),
            'count' => Cart::count(),
            'text' => $added ? 'حذف از سبد خرید' : 'افزودن به سبد خرید',
            'method' => $added ? 'addClass' : 'removeClass'
        ];
    }

    public function destroy(ProductDetail $productDetail)
    {
        Cart::remove($productDetail);
        return [
            'url' => back()->getTargetUrl()
        ];
    }

    /**
     * @param ProductDetail $productDetail
     * @param Request $request
     */
    protected function validator(ProductDetail $productDetail, Request $request)
    {
        $properties = $productDetail->product->properties;
        $rules = [];
        $attributes = [];
        foreach ($properties as $index => $property) {
            $rules["properties.{$index}"] = "required|in:" . implode(',', $property->details()->pluck('id')->toArray());
            $attributes["properties.{$index}"] = $property->title;
        }
        $this->validate($request, $rules, [], $attributes);
    }

    /**
     * @param ProductDetail $productDetail
     * @param Request $request
     */
    protected function addProperties(ProductDetail &$productDetail, Request $request)
    {
        $propertyDetails = ProductPropertyDetail::whereIn('id', $request->get('properties') ?: [])->get();
        $properties = [];
        foreach ($propertyDetails as $propertyDetail) {
            $properties[$propertyDetail->productProperty->title] = $propertyDetail->title;
        }
        $productDetail->properties = $properties;
    }

    /**
     * @param CartDetail $cartDetail
     */
    protected function checkIfCartBelongsToUser(CartDetail $cartDetail)
    {
        if ($cartDetail->cart_id != Cart::get()->id) {
            abort(404);
        }
    }

    public function updateShowAsCustomer(Request $request, CartDetail $cartDetail)
    {
        if (Cart::get()->id != $cartDetail->cart_id) {
            abort(404);
        }
        $cartDetail->update([
            'show_as_customer' => $request->get('show_as_customer')
        ]);
        return [
            'true'
        ];
    }

    public function updateField(Request $request, CartDetail $cartDetail)
    {
        $this->checkIfCartBelongsToUser($cartDetail);
        $this->validate($request, [
            'field' => 'required',
            'value' => 'required'
        ]);
        $data = [
            $request->get('field') => $request->get('value')
        ];
        if ($request->get('field') == 'send_type_id') {
            if ($request->get('value') == 1) {
                if ($city = $cartDetail->shop->cities()->where('id', $cartDetail->address->city_id)->first()) {
                    $data['transport_price'] = $city->pivot->price;
                } else {
                    return response()->json(['errors' => ['message' => ['متاسفانه این فروشگاه به شهر انتخاب شده ارائه خدمات ندارد.']]], 422);
                }
            } else {
                if ($cartDetail->details()->whereHas('productDetail', function (Builder $builder) {
                    $builder->where('weight', '>', 50);
                })->count()) {
                    return response()->json(['errors' => ['message' => ['کالاهای بالای 50 کیلوگرم از طریق پست قابل ارسال نمی باشند.']]], 422);
                }
                $sendType = SendType::find($request->get('value'));
                $data['transport_price'] = $cartDetail->calculateTransportPrice($sendType);
            }
        }
        $cartDetail->update($data);
        return ['true'];
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Step warning messages
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected function cartMustHaveAddressMessage(CartDetail $cartDetail)
    {
        setSession([
            'header' => 'اخطار',
            'type' => 'warning',
            'message' => 'قبل از ادامه می بایست یک آدرس انتخاب نمایید.'
        ]);
        return $this->step3($cartDetail);
    }

    protected function cartMustHaveSendTypeMessage(CartDetail $cartDetail)
    {
        setSession([
            'header' => 'اخطار',
            'type' => 'warning',
            'message' => 'قبل از ادامه می بایست نحوه ارسال سفارش را انتخاب نمایید.'
        ]);
        return $this->step4($cartDetail);
    }

    protected function userCannotOrderFromThemShop(CartDetail $cartDetail)
    {
        $cartDetail->delete();
        setSession([
            'header' => 'اخطار',
            'type' => 'warning',
            'message' => 'شما نمی توانید از فروشگاه خود سفارش دهید.'
        ]);
        return $this->step1();
    }

    //
    protected function fakeOrder($cartDetail)
    {

    }
}
