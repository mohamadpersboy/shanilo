<?php

namespace App\Http\Controllers\Front\Specific\Profile;

use App\Events\ProductAdded;
use App\Events\ProductCountChanged;
use App\Events\ProductHasOff;
use App\Http\Controllers\Front\Base\ProfileController;
use App\Http\Requests\Front\Specific\ProductDetailRequest;
use App\Models\Base\Color;
use App\Models\Specific\Product;
use App\Models\Specific\ProductDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class ProductDetailController extends ProfileController
{

    public function create(Product $product)
    {
        if (!canEditProduct($product)) {
            abort(404);
        }
        $data = [
            'user' => \Auth::user(),
            'product' => $product,
            'activeMenu' => 'products',
            'colors' => Color::visible()->where('code','!=','#00NANNAN')->orderBy('title')->get(),
            'noColor'=>Color::visible()->where('code','#00NANNAN')->first()
        ];
        return view('front.pages.profile.product_detail.create', $data);
    }

    public function store(ProductDetailRequest $request, Product $product)
    {
        if (!canEditProduct($product)) {
            abort(404);
        }
        $productDetail = $product->details()->create($request->all());
        $this->checkIndexFields($productDetail);
        return [
            'header' => 'ثبت زیر محصول موفق',
            'message' => 'زیر محصول با موفقیت ثبت شد.',
            'type' => 'success'
        ];
    }

    public function edit(ProductDetail $productDetail)
    {
        if (!canEditProduct($productDetail->product)) {
            abort(404);
        }
        $data = [
            'user' => \Auth::user(),
            'product' => $productDetail->product,
            'productDetail' => $productDetail,
            'edit' => true,
            'activeMenu' => 'products',
            'colors' => Color::visible()->where('code','!=','#00NANNAN')->orderBy('title')->get(),
            'noColor'=>Color::visible()->where('code','#00NANNAN')->first()
        ];
        return view('front.pages.profile.product_detail.edit', $data);
    }

    public function update(ProductDetailRequest $request, ProductDetail $productDetail)
    {
        if (!canEditProduct($productDetail->product)) {
            abort(404);
        }

        $oldCount=$productDetail->count;
        $oldDiscount=$productDetail->discount;

        $productDetail->update($request->all());
        $this->checkIndexFields($productDetail->fresh());

        if (!$oldCount && $request->get('count')) {
            event(new ProductCountChanged($productDetail));
        }
        if ($request->get('discount') != $oldDiscount) {
            event(new ProductHasOff($productDetail));
        }
        return [
            'header' => 'ویرایش  زیر محصول موفق',
            'message' => 'زیر محصول با موفقیت ویرایش شد.',
            'type' => 'success'
        ];
    }

    public function destroy(ProductDetail $productDetail)
    {
        if (!canEditProduct($productDetail->product)) {
            abort(404);
        }
        if (env('APP_SOFT_DELETES')) {
            $productDetail->delete();
        } else {
            $productDetail->forceDelete();
        }
        if ($productDetail->brothers()->count()) {
            return [
                'deletedItem' => "#productDetail-{$productDetail->id}"
            ];
        } else {
            return [
                'url' => back()->getTargetUrl()
            ];
        }

    }

    public function setAsIndex(ProductDetail $productDetail)
    {
        if (!canEditProduct($productDetail->product)) {
            abort(404);
        }
        $productDetail->update(['index' => 1]);
        $productDetail->brothers()->update(['index' => 0]);
        return [
            'header' => 'انتخاب شاخص',
            'message' => 'محصول به عنوان شاخص انتخاب گردید.',
            'type' => 'success'
        ];
    }

    /**
     * @param ProductDetail $productDetail
     */
    protected function checkIndexFields(ProductDetail $productDetail)
    {
        if ($productDetail->index) {
            $productDetail->brothers()->update(['index' => 0]);
        }
        if (!$productDetail->index && !$productDetail->brothers()->index()->count()) {
            if ($productDetail->brothers()->count()) {
                $productDetail->brothers()->first()->update(['index' => 1]);
            } else {
                $productDetail->index = 1;
                $productDetail->save();
            }
        }
    }
}
