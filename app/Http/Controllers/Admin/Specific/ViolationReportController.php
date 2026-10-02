<?php

namespace App\Http\Controllers\Admin\Specific;

use App\Models\Specific\ViolationReport;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ViolationReportController extends Controller
{
    public function index()
    {
        $items = [
            ["title" => 'مدیریت گزارشات تخلف', "link" => route('admin.violationReport.index')]
        ];
        $data = [
            'items' => $items,
            'violationReports' => ViolationReport::count()
        ];
        return view('admin.specific.violationreport.index', $data);
    }

    public function update(ViolationReport $violationReport, Request $request)
    {
        $violationReport->update($request->all());
        if (!$request->ajax()) {
            return back()->with('msg', __('messages.edit_item'));
        }
    }

    public function destroy(Request $request, $violationReport)
    {
        $violationReports = ViolationReport::find($request->input('ids'));
        foreach ($violationReports as $index => $violationReport) {
            $violationReport->delete();
        }
    }

    public function DataTable(Request $request)
    {

        $model = ViolationReport::latest();
        return DataTables::eloquent($model)
            ->setRowAttr(['data-itemId' => '{{$id}}'])
            ->addColumn('sorting', function ($model) {
                return '<div class="sort_container"
                                data-model="' . get_class($model) . '"
                                data-database="mysql">
                            <a class="sort sort_handle_style1 ui-sortable-handle"><span class="hide">' . $model->position . '</span></a></div>';
            }, 0)
            ->addColumn('check', function ($model) {
                return '<label class="checkradio_style1 type2"><input type="checkbox" name="id[]" value="' . $model->id . '" data-select-row=""><span class="box"></span></label>';
            }, 1)
            ->addColumn('type', function ($model) {
                $str = $model->seen ? '' : '<span data-url="' . route('admin.violationReport.update', $model) . '" style="margin-left: 5px;" class="label label-info">جدید</span>';
                $str .= $model->reportable ? $model->reportable->getPersianName()['name'] : '-';
                return $str;
            })
            ->addColumn('user_id', function ($model) {
                return getUsersFullName($model->user);
            })
            ->addColumn('title', function ($model) {
                return $model->reportable ? $model->reportable->getPersianName()['title'] : '-';
            })
            ->addColumn('url', function ($model) {
                return $model->reportable ? "<a target='_blank' href=" . $model->reportable->getPersianName()['url'] . " class='btn_style3 blue'><i class='icon-eye2'></i></a>" : '-';
            })
            ->editColumn('created_at', '{{ShowDate($created_at)}} <br> {{ShowTime($created_at)}}')
            ->addColumn('show', function ($model) {
                $view = \View::make('admin.specific.violationreport.show', ['violationReport' => $model])->render();
                return '<a href="#" class="btn_style3 blue"><i class="icon i-letter-mail-1 show_msg"></i></a>
                        <div class="data_msg">' . $view . '</div>';
            })
            ->escapeColumns([])
            ->make(true);
    }

}
