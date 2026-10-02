<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\Policy;
use App\Http\Requests\Admin\Base\PolicyRequest;

use DataTables;

class PolicyController extends Controller
{

    public function index()
    {
        $items = [
            ["title" => __('content.management_policy'),"link" => route('admin.policy.index')]
        ];
        $data['objects'] = Policy::all();
        return view('admin.pages.policy.index', compact('items','data'));
    }

    public function store(PolicyRequest $request)
    {
        Policy::create($request->all());
        return redirect()->back()->with('msg', __('messages.add_item'));
    }

    public function edit($policy)
    {
        $policy = Policy::find($policy);
        $items = [
            ["title" => __('content.management_policy'),"link" => route('admin.policy.index')],
            ["title" => $policy->title,"link" => "#"]
        ];
        return view('admin.pages.policy.edit', compact('items','policy'));
    }

    public function update(PolicyRequest $request, $policy)
    {
        Policy::find($policy)->update($request->all());
        return redirect()->back()->with('msg',__('messages.edit_item'));
    }

    function destroy(Request $request,$policy)
    {
        if($policy == "all"){
            $ids = $request->get('ids');
            Policy::whereIn('id', $ids)->delete();
        } else {
            Policy::find($policy)->delete();
        }
    }

    public function DataTable(Request $request)
    {
        $model = Policy::select(['id','title','display','created_at', 'updated_at', 'position']);
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
                return '<a href="'.route('admin.policy.edit',$model->id).'" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
