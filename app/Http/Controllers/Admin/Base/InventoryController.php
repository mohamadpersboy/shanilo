<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\Payment;
use App\Models\Base\User;

use DataTables;

class InventoryController extends Controller
{

    public function index()
    {
        $items = [
            ["title" => __('content.management_inventory'),"link" => "#"],
            ["title" => "لیست درخواست های افزایش موجودی","link" => "#"],
        ];
        $data['objects'] = Payment::where('pay_subject',2)->get();
        return view('admin.pages.inventory.index', compact('items','data'));

    }

    public function edit($inventory)
    {
        $inventory = Payment::find($inventory);
        $items = [
            ["title" => __('content.management_inventory'),"link" => route('admin.inventory.index',$inventory->pay_status)],
            ["title" => "درخواست افزایش موجودی به نام".$inventory->account_name,"link" => "#"]
        ];
        return view('admin.pages.inventory.edit', compact('items','inventory'));
    }

    public function update(Request $request, $inventory)
    {
        $update = Payment::find($inventory);
        if($update->pay_status != 2){
            Payment::find($inventory)->update([
                'pay_status' => $request->get('pay_status'),
                'description' => $request->get('description'),
            ]);
            if($request->get('pay_status') == 2){
                User::find($update->user_id)->update([
                    'balance' => $update->user->balance + str_replace(',','',$update->price),
                ]);
            }
            return redirect()->back()->with('msg',__('messages.edit_item'));
        } else {
            return redirect()->back()->with('msg','این درخواست قبلا تایید شده است.');
        }
    }

    function destroy(Request $request,$inventory)
    {
        if($inventory == "all"){
            $ids = $request->get('ids');
            Payment::whereIn('id', $ids)->delete();
        } else {
            Payment::find($inventory)->delete();
        }
    }

    public function DataTable(Request $request)
    {
        $model = Payment::where('pay_subject',2)->select(['id','price','pay_status','account_name','card_code','tracking_code','deposit_date','source_bank_name','admin_bank_id','created_at']);
        $datatables = DataTables::eloquent($model)
            ->setRowAttr(['data-itemId' => '{{$id}}','data-status' => '{{$pay_status}}'])
            ->addColumn('check', function ($model) {
                return '<label class="checkradio_style1 type2"><input type="checkbox" name="id[]" value="'.$model->id.'" data-select-row=""><span class="box"></span></label>';
            }, 1)
            ->addColumn('price', function ($model) {
                return '<i data-mvwc>'.$model->price.'</i>';
            })
            ->editColumn('pay_status', function ($model) {
                if($model->pay_status == 1) {
                    return '<span class="cl_blue">در انتظار تائید</span>';
                } elseif($model->pay_status == 2){
                    return '<span class="cl_green2">تایید شده</span>';
                } else {
                    return '<span class="cl_red">تایید نشده</span>';
                }
            }, 1)
            ->editColumn('created_at', '{{ShowDate($created_at)}} <br> {{ShowTime($created_at)}}')
            ->addColumn('edit', function ($model) {
                return '<a href="'.route('admin.inventory.edit',$model->id).'" class="btn_style3 blue"><i class="icon i-search"></i></a>';
            })
            ->escapeColumns([]);

        if ($status = $datatables->request->get('status')) {
            if($status == 4) {
                $datatables->where('pay_status', '<','4');
            } else {
                $datatables->where('pay_status', $status);
            }
        } else {
            $datatables->where('pay_status', 1);
        }

        return $datatables->make(true);
    }
}
