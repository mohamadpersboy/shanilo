<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\ArticleCategory;
use App\Http\Requests\Admin\Base\ArticleCategoryRequest;

use DataTables;

class ArticleCategoryController extends Controller
{

    public function index()
    {
        $items = [
            ["title" => __('content.management_article_category'),"link" => route('admin.articleCategory.index')]
        ];

        $data['objects'] = ArticleCategory::all();
        return view('admin.pages.article_category.index', compact('items','data'));
    }

    public function create()
    {
        $items = [
            ["title" => __('content.management_article_category'),"link" => route('admin.articleCategory.index')],
            ["title" => __('content.create_article_category'),"link" => route('admin.articleCategory.create')]
        ];

        return view('admin.pages.article_category.index',compact('items'));
    }

    public function store(ArticleCategoryRequest $request)
    {
        ArticleCategory::create($request->all());
        return redirect()->back()->with('msg', __('messages.add_item'));
    }

    public function edit($article_category)
    {
        $article_category = ArticleCategory::find($article_category);

        $items = [
            ["title" => __('content.management_article_category'),"link" => route('admin.articleCategory.index')],
            ["title" => $article_category->name,"link" => "#"]
        ];

        return view('admin.pages.article_category.edit', compact('items','article_category'));
    }

    public function update(ArticleCategoryRequest $request, $article_category)
    {
        ArticleCategory::find($article_category)->update($request->all());
        return redirect()->back()->with('msg',__('messages.edit_item'));
    }

    function destroy(Request $request,$article_category)
    {
        if($article_category == "all"){
            $ids = $request->get('ids');
            foreach($ids as $id){
                $article_category = ArticleCategory::find($id);
                if(!$article_category->articles->count()){
                    $article_category->delete();
                }
            }
            ArticleCategory::whereIn('id', $ids)->delete();
        } else {
            $article_category = ArticleCategory::find($article_category);
            if(!$article_category->articles->count()){
                $article_category->delete();
            }
        }
    }

    public function DataTable(Request $request)
    {
        $model = ArticleCategory::select(['id','title','created_at', 'updated_at','display', 'position']);
        return DataTables::eloquent($model)
            ->setRowAttr(['data-itemId' => '{{$id}}'])
            ->addColumn('sorting', function ($model) {
                return '<div class="sort_container"
                            data-model="'.get_class($model).'"
                            data-database="mysql">
                        <a class="sort sort_handle_style1 ui-sortable-handle"><span class="hide">'.$model->position.'</span></a></div>';
            }, 0)
            ->addColumn('check', function ($model) {
                if(!$model->articles->count()) {
                    return '<label class="checkradio_style1 type2"><input type="checkbox" name="id[]" value="' . $model->id . '" data-select-row=""><span class="box"></span></label>';
                }
            }, 1)
            ->editColumn('display', function ($model) {
                return '<label class="checkradio_style2 switchery-sm"><input name="display" type="checkbox" class="js-switch switch_for_all"
                           data-id="'.$model->id.'"
                           data-model="'.get_class($model).'"
                           data-database="mysql"
                           data-link="'.route('admin.switch.update',$model->id).'"
                           value="1" '.($model->display == 1 ? 'checked="checked"':'').' >
                        </label>';}, 1)
            ->editColumn('created_at', '{{ShowDate($created_at)}} <br> {{ShowTime($created_at)}}')
            ->editColumn('updated_at', '{{ShowDate($updated_at)}} <br> {{ShowTime($updated_at)}}')
            ->addColumn('article_count', function ($model) {
                return $model->articles->count();
            }, 1)
            ->addColumn('edit', function ($model) {
                return '<a href="'.route('admin.articleCategory.edit',$model->id).'" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
