<?php

namespace App\Http\Controllers\Front\Specific\Profile;

use App\Models\Specific\ProductDetail;
use App\Models\Specific\SpecialSell;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpecialSellController extends Controller
{
    public function store(Request $request,ProductDetail $productDetail)
    {
        if(!canEditProduct($productDetail->product)){
            abort(404);
        }
        if($productDetail->specialSell){
            return response()->json(['errors'=>['message'=>['این محصول در حال حاضر در پیشنهادات ویژه ثبت شده است.']]],422);
        }
        $productDetail->specialSell()->create();
        setSession([
            'header' => 'افزودن محصول به فروش ویژه',
            'message' => 'محصول با موفقیت به لیست فروش ویژه اضافه گردید.',
            'type' => 'success'
        ], 'notification');
        return [
            'url'=>back()->getTargetUrl()
        ];
    }

    public function destroy(SpecialSell $specialSell)
    {
        if(!canEditProduct($specialSell->productDetail->product)){
            abort(404);
        }
        $specialSell->delete();
        setSession([
            'header' => 'حذف فروش ویژه',
            'message' => 'محصول با موفقیت از فروش ویژه حذف گردید.',
            'type' => 'success'
        ]);
        return [
            'url'=>back()->getTargetUrl()
        ];
    }
}
