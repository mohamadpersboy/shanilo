<?php

namespace App\Http\Controllers\Admin\Specific;

use App\Models\Specific\Article;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ArticleController extends Controller
{
    public function index()
    {
        $items = [
            ["title" => 'مدیریت مقالات وبسایت', "link" => route('admin.article.index')]
        ];
        $data = [
            'items' => $items,
            'articles' => Article::count()
        ];
        return view('admin.specific.article.index', $data);
    }

    public function show(Article $article)
    {
        auth()->login($article->user);
        return redirect()->route('front.profile.article.edit', $article);
    }

    public function DataTable(Request $request)
    {
        $model = Article::query();
        return DataTables::eloquent($model)
            ->setRowAttr(['data-itemId' => '{{$id}}'])
            ->addColumn('is_active',function($query){
                return $query->is_active == 1 ? 'فعال' : 'غیر فعال';
            })
            ->addColumn('sorting', function ($model) {
                return '<div class="sort_container"
                                data-model="' . get_class($model) . '"
                                data-database="mysql">
                            <a class="sort sort_handle_style1 ui-sortable-handle"><span class="hide">' . $model->position . '</span></a></div>';
            }, 0)
            ->addColumn('check', function ($model) {
                return '<label class="checkradio_style1 type2"><input class="active-article" type="checkbox" name="id[]" value="' . $model->id . '" data-select-row=""><span class="box"></span></label>';
            }, 1)
            ->addColumn('image', function ($model) {
                return '<img src="' . $model->takeImage('main', '60/60') . '"/>';
            }, 1)
            ->editColumn('user_id', function ($model) {
                return getUsersFullName($model->user);
            }, 1)
            ->editColumn('shop_id', function ($model) {
                return $model->shop_id ? $model->shop->title : '-';
            })
            ->editColumn('display', function ($model) {
                return $model->is_active == 1 ? 'فعال' : 'غیر فعال';
            }, 1)
            ->editColumn('created_at', '{{ShowDate($created_at)}} <br> {{ShowTime($created_at)}}')
            ->editColumn('updated_at', '{{ShowDate($updated_at)}} <br> {{ShowTime($updated_at)}}')
            ->addColumn('show', function ($model) {
                return '<a href="' . route('admin.article.show', $model->id) . '" class="btn_style3 blue" target="_blank"><i class="icon-eye2"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }

    public function active(Request $request)
    {
        $active = $request->all();
     
        Article::query()->whereIn('id', $active['id'])->update(['is_active'=> 1]);

        return response()->json(['status'=>JsonResponse::HTTP_OK,'msg'=>'مقالات با موفقیت فعال شد']);
    }

    public function deActive(Request $request)
    {
        $active = $request->all();
     
        Article::query()->whereIn('id', $active['id'])->update(['is_active'=> 0]);

        return response()->json(['status'=>JsonResponse::HTTP_OK,'msg'=>'مقالات با موفقیت غیر فعال شد']);
    }
}
