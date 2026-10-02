<?php

namespace App\Http\Controllers\Admin\Advertisement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Advertisement\AdTime;
use App\Http\Requests\Admin\Advertisement\AdTimeRequest;

use DataTables;
use Activity;

class AdTimeController extends Controller
{

    public function index()
    {
        $items = [
            ["title" => __('content.management_adtime'),"link" => route('admin.adtime.index')]
        ];

        $header['list'] = ["title" => __('content.management_adtime'),"description" => __('content.list_of_adtime')];
        $header['create'] = ["title" => __('content.management_adtime'),"description" => __('content.create_adtime')];

        $data['adtimes'] = AdTime::all();
        return view('admin.pages.adtime.index', compact('items','header','data'));
    }

    public function store(AdTimeRequest $request)
    {
        $create = AdTime::create($request->all());
        return redirect()->back()->with('msg', __('messages.add_item'));
    }

    public function edit($adtime)
    {
        $adtime = AdTime::findorFail($adtime);

        $items = [
            ["title" => __('content.management_adtime'),"link" => route('admin.adtime.index')],
            ["title" => $adtime->title,"link" => "#"]
        ];

        $header['edit'] = ["title" => __('content.management_adtime'),"description" => __('content.edit_adtime')];

        $data['logactivity'] = Activity::where([['subject_type',get_class($adtime)],['subject_id',$adtime->id]])->oldest()->get();

        return view('admin.pages.adtime.edit', compact('items','header','data','adtime'));
    }

    public function update(AdTimeRequest $request, $adtime)
    {
        $update = AdTime::find($adtime);
        $update->update($request->all());
        return redirect()->back()->with('msg',__('messages.edit_item'));
    }

    function destroy(Request $request,$adtime)
    {
        if($adtime == "all"){
            $ids = $request->get('ids');
            foreach ($ids as $id){
                AdTime::find($id)->delete();
            }
        } else {
            AdTime::find($adtime)->delete();
        }
    }

    public function DataTable(Request $request)
    {
        $model = AdTime::select(['id','title','created_at', 'updated_at','display', 'position']);
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
                return '<a href="'.route('admin.adtime.edit',$model->id).'" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
