<?php

namespace App\Http\Controllers\Front;

use App\Models\ShortLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShortLinkController extends Controller
{
    public function getShortLink(Request $request)
    {
        $pathReferer = getRefererPath();

        $check = $this->checkExistsLink($pathReferer);

        $code = empty($check) ? $this->createShortLink($pathReferer)->id : $check->id;

        return response()->json(['code' =>url('/'). '/@' . $code]);
    }




    /*----------------------------------------------------------------------
     * Helper Methods
     * ---------------------------------------------------------------------
     */

    /**
     * Check short link exists
     *
     * @param string $link
     * @return object
     */
    private function checkExistsLink($link)
    {
        return ShortLink::whereLink($link)->first();
    }


    /**
     * Create Short link
     *
     * @param $link
     * @return object
     */
    private function createShortLink($link)
    {
        return ShortLink::create(['link' => $link]);
    }
}
