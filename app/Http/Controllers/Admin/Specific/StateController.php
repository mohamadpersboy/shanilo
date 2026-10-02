<?php

namespace App\Http\Controllers\Admin\Specific;

use App\Models\Base\State;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StateController extends Controller
{
    public function index()
    {
        $items = [
            ["title" => 'مدیریت استانها', "link" => route('admin.state.index')]
        ];
        $data = [
            'items' => $items,
            'states' => State::count()
        ];
        return view('admin.specific.state.index', $data);
    }

    public function update(State $state,Request $request)
    {
        $state->update($request->only('code'));
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
                ->editColumn('code',function ($model){
                    return "<input type='text' class='form-control' name='code' value='{$model->code}'>";
                })
                ->addColumn('update_button',function ($model){
                    return "<button class='btn btn-update btn-primary btn-sm'>ویرایش</button>";
                })
                ->escapeColumns([])
                ->make(true);
        }
}