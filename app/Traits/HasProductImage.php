<?php
/**
 * Created by PhpStorm.
 * User: milad
 * Date: 11/04/2018
 * Time: 12:04 PM
 */

namespace App\Traits;


trait HasProductImage
{
    public function img($slug,$size,$default=null)
    {
        return $this->productDetail->product->takeImage($slug,$size,$default);
    }
    public function product()
    {
        return $this->productDetail->product();
    }
}