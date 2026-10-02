<?php

namespace App\Http\Controllers\Front\Specific\Profile;

use App\Http\Helpers\Payment\MellatPayment;
use App\Models\Base\PayType;
use App\Models\Specific\Plan;
use App\Models\Specific\SpecialSuggestion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FirstPageSpecialSuggestionController extends Controller
{
    public function create(SpecialSuggestion $specialSuggestion)
    {
        if (!canEditProduct($specialSuggestion->productDetail->product)) {
            abort(404);
        }
        if ($specialSuggestion->inFirstPage()) {
            return response()->json(['errors' => ['message' => ['این محصول در حال حاضر در صفحه اول می باشد در صورت نیاز به تغییر تعرفه ابتدا محصول را از لیست پیشنهادات ویژه حذف نمایید.']]], 422);
        }
        $data = [
            'route' => route('front.profile.firstPageSpecialSuggestion.store'),
            'suggestion' => $specialSuggestion,
            'plans' => Plan::visible()->orderBy('position')->get(),
            'payTypes'=>PayType::orderBy('position')->get()
        ];
        return [
            'view' => \View::make('front.partial.ajax.plans-modal', $data)->render()
        ];
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'plan_id' => 'required|exists:plans,id',
            'suggestion_id' => 'required|exists:special_suggestions,id',
            'suggestion_sid' => 'required|check_hash:'.$request->get('suggestion_id'),
            'pay_type_id'=>'required|exists:pay_types,id'
        ], [
            'plan_id.*' => 'اطلاعات دریافت شده نامعتبر است.',
            'suggestion_id.*' => 'اطلاعات دریافت شده نامعتبر است.',
            'suggestion_sid.*' => 'اطلاعات دریافت شده نامعتبر است.',
        ],[
            'pay_type_id'=>'شیوه پرداخت'
        ]);
        $className=PayType::find($request->get('pay_type_id'))->class_name;
        $specialSuggestion=SpecialSuggestion::find($request->get('suggestion_id'));
        $plan=Plan::find($request->get('plan_id'));
        return (new $className())->payFirstPageSpecialSuggestion($specialSuggestion,$plan);
    }

    public function verify(Request $request)
    {
       return (new MellatPayment())->verifyFirstPageSpecialSuggestion($request);
    }


}
