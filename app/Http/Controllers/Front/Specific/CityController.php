<?php

namespace App\Http\Controllers\Admin\Specific;

use App\Models\Base\State;
use App\Models\Base\City;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    public function index()
    {
        $items = [
            ["title" => 'مدیریت شهرها', "link" => route('admin.city.index')]
        ];
        $data = [
            'items' => $items,
            'cities' => City::count()
        ];
        return view('admin.specific.city.index', $data);
    }

    public function update(State $state,Request $request)
    {
        $state->update($request->only(['code','state_code']));
        return [
            'message'=>'اطلاعات با موفقیت ویرایش گردید.'
        ];
    }

    public function DataTable(Request $request)
    {
        $model = State::query();
        return DataTables::eloquent($model)
            ->setRowAttr(['data-itemId' => '{{$id}}'])
            ->addColumn('sorting', function ($model) {
                return '<div class="sort_container"
                                    data-model="' . get_class($model) . '"
                                    data-database="mysql">
                                <a class="sort sort_handle_style1 ui-sortable-handle"><span class="hide">' . $model->position . '</span></a></div>';
            }, 0)
            ->editColumn('state_id',function ($model){
                return "<span class='label label-success'>{$model->state->name}</span>";
            })
            ->editColumn('code',function ($model){
                return "<input type='text' class='form-control' name='code' value='{$model->code}'>";
            })
            ->editColumn('state_code',function ($model){
                return "<input type='text' class='form-control' name='code' value='{$model->state_code}'>";
            })
            ->addColumn('update_button',function ($model){
                return "<button class='btn btn-update btn-primary btn-sm'>ویرایش</button>";
            })
            ->escapeColumns([])
            ->make(true);
    }
}