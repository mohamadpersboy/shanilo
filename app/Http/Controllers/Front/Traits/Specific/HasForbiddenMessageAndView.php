<?php
/**
 * Created by PhpStorm.
 * User: milad
 * Date: 8/25/2018
 * Time: 9:44 AM
 */

namespace App\Http\Controllers\Front\Traits\Specific;


trait HasForbiddenMessageAndView
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function forbiddenMessage()
    {
        return response()->json(['failed' => ['errors' => ['forbidden' => ['شما مجاز به انجام این عمل نمی باشید.']]]], 422);
    }

    /**
     * @param $view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function view($view)
    {
        return view(self::VIEW_ROOT . $view, $this->data);
    }
}