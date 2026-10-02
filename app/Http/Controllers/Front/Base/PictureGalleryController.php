<?php

namespace App\Http\Controllers\Front\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Base\PictureGallery;

class PictureGalleryController extends Controller
{
    public function index()
    {
        $pictureGalleries = PictureGallery::visible()->orderBy('position')->paginate(12);

        $data = [
            'breadcrumbs'=>[
                'active'=>'گالری تصاویر'
            ],
            "pictureGalleries" => $pictureGalleries,
        ];
        return view('front.pages.picture-gallery.index',$data);
    }
}
