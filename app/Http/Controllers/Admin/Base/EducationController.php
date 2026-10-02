<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\Education;
use App\Http\Requests\Admin\Base\EducationRequest;

use DataTables;

class EducationController extends Controller
{
    public function index()
    {
        $items = [
            ["title" => __('content.management_education'),"link" => route('admin.education.index')]
        ];
        $data['objects'] = Education::all();
        return view('admin.pages.education.index', compact('items','data'));
    }

    public function create()
    {
        $items = [
            ["title" => __('content.management_education'),"link" => route('admin.education.index')],
            ["title" => __('content.create_education'),"link" => route('admin.education.create')]
        ];
        return view('admin.pages.education.create',compact('items'));
    }


    public function store(EducationRequest $request)
    {
        Education::create($request->all());
        return redirect()->back()->with('msg', __('messages.add_item'));
    }

    public function edit($education)
    {
        $education = Education::find($education);
        $items = [
            ["title" => __('content.management_education'),"link" => route('admin.education.index')],
            ["title" => $education->name,"link" => "#"]
        ];
        return view('admin.pages.education.edit', compact('items','education'));
    }

    public function update(EducationRequest $request, $education)
    {
        Education::find($education)->update($request->all());
        return redirect()->back()->with('msg',__('messages.edit_item'));
    }

    function destroy(Request $request,$education)
    {
        if($education == "all"){
            $ids = $request->get('ids');
            Education::whereIn('id', $ids)->delete();
        } else {
            Education::find($education)->delete();
        }
    }

    public function DataTable(Request $request)
    {
        $model = Education::select(['id','name','created_at', 'updated_at','display', 'position']);
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
                return '<a href="'.route('admin.education.edit',$model->id).'" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
