<?php

namespace App\Http\Controllers\Front\Specific\Profile;

use App\Http\Helpers\Payment\MellatPayment;
use App\Models\Base\PayType;
use App\Models\Specific\Plan;
use App\Models\Specific\SpecialSell;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class FirstPageSpecialSellController extends Controller
{
    public function create(SpecialSell $specialSell)
    {
        if (!canEditProduct($specialSell->productDetail->product)) {
            abort(404);
        }
        if ($specialSell->inFirstPage()) {
            return response()->json(['errors' => ['message' => ['این محصول در حال حاضر در صفحه اول می باشد در صورت نیاز به تغییر تعرفه ابتدا محصول را از لیست پیشنهادات ویژه حذف نمایید.']]], 422);
        }
        $data = [
            'route' => route('front.profile.firstPageSpecialSell.store'),
            'suggestion' => $specialSell,
            'plans' => Plan::visible()->orderBy('position')->get(),
            'payTypes' => PayType::orderBy('position')->get()
        ];
        return [
            'view' => \View::make('front.partial.ajax.plans-modal', $data)->render()
        ];
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'plan_id' => 'required|exists:plans,id',
            'suggestion_id' => 'required|exists:special_sells,id',
            'suggestion_sid' => 'required|check_hash:' . $request->get('suggestion_id')
        ], [
            'plan_id.*' => 'اطلاعات دریافت شده نامعتبر است.',
            'suggestion_id.*' => 'اطلاعات دریافت شده نامعتبر است.',
            'suggestion_sid.*' => 'اطلاعات دریافت شده نامعتبر است.',
        ], [
            'pay_type_id' => 'شیوه پرداخت'
        ]);
        $className = PayType::find($request->get('pay_type_id'))->class_name;
        $specialSell = SpecialSell::find($request->get('suggestion_id'));
        $plan = Plan::find($request->get('plan_id'));
        return (new $className())->payFirstPageSpecialSell($specialSell, $plan);
    }

    public function verify(Request $request)
    {
        return (new MellatPayment())->verifyFirstPageSpecialSell($request);
    }
}
