<?php

namespace App\Http\Controllers\Admin\Specific;

use App\Grid\Admin\Specific\ShopGrid;
use App\Models\Specific\Shop;
use DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SrkGrid\GridView\Grid;

class ShopController extends Controller
{
    /**
     * @author Reza Sarlak
     * @return \Response
     */
    public function index()
    {
        $items = [
            ["title" => 'مدیریت فروشگاهای وبسایت', "link" => route('admin.shop.index')]
        ];

        $view = Grid::make(ShopGrid::class, Shop::latest());

        $data = [
            'items' => $items,
            'shops' => Shop::count(),
            'view' => $view
        ];
        return view('admin.specific.shop.index', $data);
    }

    public function show(Shop $shop)
    {
        auth()->login($shop->user);

        return redirect()->route('front.profile.shop.edit', $shop);
    }

    /**
     * delete shop selected
     *
     * @author Reza Sarlak
     * @param Request $request
     * @param $shop
     * @return JsonResponse
     */
    public function destroy(Request $request, $shop)
    {
        if ($request->has('ids')) {
            Shop::whereIn('id', $request->ids)->delete();

            $httpStatus = JsonResponse::HTTP_OK;

            return response()->json(['status' => $httpStatus, 'msg' => trans('messages.delete-success')], $httpStatus);
        }
    }

    public function getProducts(Shop $shop)
    {
        return $shop->products()->get(['id as value', 'title']);
    }

}
