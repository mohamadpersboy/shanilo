<?php

namespace App\Http\Controllers\Admin\Base;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Base\PageItemRequest;
use App\Models\Base\Page;
use App\Models\Base\PageItem;
use DataTables;
use foo\bar;
use Illuminate\Http\Request;

class PageItemController extends Controller
{

    protected $page;

    public function __construct()
    {
        $this->page = Page::findOrFail(\request()->get('page_id'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = [
            ["title" => 'مدیریت صفحات', "link" => route('admin.page.index')],
            ["title" => $this->page->slug, "link" => route('admin.pageItem.index', ['page_id' => $this->page->slug])],
        ];
        $data = [
            'items' => $items,
            'page'=>$this->page,
            'pageItems' => $this->page->items()->count()
        ];
        return view('admin.pages.pageitem.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $items = [
            ["title" => 'مدیریت صفحات', "link" => route('admin.page.index')],
            ["title" => 'ایجاد آیتم جدید', "link" => route('admin.pageItem.create', ['page_id' => $this->page->slug])],
        ];
        $data = [
            'items' => $items,
            'page'=>$this->page
        ];
        return view('admin.pages.pageitem.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PageItemRequest $request
     * @return void
     */
    public function store(PageItemRequest $request)
    {
        $this->page->items()->create($request->all());
        return back()->with('msg',__('messages.add_item'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Specific\PageItem $pageItem
     * @return \Illuminate\Http\Response
     */
    public function edit(PageItem $pageItem)
    {
        $items = [
            ["title" => 'مدیریت صفحات', "link" => route('admin.page.index')],
            ["title" => 'ویرایش آیتم صفحه', "link" => route('admin.pageItem.edit', ['page_id' => $this->page->slug])],
        ];
        $data = [
            'items' => $items,
            'page'=>$this->page,
            'pageItem'=>$pageItem
        ];
        return view('admin.pages.pageitem.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Specific\PageItem $pageItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PageItem $pageItem)
    {
        $pageItem->update($request->all());
        return back()->with('msg',__('messages.edit_item'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Specific\PageItem $pageItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(PageItem $pageItem)
    {
        //
    }

    public function DataTable(Request $request)
    {
        $model = $this->page->items();
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
                return '<a href="' . route('admin.pageItem.edit', [$model->id,'page_id'=>$this->page->id]) . '" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }

}
