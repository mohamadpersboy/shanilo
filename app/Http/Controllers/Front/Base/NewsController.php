<?php

namespace App\Http\Controllers\Front\Base;

use App\Http\Controllers\Controller;
use App\Models\Advertisement\Advertisement;
use App\Models\Base\Article;
use Illuminate\Http\Request;

use App\Models\Base\News;

use Cookie;

class NewsController extends Controller
{
    public function index()
    {
        $data = [
            'breadcrumbs'=>[
                'active'=>'اطلاعیه ها'
            ],
            'pageTitle'=>'اطلاعیه ها',
            'activeMenu'=>'encyclopedia',
            'news' => News::visible()->orderBy('created_at', 'desc')->paginate(8)
        ];
        return view('front.pages.news.index', $data);
    }

    public function show(News $news, Request $request)
    {
        if (isset($news) && $news->display == 1) {
            $hitCookie = $request->cookie('HitNews' . $news->id);

            if ($hitCookie != 'YouHitThisNews') {
                Cookie::queue('HitNews' . $news->id, 'YouHitThisNews', 1440);
                $news->hit += 1;
                $news->save();
            }
            $data = [
                "breadcrumbs" => [
                    route('front.news.index') => 'اطلاعیه ها',
                    'active' => $news->title
                ],
                'advertisements'=>Advertisement::with('attachments','adplan')->visible()->whereHas('adplan', function ($adPlanQuery) {
                    $adPlanQuery->whereHas('ad_sections', function ($adSectionQuery) {
                        $adSectionQuery->where('name', 'news_detail');
                    });
                })->orderBy('expire_at','desc')->get(),
                "news" => $news,
                'pageTitle' =>$news->title,
                'activeMenu'=>'encyclopedia',
                "articles" => Article::visible()->orderBy('created_at', 'desc')->limit(5)->get()
            ];
            return view('front.pages.news.show', $data);

        } else {
            return redirect()->route('front.news.index');
        }
    }
}
