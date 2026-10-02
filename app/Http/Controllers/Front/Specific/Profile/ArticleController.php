<?php

namespace App\Http\Controllers\Front\Specific\Profile;

use App\Http\Controllers\Front\Base\ProfileController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\Specific\ArticleRequest;
use App\Models\Specific\Article;

const THUMBNAIL_SIZES = ['900/655', '275/200', '236/170', '100/60', '60/60'];

class ArticleController extends ProfileController
{
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Articles
    # Handles article operations from user dashboard
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#

    public function index()
    {
        $articles=\Auth::user()->articles();
        if($shopId=request()->get('shop_id')){
            $articles->where('shop_id',$shopId);
        }
        $data = [
            'pageTitle'=>'پروفایل من | لیست مجلات',
            'user' => \Auth::user(),
            'articles' => $articles->orderBy('created_at', 'desc')->paginate(PROFILE_PAGINATION_COUNT),
            'activeMenu' => 'articles',
            'shops'=>\Auth::user()->shops()->orderBy('title')->get(),
            'selectedShopId'=>request()->get('shop_id')
        ];
        return view('front.pages.profile.article.index', $data);
    }

    public function create()
    {
        $data = [
            'pageTitle'=>'پروفایل من | افزودن مجله',
            'user' => \Auth::user(),
            'shops' => \Auth::user()->shops()->orderBy('title')->get(),
            'activeMenu' => 'articles',
        ];
        return view('front.pages.profile.article.create', $data);
    }

    /**
     * @param ArticleRequest $request
     * @return array
     * @throws \Exception
     * @throws \Throwable
     */
    public function store(ArticleRequest $request)
    {
        $request->merge(['user_id' => \Auth::id()]);
        \DB::transaction(function () use ($request){
            $article=Article::create($request->all());
            $article->createImage($request->file('pic'),'main',$request->get('cropper'), THUMBNAIL_SIZES);
        });
        setSession([
            'header' => 'ثبت مجله موفق',
            'type' => 'success',
            'message' => 'مجله با موفقیت ثبت گردید.'
        ], 'notification');
        return [
            'url'=>back()->getTargetUrl()
        ];
    }

    /**
     * @param Article $article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Article $article)
    {
        if(\Auth::id()!=$article->user_id){
            abort(404);
        }
        $data = [
            'pageTitle'=>'پروفایل من | ویرایش مجله',
            'user' => \Auth::user(),
            'article'=>$article,
            'shops' => \Auth::user()->shops()->orderBy('title')->get(),
            'activeMenu' => 'articles',
            'edit'=>true,
        ];
        return view('front.pages.profile.article.edit',$data);
    }

    /**
     * @param ArticleRequest $request
     * @param Article $article
     * @return array
     * @throws \Exception
     * @throws \Throwable
     */
    public function update(ArticleRequest $request, Article $article)
    {
        if(\Auth::id()!=$article->user_id){
            abort(404);
        }
        $redirect=false;
        \DB::transaction(function ()use ($request,$article,&$redirect){
            $article->update($request->all());
            if($file=$request->file('pic')){
                $article->updateImage($file,'main',$request->get('cropper'), THUMBNAIL_SIZES);
                $redirect=true;
            }
        });
        $data=[
            'type'=>'success',
            'message'=>'مجله با موفقیت ویرایش گردید.',
            'header'=>'ویرایش مجله'
        ];
        if($redirect){
            setSession($data, 'notification');
            return [
                'url'=>back()->getTargetUrl()
            ];
        }
        return $data;
    }

    /**
     * @param Article $article
     * @return array
     * @throws \Exception
     */
    public function destroy(Article $article)
    {
        if(\Auth::id()!=$article->user_id){
            abort(404);
        }
        $article->delete();
        return \Auth::user()->articles()->count()? [
            'deletedItem'=>"#article-{$article->id}"
        ]:[
            'url'=>back()->getTargetUrl()
        ];
    }
}
