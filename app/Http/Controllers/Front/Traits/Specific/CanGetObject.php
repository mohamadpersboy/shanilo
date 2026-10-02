<?php
/**
 * Created by PhpStorm.
 * User: TD-PLUS
 * Date: 11/4/2018
 * Time: 8:19 PM
 */

namespace App\Http\Controllers\Front\Traits\Specific;


use App\Models\Base\Comment;
use App\Models\Specific\Order;
use App\Models\Specific\Product;
use App\Models\Specific\ProductDetail;
use App\Models\Specific\Shop;

trait CanGetObject
{
    protected function getObject($object, $id)
    {
        $models = [
            'comment' => Comment::class,
            'shop' => Shop::class,
            'productDetail' => ProductDetail::class,
            'product'=>Product::class,
            'order'=>Order::class
        ];
        return isset($models[$object])?$models[$object]::findOrFail($id):abort(404);
    }
}
