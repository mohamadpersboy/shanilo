<?php

namespace App\Http\Controllers\Front\Specific\Profile;

use App\Models\Specific\ProductDetail;
use App\Models\Specific\SpecialSuggestion;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SpecialSuggestionController extends Controller
{
    public function store(Request $request,ProductDetail $productDetail)
    {
        if(!canEditProduct($productDetail->product)){
            abort(404);
        }
        if($productDetail->specialSuggestion){
            return response()->json(['errors'=>['message'=>['این محصول در حال حاضر در پیشنهادات ویژه ثبت شده است.']]],422);
        }
        $productDetail->specialSuggestion()->create();
        setSession([
            'header' => 'افزودن محصول به پیشنهادات ویژه',
            'message' => 'محصول با موفقیت به لیست پیشنهادات ویژه اضافه گردید.',
            'type' => 'success'
        ], 'notification');
        return [
            'url'=>back()->getTargetUrl()
        ];
    }

    public function destroy(SpecialSuggestion $specialSuggestion)
    {
        if(!canEditProduct($specialSuggestion->productDetail->product)){
            abort(404);
        }
        $specialSuggestion->delete();
        setSession([
            'header' => 'حذف پیشنهاد ویژه',
            'message' => 'محصول با موفقیت از پیشنهادات ویژه حذف گردید.',
            'type' => 'success'
        ]);
        return [
            'url'=>back()->getTargetUrl()
        ];
    }
}
