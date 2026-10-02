<?php

namespace App\Http\Controllers\Front\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Base\VideoGallery;

use Cookie;

class VideoGalleryController extends Controller
{
    public function index($video="",Request $request)
    {
        $data=[
            'breadcrumbs'=>[
                'active'=>'گالری ویدئو',
            ],
            'videoGalleries'=>VideoGallery::visible()->paginate(12)
        ];
        return view('front.pages.video-gallery.index',$data);
    }

    public function show(VideoGallery $videoGallery)
    {
        $hitCookie = \request()->cookie('HitVideo' . $videoGallery->id);

        if ($hitCookie != 'YouHitThisVideo') {
            Cookie::queue('HitVideo' . $videoGallery->id, 'YouHitThisVideo', 1440);
            $videoGallery->hit += 1;
            $videoGallery->save();
        }
        $data=[
            'breadcrumbs'=>[
                route('front.videogallery.index')=>'گالری ویدئو',
                'active'=>$videoGallery->title
            ],
            'videoGallery'=>$videoGallery,
        ];
        return view('front.pages.video-gallery.show',$data);
    }
}
