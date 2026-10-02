<?php

namespace App\Http\Controllers\Front\Specific;

use App\Http\Helpers\Favorite\Facade\Favorite;
use App\Models\Specific\ProductDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FavoriteController extends Controller
{
    public function destroy(ProductDetail $productDetail)
    {
        Favorite::remove($productDetail);
        setSession([
            'header'=>'حذف محصول از علاقه مندی',
            'message'=>'محصول با موفقیت از لیست علاقه مندی حذف گردید.',
            'type'=>'success'
        ]);
        return [
            'url'=>back()->getTargetUrl()
        ];
    }

    public function toggle(ProductDetail $productDetail)
    {
        if(Favorite::has($productDetail)){
            Favorite::remove($productDetail);
            return [
                'view'=>\View::make('front.partial.ajax.favorites-list')->render(),
                'count'=>Favorite::count(),
                'method'=>'removeClass',
                'class'=>'active',
                'text'=>'افزودن به علاقه مندی'
            ];
        }else{
            Favorite::add($productDetail);
            return [
                'view'=>\View::make('front.partial.ajax.favorites-list')->render(),
                'count'=>Favorite::count(),
                'method'=>'addClass',
                'class'=>'active',
                'text'=>'موجود در علاقه مندی'
            ];
        }
    }
}
