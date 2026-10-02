<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\News;
use App\Http\Requests\Admin\Base\NewsRequest;

use DataTables;

class NewsController extends Controller
{
    const THUMBNAIL_SIZE = ['840/400', '650/240', '276/130', '150/70', '60/60'];

    public function index()
    {
        $items = [
            ["title" => __('content.management_news'), "link" => route('admin.news.index')]
        ];
        $data['objects'] = News::all();
        return view('admin.pages.news.index', compact('items', 'data'));
    }

    public function create()
    {
        $items = [
            ["title" => __('content.management_news'), "link" => route('admin.news.index')],
            ["title" => __('content.create_news'), "link" => route('admin.news.create')]
        ];
        $data = [
            'items' => $items,
            'relatedNews' => News::visible()->orderBy('title')->get()
        ];
        return view('admin.pages.news.create', $data);
    }

    /**
     * @param NewsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function store(NewsRequest $request)
    {
        $news = \DB::transaction(function () use ($request) {
            $news = News::create($request->all());
            $news->createImage($request->file('pic'), 'main', $request->get('cropper'), self::THUMBNAIL_SIZE);
            if ($request->has('related_news')) {
                $news->relatedNews()->attach($request->get('related_news'));
            }
            return $news;
        });

        return redirect()->route('admin.news.edit', $news->id)->with('msg', __('messages.add_item'));
    }

    public function edit($news)
    {
        $news = News::find($news);
        $items = [
            ["title" => __('content.management_news'), "link" => route('admin.news.index')],
            ["title" => $news->title, "link" => "#"]
        ];
        $data = [
            'news'=>$news,
            'items' => $items,
            'relatedNews' => News::visible()->where('id','!=',$news->id)->orderBy('title')->get(),
            'relatedNewIds'=>$news->relatedNews()->pluck('id')->toArray()
        ];
        return view('admin.pages.news.edit', $data);
    }

    public function update(NewsRequest $request, $news)
    {
        $update = News::find($news);
        if ($request->file('pic') != null) {
            $update->updateImage($request->file('pic'), 'main', $request->get('cropper'), self::THUMBNAIL_SIZE);
        }
        if ($request->has('related_news')) {
            $update->relatedNews()->sync($request->get('related_news'));
        } else {
            $update->relatedNews()->sync([]);
        }
        News::find($news)->update($request->all());
        return redirect()->back()->with('msg', __('messages.edit_item'));
    }

    function destroy(Request $request, $news)
    {
        if ($news == "all") {
            $ids = $request->get('ids');
            foreach ($ids as $id) {
                News::find($id)->delete();
            }
        } else {
            News::find($news)->delete();
        }
    }

    public function DataTable(Request $request)
    {
        $model = News::select(['id', 'title', 'created_at', 'display', 'updated_at', 'position']);
        return DataTables::eloquent($model)
            ->setRowAttr(['data-itemId' => '{{$id}}'])
            ->addColumn('sorting', function ($model) {
                return '<div class="sort_container"
                            data-model="' . get_class($model) . '"
                            data-database="mysql">
                        <a class="sort sort_handle_style1 ui-sortable-handle"><span class="hide">' . $model->position . '</span></a></div>';
            }, 0)
            ->addColumn('check', function ($model) {
                return '<label class="checkradio_style1 type2"><input type="checkbox" name="id[]" value="' . $model->id . '" data-select-row=""><span class="box"></span></label>';
            }, 1)
            ->addColumn('image', function ($model) {
                return '<img src="' . $model->takeImage('main', '60/60') . '"/>';
            }, 1)
            ->editColumn('display', function ($model) {
                return '<label class="checkradio_style2 switchery-sm"><input name="display" type="checkbox" class="js-switch switch_for_all"
                           data-id="' . $model->id . '"
                           data-model="' . get_class($model) . '"
                           data-database="mysql"
                           data-link="' . route('admin.switch.update', $model->id) . '"
                           value="1" ' . ($model->display == 1 ? 'checked="checked"' : '') . ' >
                        </label>';
            }, 1)
            ->editColumn('created_at', '{{ShowDate($created_at)}} <br> {{ShowTime($created_at)}}')
            ->editColumn('updated_at', '{{ShowDate($updated_at)}} <br> {{ShowTime($updated_at)}}')
            ->addColumn('edit', function ($model) {
                return '<a href="' . route('admin.news.edit', $model->id) . '" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
