<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\Newsletter;

use DataTables;
use Maatwebsite\Excel\Facades\Excel;

class NewsletterController extends Controller
{

    public function index()
    {
        $items = [
            ["title" => __('content.management_newsletter'),"link" => route('admin.newsletter.index')]
        ];

        $header['list'] = ["title" => __('content.management_newsletter'),"description" => __('content.list_of_newsletter')];

        $data['newsletters'] = Newsletter::all();
        return view('admin.pages.newsletter.index', compact('items','header','data'));
    }

    public function export(Request $request)
    {
        $newsletters = Newsletter::select('email')->get();
        $time = time();
        Excel::create('newsletter-' . $time, function ($excel) use ($newsletters) {
            $excel->sheet('TestSheet', function ($sheet) use ($newsletters) {
                // Our first sheet
                $sheet->fromArray($newsletters, null, 'A1', false, false)
                    ->prependRow(1, array(
                        __('content.tbl_email'),
                    ))->setStyle(array(
                        'font' => array(
                            'name' => 'Tahoma',
                            'size' => 12,
                            'bold' => false
                        )
                    ));
            });
        })->export('xlsx');

        return redirect()->back()->with('msg', __('messages.add_item'));
    }

    function destroy(Request $request,$newsletter)
    {
        if($newsletter == "all"){
            $ids = $request->get('ids');
            Newsletter::whereIn('id', $ids)->delete();
        } else {
            Newsletter::find($newsletter)->delete();
        }
    }

    public function DataTable(Request $request)
    {
        $model = Newsletter::select(['id','email','created_at', 'updated_at', 'position']);
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
            ->escapeColumns([])
            ->make(true);
    }
}
