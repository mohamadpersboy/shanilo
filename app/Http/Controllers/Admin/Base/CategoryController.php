<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\Category;
use App\Http\Requests\Admin\Base\CategoryRequest;

use DataTables;

class CategoryController extends Controller
{

    public function index() {
        $items = [
            ["title" => "دسته بندی - گروه اصلی","link" => '#']
        ];

        $categories = Category::depth(1)->get();

        $data = [
            "items" => $items,
            "categories" => $categories,
        ];
        return view('admin.pages.category.index', $data);
    }

    public function store(CategoryRequest $request) {
        $this->validate($request, [
            'pic' => 'required',
        ],[],[
            'pic' => __('content.image'),
        ]);

        $categoryRoot = Category::depth(0)->first();
        $create = $categoryRoot->children()->create($request->all());
        $create->createImage($request->file('pic'), 'main',$request->get('cropper'), ['40/40','60/60']);

        return redirect()->back()->with('msg', __('messages.add_item'));
    }

    public function edit(Category $category) {
        $items = [
            ["title" => "دسته بندی - گروه اصلی - ویرایش","link" => '#']
        ];

        $data = [
            "items" => $items,
            "category" => $category,
        ];

        return view('admin.pages.category.edit', $data);
    }

    public function update(CategoryRequest $request, Category $category) {
        $category->update($request->all());
        if($request->file('pic') != null){
            $category->updateImage($request->file('pic'), 'main',$request->get('cropper'), ['40/40','60/60']);
        }
        return redirect()->back()->with('msg',__('messages.edit_item'));
    }

    function destroy(Request $request, $category)
    {
        $ids = $request->get('ids');
        foreach ($ids as $id) {
            $category = Category::find($id);
            if(!$category->children()->get()->count()) {
                $category->delete();
            }
        }
    }

    public function dataTable(Request $request)
    {
        $model = Category::select(['id', 'title','display', 'position'])->where([['depth', 1]]);

        $datatable =  DataTables::eloquent($model)
            ->setRowAttr([
                'data-itemId' => function($model) {
                    return $model->id;
                }
            ])
            ->editColumn('position', function ($model) {
                return '<div class="sort_container"
                            data-model="'.get_class($model).'"
                            data-database="mysql">
                        <a class="sort sort_handle_style1 ui-sortable-handle"><span class="hide">'.$model->position.'</span></a></div>';
            }, 0)
            ->addColumn('check', function ($model) {
                if($model->children()->get()->count()){
                    return "";
                } else {
                    return '<label class="checkradio_style1 type2"><input type="checkbox" name="id[]" value="'.$model->id.'" data-select-row=""><span class="box"></span></label>';
                }
            }, 1)
            ->editColumn('display', function ($model) {
                return '<label class="checkradio_style2 switchery-sm"><input name="display" type="checkbox" class="js-switch switch_for_all"
                           data-id="'.$model->id.'"
                           data-model="'.get_class($model).'"
                           data-database="mysql"
                           data-link="'.route('admin.switch.update',$model->id).'"
                           value="1" '.($model->display == 1 ? 'checked="checked"':'').' >
                        </label>';
            }, 1)
            ->addColumn('image', function ($model) {
                return '<img src="'.$model->takeImage('main','60/60').'"/>';
            }, 1)
            ->addColumn('product_count', function ($model) {
                return $model->children()->get()->count();
            }, 1)
            ->addColumn('edit', function ($model) {
                return '<a href="'.route('admin.category.edit',$model->id).'" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([]);

        return $datatable->make(true);
    }
}
