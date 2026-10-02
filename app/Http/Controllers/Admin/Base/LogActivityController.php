<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use Activity;
use DataTables;

class LogActivityController extends Controller
{
    public function index()
    {
        $items = [
            ["title" => __('content.management_logactivity'),"link" => route('admin.logactivity.index')]
        ];

        $header['list'] = ["title" => __('content.management_logactivity'),"description" => __('content.list_of_logactivity')];

        $data['logactivity'] = Activity::all();

        return view('admin.pages.logactivity.index', compact('items','header','data'));
    }

    function destroy(Request $request,$log)
    {
        $ids = $request->get('ids');
        Activity::whereIn('id', $ids)->delete();
    }

    public function DataTable(Request $request)
    {
        $model = Activity::query();
        return DataTables::eloquent($model)
            ->setRowAttr(['data-itemId' => '{{$id}}'])
            ->addColumn('check', function ($model) {
                return '<label class="checkradio_style1 type2"><input type="checkbox" name="id[]" value="'.$model->id.'" data-select-row=""><span class="box"></span></label>';
            }, 1)
            ->addColumn('show_description', function ($model) {
                if(isset($model->changes()['old'])){
                    $details = null;
                    foreach($model->changes()['attributes'] as $key => $value){
                        $details .= "<i class='logTitle'>".__('log.'.$key).": </i>".$value." ";
                    }
                    $oldDetails = null;
                    foreach($model->changes()['old'] as $key => $value){
                        $oldDetails .= "<i class='oldLogTitle'>".__('log.'.$key).": </i>".$value." ";
                    }
                    return showLogActivity($model->description)." ".$model->subject_type::getName()." توسط کاربر ".$model->causer_type::find($model->causer_id)->fullName()." با اطلاعات زیر : <br>".$details."<br> [ اطلاعات قدیمی ] ".$oldDetails;
                } else {
                    $details = null;
                    foreach($model->changes()['attributes'] as $key => $value){
                        $details .= "<i class='logTitle'>".__('log.'.$key).": </i>".$value." ";
                    }
                    return showLogActivity($model->description)." ".$model->subject_type::getName()." توسط کاربر ".$model->causer_type::find($model->causer_id)->fullName()." با اطلاعات زیر : <br>".$details;
                }
            }, 1)
            ->editColumn('created_at', function ($model) {
                return ShowDate($model->created_at)."<br/>".ShowTime($model->created_at);
            }, 1)
            ->escapeColumns([])
            ->make(true);
    }
}
