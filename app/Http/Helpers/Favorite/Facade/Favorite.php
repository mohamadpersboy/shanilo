<?php
/**
 * Created by PhpStorm.
 * User: milad
 * Date: 10/31/2018
 * Time: 9:54 AM
 */

namespace App\Http\Helpers\Favorite\Facade;


use Illuminate\Support\Facades\Facade;

class Favorite extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'favorite';
    }
}