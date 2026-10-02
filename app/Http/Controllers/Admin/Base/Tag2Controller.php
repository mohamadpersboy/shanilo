<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\Tag;
use App\Http\Requests\Admin\Base\Tag2Request;

use DataTables;

class Tag2Controller extends Controller
{
    public function index() {
        $items = [
            ["title" => "تگ محصولات - زیر گروه ها","link" => '#']
        ];
        $tagRoot = Tag::depth(0)->first();
        $data['categoriesFirstLevel'] = $tagRoot->getDescendants(1);

        return view('admin.pages.tag2.index', compact('items', 'data'));
    }


    public function store(Tag2Request $request) {
        $tagParent = Tag::find($request->input('parent_id'));
        $tag = $tagParent->children()->create($request->all());

        return redirect()->back()->with('msg', 'عملیات با موفقیت انجام گردید');
    }

    public function edit($tag) {
        $tag = Tag::find($tag);

        $items = [
            ["title" => "تگ محصولات - زیر گروه ها  - ویرایش","link" => '#']
        ];

        # Parent Categoried
        $tagRoot = Tag::depth(0)->first();
        $data['categoriesFirstLevel'] = $tagRoot->getDescendants(1);

        return view('admin.pages.tag2.edit', compact('items', 'data', 'tag'));
    }

    public function update(Tag2Request $request, $tag) {
        $tag = Tag::find($tag);
        $tag->update($request->all());

        return redirect()->back()->with('msg', 'عملیات با موفقیت انجام گردید.');
    }

    function destroy(Request $request, $tag)
    {
        if($tag == "all"){
            $ids = $request->get('ids');
            foreach ($ids as $id) {
                $tag = Tag::find($id);
                if(!$tag->products->count()) {
                    $tag->delete();
                }
            }
        } else {
            $tag = Tag::find($tag);
            if(!$tag->products->count()) {
                $tag->delete();
            }
        }
    }

    public function dataTable(Request $request)
    {
        $model = Tag::select(['id', 'name','parent_id', 'display', 'position'])->where([['depth', 2]]);
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
            ->editColumn('parent_id', function ($model) {
                return $model->parent()->first()->name;
            })
            ->addColumn('check', function ($model) {
                if($model->products->count()){
                    return "";
                } else {
                    return '<label class="checkradio_style1 type2"><input type="checkbox" name="id[]" value="'.$model->id.'" data-select-row=""><span class="box"></span></label>';
                }
            }, 1)
            ->addColumn('product_count', function ($model) {
                return $model->products->count();
            }, 1)
            ->editColumn('display', function ($model) {
                return '<label class="checkradio_style2 switchery-sm"><input name="display" type="checkbox" class="js-switch switch_for_all"
                           data-id="'.$model->id.'"
                           data-model="'.get_class($model).'"
                           data-database="mysql"
                           data-link="'.route('admin.switch.update',$model->id).'"
                           value="1" '.($model->display == 1 ? 'checked="checked"':'').' >
                        </label>';}, 1)
            ->addColumn('edit', function ($model) {
                return '<a href="'.route('admin.tag2.edit',$model->id).'" target="_blank" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([]);

        if ($parent_id = $datatable->request->get('parent_id')) {
            $datatable->where('parent_id', $parent_id);
        }

        return $datatable->make(true);
    }
}
