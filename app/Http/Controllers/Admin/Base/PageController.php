<?php

namespace App\Http\Controllers\Admin\Base;

use App\Http\Requests\Admin\Base\PageRequest;
use App\Models\Base\Attachment;
use App\Models\Base\Page;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    const THUMBNAIL_SIZES = ['560/480', '60/60'];

    public function index()
    {
        $items = [
            ["title" => 'مدیریت صفحات', "link" => route('admin.page.index')]
        ];
        $data = [
            'items' => $items,
            'pages' => Page::count()
        ];
        return view('admin.pages.page.index', $data);
    }

    public function create()
    {
        $items = [
            ["title" => 'مدیریت صفحات', "link" => route('admin.page.index')],
            ["title" => 'ایجاد صفحه', "link" => route('admin.page.create')],
        ];
        $data = [
            'items' => $items
        ];
        return view('admin.pages.page.create', $data);
    }

    public function store(PageRequest $request)
    {
        $this->setDetails($request);
        $page = Page::create($request->all());
        if ($request->file('pic')) {
            $page->createImage($request->file('pic'), 'main', $request->get('cropper'), self::THUMBNAIL_SIZES);
        }

        return back()->with('msg', __('messages.add_item'));
    }

    public function edit(Page $page)
    {
        $items = [
            ["title" => 'مدیریت صفحات', "link" => route('admin.page.index')],
            ["title" => 'ویرایش صفحه', "link" => route('admin.page.edit',$page)],
        ];
        $data = [
            'items' => $items,
            'page' => $page,
            'edit' => true,
        ];
        return view('admin.pages.page.edit', $data);
    }

    public function update(PageRequest $request, Page $page)
    {
        $this->setDetails($request);
        $page->update($request->all());
        if ($request->file('pic')) {
            $page->updateImage($request->file('pic'), 'main', $request->get('cropper'), self::THUMBNAIL_SIZES);
        }
        return back()->with('msg', __('messages.edit_item'));
    }

    public function destroy(Request $request, $page)
    {
        $pages = Page::find($request->input('ids'));
        foreach ($pages as $index => $page) {
            $page->delete();
        }
    }

    public function DataTable(Request $request)
    {
        $model = Page::query();
        return DataTables::eloquent($model)
            ->setRowAttr(['data-itemId' => '{{$id}}'])
            ->addColumn('sorting', function ($model) {
                return '<div class="sort_container"
                            data-model="' . get_class($model) . '"
                            data-database="mysql">
                        <a class="sort sort_handle_style1 ui-sortable-handle"><span class="hide">' . $model->position . '</span></a></div>';
            }, 0)
            ->addColumn('check', function ($model) {
                if(auth()->guard('admins')->user()->role_id!=1)
                    return '';
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
            ->addColumn('add_item', function ($model) {
                if(auth()->guard('admins')->user()->role_id!=1)
                    return '';
                return '<a href="'.route('admin.pageItem.create',['page_id'=>$model->id]).'" class="btn_style3 blue"><i class="i-plus-square"></i></a>';
            })
            ->addColumn('view_items', function ($model) {
                return '<a href="'.route('admin.pageItem.index',['page_id'=>$model->id]).'" class="btn_style3 blue"><i class="icon-eye"></i></a>';
            })
            ->addColumn('edit', function ($model) {
                return '<a href="' . route('admin.page.edit', $model->id) . '" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }

    private function setDetails(Request &$request)
    {
        $titles = $request->input('option_title');
        $values = $request->input('option_value');
        $data = [];
        if(!$titles){
            return [];
        }
        foreach ($titles as $index => $title) {
            if (!$title || !$values[$index]) {
                continue;
            }
            $data[] = [
                'title' => $title,
                'value' => $values[$index]
            ];
        }
        $request->merge(['details' => json_encode($data)]);
    }

    public function gallery(Request $request)
    {
        $file_name = $request->file('Filedata')->getClientOriginalName();
        $update = Page::find($request->get('id'));
        $image_id = $update->createImageResponseId($request->file('Filedata'), 'gallery', null, self::THUMBNAIL_SIZES);
        $image_link = Attachment::find($image_id);
        $image_link = $update->takeImageWithName($image_link->file_name);
        return json_encode(array(
                'file_name' => $file_name,
                'image_id' => $image_id,
                'image_link' => $image_link)
        );
    }

    public function galleryDestroy(Request $request)
    {
        $ids = $request->get('id');
        foreach ($ids as $id) {
            Attachment::find($id)->delete();
        }
        return 1;
    }
}
