<?php

namespace App\Http\Controllers\Admin\Advertisement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Advertisement\AdRequest;
use App\Models\Advertisement\AdDetail;

use DataTables;
use Activity;

class AdRequestController extends Controller
{

    public function index()
    {
        $items = [
            ["title" => __('content.management_adrequest'),"link" => route('admin.adrequest.index')]
        ];

        $header['list'] = ["title" => __('content.management_adrequest'),"description" => __('content.list_of_adrequest')];

        $data['adrequests'] = AdRequest::all();
        return view('admin.pages.adrequest.index', compact('items','header','data'));
    }

    public function store(Request $request)
    {
        $create = AdRequest::create($request->all());
        return redirect()->back()->with('msg', __('messages.add_item'));
    }

    public function edit($adrequest)
    {
        $adrequest = AdRequest::findorFail($adrequest);

        $items = [
            ["title" => __('content.management_adrequest'),"link" => route('admin.adrequest.index')],
            ["title" => $adrequest->title,"link" => "#"]
        ];

        $header['edit'] = ["title" => __('content.management_adrequest'),"description" => __('content.edit_adrequest')];

        $data['logactivity'] = Activity::where([['subject_type','App\AdRequest'],['subject_id',$adrequest->id]])->oldest()->get();

        return view('admin.pages.adrequest.edit', compact('items','header','data','adrequest'));
    }

    public function update(Request $request, $adrequest)
    {
        $update = AdRequest::find($adrequest);
        $update->update($request->all());
        return redirect()->back()->with('msg',__('messages.edit_item'));
    }

    function destroy(Request $request,$adrequest)
    {
        if($adrequest == "all"){
            $ids = $request->get('ids');
            foreach ($ids as $id){
                AdRequest::find($id)->delete();
            }
        } else {
            AdRequest::find($adrequest)->delete();
        }
    }

    public function DataTable(Request $request)
    {
        $model = AdRequest::query();

        if($status = $request->get('status')) {
            if($status != 4){
                $model->where('status', $status);
            }
        } else {
            $model->where('status', 1);
        }

        return DataTables::eloquent($model)
            ->setRowAttr([
                'data-itemId' => function($model) {
                    return $model->id;
                },
                'data-status' => function($model) {
                    return $model->status;
                },
            ])
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
            // ->editColumn('user_id', function ($model) {
            //     if($model->user_id != null){
            //         return "<img width='30' src='".asset('assets/admin/_images/icon/if_error_1646012.png')."'>";
            //     } else {
            //         return "<img width='30' src='".asset('assets/admin/_images/icon/if_success_1646004.png')."'>";
            //     }
            // }, 1)
            ->editColumn('status', function ($model) {
                if($model->status == 1) {
                    return '<span class="cl_blue">پیگیری نشده</span>';
                } else {
                    return '<span class="cl_green2">پیگیری شده</span>';
                }
            }, 1)
            ->editColumn('created_at', '{{ShowDate($created_at)}} <br> {{ShowTime($created_at)}}')
            ->addColumn('edit', function ($model) {
                return '<a href="'.route('admin.advertisement.index','rq='.$model->id).'" class="btn_style3 blue"><i class="i-external-link"></i></a>';
            })
            ->escapeColumns([])
            ->make(true);
    }
}
