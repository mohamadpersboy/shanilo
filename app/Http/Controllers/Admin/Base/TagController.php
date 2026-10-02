<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\Tag;
use App\Http\Requests\Admin\Base\TagRequest;

use DataTables;

class TagController extends Controller
{

    public function index() {
        $items = [
            ["title" => "تگ محصولات - گروه اصلی","link" => '#']
        ];
        $tags = Tag::depth(1)->get();
        return view('admin.pages.tag.index', compact('items', 'tags'));
    }

    public function store(TagRequest $request) {
        $tagRoot = Tag::depth(0)->first();
        $tagRoot->children()->create($request->all());

        return redirect()->back()->with('msg', 'عملیات با موفقیت انجام گردید');
    }

    public function edit(Tag $tag) {
        $items = [
            ["title" => "تگ محصولات - گروه اصلی - ویرایش","link" => '#']
        ];

        return view('admin.pages.tag.edit', compact('items', 'tag'));
    }

    public function update(TagRequest $request, Tag $tag) {
        $tag->update($request->all());
        return redirect()->back()->with('msg', 'عملیات با موفقیت انجام گردید.');
    }

    function destroy(Request $request, $tag)
    {
        if($tag == "all"){
            $ids = $request->get('ids');
            foreach ($ids as $id) {
                $tag = Tag::find($id);
                if(!$tag->children()->get()->count()) {
                    $tag->delete();
                }
            }
        } else {
            $tag = Tag::find($tag);
            if(!$tag->children()->get()->count()) {
                $tag->delete();
            }
        }
    }

    public function dataTable(Request $request)
    {
        $model = Tag::select(['id', 'name', 'display', 'position'])->where([['depth', 1]]);

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
            ->addColumn('child_count', function ($model) {
                return $model->children()->get()->count();
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
                return '<a href="'.route('admin.tag.edit',$model->id).'" target="_blank" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([]);

        return $datatable->make(true);
    }
}
