<?php

namespace App\Http\Controllers\Front\Base;

use App\Http\Controllers\Controller;
use App\Models\Advertisement\Advertisement;
use App\Models\Base\News;
use Illuminate\Http\Request;

use App\Models\Base\Article;
use App\Models\Base\ArticleCategory;

use Cookie;
use Illuminate\Http\JsonResponse;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::visible()->orderBy('created_at', 'desc')->paginate(12);
        $data = [
            "breadcrumbs" => [
                'active' => 'مقالات'
            ],
            'pageTitle' => 'مقالات',
            'activeMenu' => 'encyclopedia',
            "articles" => $articles,
        ];
        return view('front.pages.article.index', $data);
    }

    public function show(Article $article, Request $request)
    {
        if (isset($article) && $article->display == 1) {
            $hitCookie = $request->cookie('HitArticle' . $article->id);

            if ($hitCookie != 'YouHitThisArticle') {
                Cookie::queue('HitArticle' . $article->id, 'YouHitThisArticle', 1440);
                $article->hit += 1;
                $article->save();
            }

            $data = [
                "breadcrumbs" => [
                    route('front.article.index') => 'مقالات',
                    'active' => $article->title
                ],
                'advertisements'=>Advertisement::with('attachments', 'adplan')->visible()->whereHas('adplan', function ($adPlanQuery) {
                    $adPlanQuery->whereHas('ad_sections', function ($adSectionQuery) {
                        $adSectionQuery->where('name', 'article_detail');
                    });
                })->orderBy('expire_at', 'desc')->get(),
                'pageTitle' =>$article->title,
                'activeMenu' => 'encyclopedia',
                "article" => $article->load('attachments', 'relatedArticles'),
                "news" => News::visible()->orderBy('created_at', 'desc')->limit(5)->get()
            ];
            return view('front.pages.article.show', $data);
        } else {
            abort(404);
        }
    }

    
}
