<?php
/**
 * Created by PhpStorm.
 * User: TD-PLUS
 * Date: 11/13/2018
 * Time: 12:26 PM
 */

namespace App\Http\Helpers\Comparison\Facade;


use Illuminate\Support\Facades\Facade;

class Comparison extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'comparison';
    }
}
