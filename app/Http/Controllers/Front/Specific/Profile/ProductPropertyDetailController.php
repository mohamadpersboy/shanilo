<?php

namespace App\Http\Controllers\Front\Specific\Profile;

use App\Http\Controllers\Front\Base\ProfileController;
use App\Models\Specific\ProductProperty;
use App\Models\Specific\ProductPropertyDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductPropertyDetailController extends ProfileController
{
    public function store(Request $request)
    {
        $this->validate($request,[
            'product_property'=>'required|exists:product_properties,id',
            'value'=>'required|unique:product_property_details,title,NULL,id,product_property_id,'.$request->get('product_property')
        ]);
        $productProperty=ProductProperty::find($request->get('product_property'));
        if(!canEditProduct($productProperty->product)){
            abort(401);
        }
        $propertyDetail=$productProperty->details()->create([
            'title'=>$request->get('value')
        ]);
        return [
            'view'=>\View::make('front.partial.ajax.product-property-detail',compact('propertyDetail'))->render()
        ];
    }

    public function destroy(ProductPropertyDetail $productPropertyDetail)
    {
        if(!canEditProduct($productPropertyDetail->productProperty->product)){
            abort(401);
        }
        $productPropertyDetail->delete();
        return ['true'];
    }
}
