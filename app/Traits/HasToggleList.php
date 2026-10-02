<?php
/**
 * Created by PhpStorm.
 * User: milad
 * Date: 21/04/2018
 * Time: 11:12 AM
 */

namespace App\Traits;


use App\Models\Specific\ProductDetail;

trait HasToggleList
{

    /**
     * @return bool
     */
    public static function any()
    {
        return !!self::getItem()->details()->count();
    }

    /**
     * @return int
     */
    public static function count()
    {
        return self::getItem()->details()->count();
    }

    /**
     * @param ProductDetail $productDetail
     * @return bool
     */
    public static function add(ProductDetail $productDetail)
    {
        $item=self::getItem();
        if(!$item->details()->where('product_detail_id',$productDetail->id)->exists()){
            $item->details()->create([
                'product_detail_id'=>$productDetail->id
            ]);
            return true;
        }
        return false;
    }

    /**
     * @param ProductDetail $productDetail
     * @return bool
     */
    public static function remove(ProductDetail $productDetail)
    {
        self::getItem()->details()->where('product_detail_id',$productDetail->id)->delete();
        return true;
    }

    /**
     * @return self
     */
    protected static function getItem()
    {
        $cookie=\Cookie::get(self::COOKIE_NAME);
        if($cookie){
            return self::find($cookie);
        }else{
            $item=self::create();
            \Cookie::queue(self::COOKIE_NAME,$item->id);
            return $item;
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getDetails()
    {
        return self::getItem()->details;
    }
}