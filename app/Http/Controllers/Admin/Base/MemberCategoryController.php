<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\MemberCategory;
use App\Http\Requests\Admin\Base\MemberCategoryRequest;

use DataTables;

class MemberCategoryController extends Controller
{

    public function index()
    {
        $items = [
            ["title" => __('content.management_member_category'),"link" => route('admin.member_category.index')]
        ];
        $data['objects'] = MemberCategory::all();
        return view('admin.pages.member_category.index', compact('items','data'));
    }

    public function store(MemberCategoryRequest $request)
    {
        MemberCategory::create($request->all());
        return redirect()->back()->with('msg', __('messages.add_item'));
    }

    public function edit($member_category)
    {
        $member_category = MemberCategory::find($member_category);
        $items = [
            ["title" => __('content.management_member_category'),"link" => route('admin.member_category.index')],
            ["title" => $member_category->name,"link" => "#"]
        ];
        return view('admin.pages.member_category.edit', compact('items','member_category'));
    }

    public function update(MemberCategoryRequest $request, $member_category)
    {
        MemberCategory::find($member_category)->update($request->all());
        return redirect()->back()->with('msg',__('messages.edit_item'));
    }

    function destroy(Request $request,$member_category)
    {
        if($member_category == "all"){
            $ids = $request->get('ids');
            MemberCategory::whereIn('id', $ids)->delete();
            foreach ($ids as $id){
                $member_category = MemberCategory::find($id);
                if(!$member_category->members->count()) {
                    $member_category->delete();
                }
            }
        } else {
            $member_category = MemberCategory::find($member_category);
            if(!$member_category->members->count()) {
                $member_category->delete();
            }
        }
    }

    public function DataTable(Request $request)
    {
        $model = MemberCategory::select(['id','title','created_at', 'updated_at','display', 'position']);
        return DataTables::eloquent($model)
            ->setRowAttr(['data-itemId' => '{{$id}}'])
            ->addColumn('sorting', function ($model) {
                return '<div class="sort_container"
                            data-model="'.get_class($model).'"
                            data-database="mysql">
                        <a class="sort sort_handle_style1 ui-sortable-handle"><span class="hide">'.$model->position.'</span></a></div>';
            }, 0)
            ->addColumn('check', function ($model) {
                if($model->members->count()){
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
                        </label>';}, 1)
            ->editColumn('created_at', '{{ShowDate($created_at)}} <br> {{ShowTime($created_at)}}')
            ->editColumn('updated_at', '{{ShowDate($updated_at)}} <br> {{ShowTime($updated_at)}}')
            ->addColumn('edit', function ($model) {
                return '<a href="'.route('admin.member_category.edit',$model->id).'" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
