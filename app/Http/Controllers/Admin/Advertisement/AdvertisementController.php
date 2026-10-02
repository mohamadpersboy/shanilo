<?php

namespace App\Http\Controllers\Admin\Advertisement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Advertisement\Advertisement;
use App\Models\Advertisement\AdDetail;
use App\Models\Advertisement\AdPlan;
use App\Models\Advertisement\AdTime;
use App\Models\Advertisement\AdRequest;
use App\Http\Requests\Admin\Advertisement\AdvertisementRequest;

use DataTables;
use Activity;
use Carbon\Carbon;

class AdvertisementController extends Controller
{

    public function index()
    {
        $items = [
            ["title" => __('content.management_advertisement'),"link" => route('admin.advertisement.index')]
        ];
        $data['objects'] = Advertisement::all();
        $data['adplans'] = AdPlan::visible()->get();
        $data['adtimes'] = AdTime::visible()->get();
        if(isset($_GET['rq'])){
            $data['adrquest'] = AdRequest::find($_GET['rq']);
            $data['addetails'] = AdDetail::with('adtime')->where('ad_plan_id',$data['adrquest']->ad_plan_id)->get();
            $data['addetail'] = AdDetail::where([['ad_plan_id',$data['adrquest']->ad_plan_id],['ad_time_id',$data['adrquest']->ad_time_id]])->first();
        }
        return view('admin.pages.advertisement.index', compact('items','data'));
    }

    public function choosePlan(Request $request)
    {
        $id = $request->get('id');
        $addetails = AdDetail::with('adtime')->where('ad_plan_id',$id)->get()->toArray();
        return json_encode(
            array(
                'addetails' => $addetails,
            )
        );
    }

    public function chooseTime(Request $request)
    {
        $plan_id = $request->get('plan_id');
        $time_id = $request->get('time_id');
        $addetail = AdDetail::where([['ad_plan_id',$plan_id],['ad_time_id',$time_id]])->first()->toArray();
        return json_encode(
            array(
                'addetail' => $addetail,
            )
        );
    }

    public function store(AdvertisementRequest $request)
    {
        $count = min(array_column(AdPlan::find($request->get('ad_plan_id'))->ad_sections->toArray(), 'max_count'));
        $advertisementCount = Advertisement::visible()->where('ad_plan_id',$request->get('ad_plan_id'))->count();
        if($advertisementCount < $count){
            if($request->has('request_id')){
                $AdRequest = AdRequest::find($request->get('request_id'));
                $AdRequest->status = 2;
                $AdRequest->save();
            }
            $data['adtime'] = AdTime::find($request->get('ad_time_id'));
            $expireTime = makeExpireTime($data['adtime']->day);
            $request->request->add(['expire_at' => $expireTime]);
            $create = Advertisement::create($request->all());
            return redirect()->route('admin.advertisement.edit',$create->id)->with('msg', __('messages.add_item'));
        } else {
            return redirect()->back()->withInput()->with('err', 'ظرفیت مکان تبلیغ به اتمام رسیده است.');
        }
    }

    public function edit($advertisement)
    {
        $advertisement = Advertisement::find($advertisement);
        $items = [
            ["title" => __('content.management_advertisement'),"link" => route('admin.advertisement.index')],
            ["title" => __('content.edit_advertisement'),"link" => "#"]
        ];
        $data['adplans'] = AdPlan::visible()->get();
        $data['adtimes'] = AdTime::visible()->get();
        $data['addetails'] = AdDetail::with('adtime')->where('ad_plan_id',$advertisement->ad_plan_id)->get();
        $data['addetail'] = AdDetail::where([['ad_plan_id',$advertisement->ad_plan_id],['ad_time_id',$advertisement->ad_time_id]])->first();
        $data['adplan'] = AdPlan::find($advertisement->ad_plan_id);

        $data['end'] = Carbon::parse($advertisement->expire_at);
        $data['now'] = Carbon::now();

        $data['logactivity'] = Activity::where([['subject_type',get_class($advertisement)],['subject_id',$advertisement->id]])->oldest()->get();
        return view('admin.pages.advertisement.edit', compact('items','data','advertisement'));
    }

    public function update(AdvertisementRequest $request, $advertisement)
    {
        $update = Advertisement::findorFail($advertisement);
        $data['adplan'] = AdPlan::find($update->ad_plan_id);
        foreach ($data['adplan']->ad_sections as $ad_section){
            if($request->file($ad_section->name) != null){
                if($update->checkImage($ad_section->name)){
                    $update->updateImage($request->file($ad_section->name), $ad_section->name,null,[$ad_section->width.'/'.$ad_section->height]);
                } else {
                    $update->createImage($request->file($ad_section->name), $ad_section->name,null,[$ad_section->width.'/'.$ad_section->height]);
                }
            }
        }
        if($request->get('extend') != null){
            $extendTime = makeExpireTime($request->get('extend'),$update->expire_at);
            $request->request->add(['expire_at' => $extendTime]);
        }
        $update->update($request->all());
        return redirect()->back()->with('msg',__('messages.edit_item'));
    }

    function destroy(Request $request,$advertisement)
    {
        if($advertisement == "all"){
            $ids = $request->get('ids');
            foreach ($ids as $id){
                Advertisement::find($id)->delete();
            }
        } else {
            Advertisement::find($advertisement)->delete();
        }
    }

    public function DataTable(Request $request)
    {
        $model = Advertisement::query();
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
            ->addColumn('planDetail', function ($model) {
                return "نوع پلن: ".$model->adplan->title.
                       "<br>زمان: ".$model->adtime->title.
                       "<br>مبلغ: <i data-mvwc>".AdDetail::planTime($model->ad_plan_id,$model->ad_time_id)->price_discount."</i>";
            }, 1)
            ->addColumn('userDetail', function ($model) {
                return "نام و نام خانوادگی: ".$model->name." ".$model->family.
                       "<br>تلفن: ".$model->tel." - ".$model->mobile.
                       "<br>ایمیل:".$model->email;
            }, 1)
            ->editColumn('display', function ($model) {
                return '<label class="checkradio_style2 switchery-sm"><input name="display" type="checkbox" class="js-switch switch_for_all"
                           data-id="'.$model->id.'"
                           data-model="'.get_class($model).'"
                           data-database="mysql"
                           data-link="'.route('admin.switch.update',$model->id).'"
                           value="1" '.($model->display == 1 ? 'checked="checked"':'').' >
                        </label>';}, 1)
            ->editColumn('created_at', '{{ShowDate($created_at)}} <br> {{showAgoTime($created_at)}}')
            ->editColumn('expire_at', '{{ShowDate($expire_at)}} <br> {{showAgoTime($expire_at)}}')
            ->addColumn('edit', function ($model) {
                return '<a href="'.route('admin.advertisement.edit',$model->id).'" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
