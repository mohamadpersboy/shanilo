<?php

namespace App\Http\Controllers\Front\Specific;

use App\Models\Base\City;
use App\Models\Base\State;
use App\Models\Specific\Brand;
use App\Models\Specific\ProductCategory;
use App\Models\Specific\Shop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopController extends ProductShopArchiveController
{
    public function index()
    {
        $shops = Shop::query()->has('products','>',0)->filter();

        $limit = \request()->get('limit') ?: 12;
        $data = $this->setData([
            'pageTitle' => 'آرشیو فروشگاهها',
            'limit' => $limit,
            'shops' => $shops->offset(0)->limit($limit)->get(),
            'hasMorePage' => $shops->offset($limit)->limit($limit)->get()->count(),
        ]);
        return view('front.pages.shop.index', $data);
    }


}
