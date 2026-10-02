<?php
/**
 * Created by PhpStorm.
 * User: TD-PLUS
 * Date: 11/4/2018
 * Time: 11:05 AM
 */

namespace App\Http\Controllers\Front\Traits\Specific;


use App\Http\Controllers\Front\Specific\ShopPageController;

trait HasAjaxData
{

    protected function getAjaxData($variable = 'productDetails', $view = 'products')
    {
        return [
            'view' => \View::make("front.partial.items.$view", [$variable => $this->data[$variable]])->render(),
            'hasMorePage' => hasMorePage($this->data[$variable])
        ];
    }
}
