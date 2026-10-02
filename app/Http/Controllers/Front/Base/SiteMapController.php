<?php

namespace App\Http\Controllers\Front\Base;

use App\Http\Controllers\Controller;
use App\Models\Specific\ArticleCategory;
use App\Models\Specific\MainCategory;
use App\Models\Specific\ProductCategory;
use Illuminate\Http\Request;


class SiteMapController extends Controller
{
    public function index()
    {
       $data=[
           'breadcrumbs'=>[
               'نقشه سایت'
           ],
           'productCategories'=>ProductCategory::visible()->parents()->orderBy('title')->get(),
       ];

        return view('front.pages.sitemap.index',$data);
    }
}
