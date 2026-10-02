<?php

namespace App\Http\Controllers\Front\Specific;

use App\Http\Helpers\Comparison\Facade\Comparison;
use App\Models\Specific\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ComparisonController extends Controller
{
    public function index()
    {
        $data = [
            'pageTitle' => 'لیست مقایسه محصولات'
        ];
        return view('front.pages.comparison.index', $data);
    }

    public function toggle(Product $product)
    {
        if (!$product->productCategoryTechnicalSpecifications->count()) {
            return response()->json(['errors' => ['message' => ['این محصول هیچ مشخصه فنی جهت مقایسه ندارد.']]], 422);
        }
        $added=true;
        $deletedItems=[];
        if (Comparison::has($product)) {
            Comparison::remove($product);
            $added=false;
        } else {
            $deletedItems=Comparison::add($product);
            foreach ($deletedItems as $deletedItem){
                $deletedItem->toggleUrl=route('front.comparison.toggle',$deletedItem->product_id);
                $deletedItem->text='افزودن به لیست مقایسه';
                $deletedItem->method='removeClass';
            }
        }
        return $this->response($added,$product,$deletedItems);
    }

    public function destroy(Product $product)
    {
        Comparison::remove($product);
        return $this->response(false,$product);
    }

    protected function response($added,$product,$deleteItems=[]){
        return [
            'view' => \View::make('front.partial.ajax.comparison')->render(),
            'count' => Comparison::count(),
            'method'=>$added?'addClass':'removeClass',
            'text'=>$added?'حذف از مقایسه':'افزودن به لیست مقایسه',
            'toggleUrl'=>route('front.comparison.toggle',$product),
            'deletedItems'=>$deleteItems,
            'redirect'=>back()->getTargetUrl()==url('/comparison'),
        ];
    }

}
