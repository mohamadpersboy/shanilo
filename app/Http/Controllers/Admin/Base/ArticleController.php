<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\Article;
use App\Models\Base\ArticleCategory;
use App\Http\Requests\Admin\Base\ArticleRequest;

use DataTables;

class ArticleController extends Controller
{
    const THUMBNAIL_SIZE=['840/400','276/130','60/60'];
    public function index()
    {
        $items = [
            ["title" => __('content.management_article'),"link" => route('admin.article.index')]
        ];

        $data['objects'] = Article::all();
        return view('admin.pages.article.index', compact('items','data'));
    }

    public function create()
    {
        $items = [
            ["title" => __('content.management_article'),"link" => route('admin.article.index')],
            ["title" => __('content.create_article'),"link" => route('admin.article.create')]
        ];
        $data=[
            'items'=>$items,
            'relatedArticles'=>Article::visible()->orderBy('title')->get()
            //'categories'=>ArticleCategory::visible()->orderBy('title')->get(),
        ];
        return view('admin.pages.article.create',$data);
    }

    public function store(ArticleRequest $request)
    {
        $this->validate($request, [
            'pic' => 'required',
        ],[],[
            'pic' => 'عکس مقاله',
        ]);
        $article=\DB::transaction(function () use ($request){
            $article = Article::create($request->all());
            $article->createImage($request->file('pic'), 'main', $request->get('cropper'), self::THUMBNAIL_SIZE);
            if($request->has('related_articles')){
                $article->relatedArticles()->attach($request->get('related_articles'));
            }
            return $article;
        });
        return redirect()->route('admin.article.edit',$article->id)->with('msg', __('messages.add_item'));
    }

    public function edit($article)
    {
        $article = Article::find($article);
        $items = [
            ["title" => __('content.management_article'),"link" => route('admin.article.index')],
            ["title" => $article->title,"link" => "#"]
        ];
        $data=[
          //  'categories'=>ArticleCategory::visible()->orderBy('title')->get(),
            'items'=>$items,
            'article'=>$article,
            'relatedArticles'=>Article::visible()->where('id','!=',$article->id)->orderBy('title')->get(),
            'relatedArticleIds'=>$article->relatedArticles()->pluck('id')->toArray()
        ];
        return view('admin.pages.article.edit',$data);
    }

    public function update(ArticleRequest $request, $article)
    {
        $update = Article::find($article);
        if($request->file('pic') != null){
            $update->updateImage($request->file('pic'), 'main', $request->get('cropper'), self::THUMBNAIL_SIZE);
        }
        if($request->has('related_articles')){
            $update->relatedArticles()->sync($request->get('related_articles'));
        }else{
            $update->relatedArticles()->sync([]);
        }
        Article::find($article)->update($request->all());
        return redirect()->back()->with('msg',__('messages.edit_item'));
    }

    public function upload(Request $request)
    {
        $id = $request->get('id');
        $file = $request->file('file');
        $upload = Article::with('attachments')->find($id);
        if($upload->attachmentSlug('file')->count()){
            $upload->updateFile($file, "file");
        } else {
            $upload->createFile($file, "file");
        }
    }

    function destroy(Request $request,$article)
    {
        if($article == "all"){
            $ids = $request->get('ids');
            foreach ($ids as $id){
                Article::find($id)->delete();
            }
        } else {
            Article::find($article)->delete();
        }
    }

    public function DataTable(Request $request)
    {
        $model = Article::select(['id','title','created_at', 'updated_at', 'display', 'position']);
        return DataTables::eloquent($model)
            ->setRowAttr(['data-itemId' => '{{$id}}'])
            ->addColumn('sorting', function ($model) {
                return '<div class="sort_container"
                            data-model="'.get_class($model).'"
                            data-database="mysql">
                        <a class="sort sort_handle_style1 ui-sortable-handle"><span class="hide">'.$model->position.'</span></a></div>';
            }, 0)
            ->addColumn('check', function ($model) {
                return '<label class="checkradio_style1 type2"><input type="checkbox" name="id[]" value="'.$model->id.'" data-select-row=""><span class="box"></span></label>';
            }, 1)
            ->editColumn('created_at', '{{ShowDate($created_at)}} <br> {{ShowTime($created_at)}}')
            ->editColumn('updated_at', '{{ShowDate($updated_at)}} <br> {{ShowTime($updated_at)}}')
            ->editColumn('display', function ($model) {
                return '<label class="checkradio_style2 switchery-sm"><input name="display" type="checkbox" class="js-switch switch_for_all"
                           data-id="'.$model->id.'"
                           data-model="'.get_class($model).'"
                           data-database="mysql"
                           data-link="'.route('admin.switch.update',$model->id).'"
                           value="1" '.($model->display == 1 ? 'checked="checked"':'').' >
                        </label>';}, 1)
            ->addColumn('edit', function ($model) {
                return '<a href="'.route('admin.article.edit',$model->id).'" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->addColumn('image', function ($model) {
                return '<img src="'.$model->takeImage('main','60/60').'"/>';
            }, 1)
            ->escapeColumns([])
            ->make(true);
    }
}
