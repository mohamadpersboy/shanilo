<?php
/**
 * Created by PhpStorm.
 * User: milad
 * Date: 11/14/2018
 * Time: 4:01 PM
 */

namespace App\Http\Helpers\Cart\Facade;


use Illuminate\Support\Facades\Facade;

class Cart extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'cart';
    }
}
