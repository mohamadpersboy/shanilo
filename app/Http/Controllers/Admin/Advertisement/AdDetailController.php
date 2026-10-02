<?php

namespace App\Http\Controllers\Admin\Advertisement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Advertisement\AdDetail;
use App\Models\Advertisement\AdPlan;
use App\Models\Advertisement\AdTime;
use App\Http\Requests\Admin\Advertisement\AdDetailRequest;

use DataTables;
use Activity;

class AdDetailController extends Controller
{

    public function index()
    {
        $items = [
            ["title" => __('content.management_addetail'),"link" => route('admin.addetail.index')]
        ];

        $header['list'] = ["title" => __('content.management_addetail'),"description" => __('content.list_of_addetail')];
        $header['create'] = ["title" => __('content.management_addetail'),"description" => __('content.create_addetail')];

        $data['addetails'] = AdDetail::all();
        $data['adplans'] = AdPlan::visible()->get();
        $data['adtimes'] = AdTime::visible()->get();
        return view('admin.pages.addetail.index', compact('items','header','data'));
    }

    public function store(AdDetailRequest $request)
    {
        $request->request->add(['price' => str_replace(',', '', $request->get('price'))]);
        $request->request->add(['price_discount' => str_replace(',', '', $request->get('price_discount'))]);
        $check = AdDetail::where([['ad_plan_id',$request->get('ad_plan_id')],['ad_time_id',$request->get('ad_time_id')]])->get();
        if($check->count()){
            return redirect()->back()->withInput()->with('err', 'قبلا با این زمان و پلن ثبت شده است.');
        } else {
            $create = AdDetail::create($request->all());
            return redirect()->back()->with('msg', __('messages.add_item'));
        }
    }

    public function edit($addetail)
    {
        $addetail = AdDetail::findorFail($addetail);

        $items = [
            ["title" => __('content.management_addetail'),"link" => route('admin.addetail.index')],
            ["title" => $addetail->title,"link" => "#"]
        ];

        $header['edit'] = ["title" => __('content.management_addetail'),"description" => __('content.edit_addetail')];

        $data['logactivity'] = Activity::where([['subject_type',get_class($addetail)],['subject_id',$addetail->id]])->oldest()->get();
        $data['adplans'] = AdPlan::visible()->get();
        $data['adtimes'] = AdTime::visible()->get();

        return view('admin.pages.addetail.edit', compact('items','header','data','addetail'));
    }

    public function update(AdDetailRequest $request, $addetail)
    {
        $request->request->add(['price' => str_replace(',', '', $request->get('price'))]);
        $request->request->add(['price_discount' => str_replace(',', '', $request->get('price_discount'))]);

        $update = AdDetail::find($addetail);
        $check = AdDetail::where([['ad_plan_id',$request->get('ad_plan_id')],['ad_time_id',$request->get('ad_time_id')]])->get();
        if($check->count()){
            return redirect()->back()->withInput()->with('err', 'قبلا با این زمان و پلن ثبت شده است.');
        } else {
            $update->update($request->all());
            return redirect()->back()->with('msg',__('messages.edit_item'));
        }
    }

    function destroy(Request $request,$addetail)
    {
        if($addetail == "all"){
            $ids = $request->get('ids');
            foreach ($ids as $id){
                AdDetail::find($id)->delete();
            }
        } else {
            AdDetail::find($addetail)->delete();
        }
    }

    public function DataTable(Request $request)
    {
        $model = AdDetail::select(['id','price_discount','ad_plan_id','ad_time_id','created_at', 'updated_at','display', 'position']);
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
            ->addColumn('detail', function ($model) {
                return 'پلن: '.$model->adplan->title.'<br> زمان: '.$model->adtime->title.'<br> مبلغ: '.$model->price_discount;
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
                return '<a href="'.route('admin.addetail.edit',$model->id).'" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
