<?php

namespace App\Http\Controllers\Admin\Advertisement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Advertisement\AdPlan;
use App\Models\Advertisement\AdSection;
use App\Http\Requests\Admin\Advertisement\AdPlanRequest;

use DataTables;
use Activity;

class AdPlanController extends Controller
{

    public function index()
    {
        $items = [
            ["title" => __('content.management_adplan'),"link" => route('admin.adplan.index')]
        ];

        $header['list'] = ["title" => __('content.management_adplan'),"description" => __('content.list_of_adplan')];
        $header['create'] = ["title" => __('content.management_adplan'),"description" => __('content.create_adplan')];

        $data['adplans'] = AdPlan::all();
        $data['ad_sections'] = AdSection::visible()->get();
        return view('admin.pages.adplan.index', compact('items','header','data'));
    }

    public function store(AdPlanRequest $request)
    {
        $this->validate($request, [
            'pic' => 'required',
        ],[],[
            'pic' => 'عکس',
        ]);
        $create = AdPlan::create($request->all());
        $create->ad_sections()->sync($request->get('ad_section'));
        $create->createImage($request->file('pic'), 'main',$request->get('cropper'),['100/0']);
        return redirect()->back()->with('msg', __('messages.add_item'));
    }

    public function edit($adplan)
    {
        $adplan = AdPlan::findorFail($adplan);

        $items = [
            ["title" => __('content.management_adplan'),"link" => route('admin.adplan.index')],
            ["title" => $adplan->title,"link" => "#"]
        ];

        $header['edit'] = ["title" => __('content.management_adplan'),"description" => __('content.edit_adplan')];

        $data['logactivity'] = Activity::where([['subject_type',get_class($adplan)],['subject_id',$adplan->id]])->oldest()->get();
        $data['ad_sections'] = AdSection::visible()->get();
        
        return view('admin.pages.adplan.edit', compact('items','header','data','adplan'));
    }

    public function update(AdPlanRequest $request, $adplan)
    {
        $update = AdPlan::find($adplan);
        if($request->file('pic') != null){
            $update->updateImage($request->file('pic'), 'main',$request->get('cropper'),['100/0']);
        }
        $update->ad_sections()->sync($request->get('ad_section'));
        $update->update($request->all());
        return redirect()->back()->with('msg',__('messages.edit_item'));
    }

    function destroy(Request $request,$adplan)
    {
        if($adplan == "all"){
            $ids = $request->get('ids');
            foreach ($ids as $id){
                AdPlan::find($id)->delete();
            }
        } else {
            AdPlan::find($adplan)->delete();
        }
    }

    public function DataTable(Request $request)
    {
        $model = AdPlan::select(['id','title','created_at', 'updated_at','display', 'position']);
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
            ->addColumn('image', function ($model) {
                return '<img src="'.$model->takeImage('main','100/0').'"/>';
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
                return '<a href="'.route('admin.adplan.edit',$model->id).'" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
