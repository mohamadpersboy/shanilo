<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Base\Payment;
use App\Models\Base\Factor;
use App\Models\Base\User;

use DataTables;
use Smsir;

class FactorController extends Controller
{

    public function index()
    {
        $items = [
            ["title" => __('content.management_factor'),"link" => route('admin.factor.index')]
        ];
        $data['objects'] = Payment::where('pay_subject',1)->get();
        $data['users'] = User::whereHas('factors', function ($query) {
            $query->where('factor_subject', 1);
        })->get();
        $data['factors'] = Factor::where('factor_subject',1)->get();
        return view('admin.pages.factor.index', compact('items','data'));
    }

    public function edit($payment)
    {
        $payment = Payment::find($payment);
        $items = [
            ["title" => __('content.management_factor'),"link" => route('admin.factor.index')],
            ["title" => $payment->factor->title,"link" => "#"]
        ];
        return view('admin.pages.factor.edit', compact('items','payment','order'));
    }

    public function update(Request $request,Factor $factor)
    {
        if($request->has('pay_status')){
            Payment::where('factor_id',$factor->id)->update([
                'pay_status' => $request->get('pay_status'),
            ]);
            if($request->get('pay_status') == 2){
                $factor->factor_status = 2;
                $factor->save();
            } else {
                $factor->factor_status = 1;
                $factor->save();
            }
        }
        if($factor->visited == 3){
            if($request->get('visited') != 3){
                foreach ($factor->orders as $order) {
                    $cart = $order->model_name::find($order->model_id);
                    $cart->stock -= $order->quantity;
                    $cart->save();
                }
            }
        } else {
            if($request->get('visited') == 3){
                foreach ($factor->orders as $order) {
                    $cart = $order->model_name::find($order->model_id);
                    $cart->stock += $order->quantity;
                    $cart->save();
                }
            }
        }

if($request->get('visited') == 2 && $factor->visited != 2){
$mobileMessage = "خرید شما با شماره فاکتور ".$factor->title." پیگیری شد و به زودی همکاران ما برای هماهنگی بیشتر با شما تماس خواهند گرفت.
سوپرمارکت آنلاین آرادمال شیراز";
Smsir::sendToCustomerClub([$mobileMessage],[$factor->user->mobile]);
}

if($request->get('send_status') == 2 && $factor->send_status != 2){
$mobileMessage = "خرید شما با شماره فاکتور ".$factor->title." در مرحله ارسال قرار گرفت.
سوپرمارکت آنلاین آرادمال شیراز";
Smsir::sendToCustomerClub([$mobileMessage],[$factor->user->mobile]);
}

if($request->get('send_status') == 3 && $factor->send_status != 3){
$mobileMessage = "با تشکر از خرید شما
سوپرمارکت آنلاین آرادمال شیراز";
Smsir::sendToCustomerClub([$mobileMessage],[$factor->user->mobile]);
}
        
        $factor->update($request->all());
        return redirect()->back()->with('msg',__('messages.edit_item'));
    }

    function destroy(Request $request,$factor)
    {
        if($factor == "all"){
            $ids = $request->get('ids');
            Payment::whereIn('id', $ids)->delete();
        } else {
            Payment::find($factor)->delete();
        }
    }

    public function DataTable(Request $request)
    {
        if($visited = $request->get('visited')) {
            if($visited == 4){
                $model = Payment::where('pay_subject',1)->select(['id','price','pay_type','pay_subject','factor_id','user_id','created_at', 'updated_at']);
            } else {
                $model = Payment::whereHas('factor', function ($query)  use ($visited){
                    $query->where('visited', $visited);
                })->where('pay_subject',1)->select(['id','price','pay_type','pay_subject','factor_id','user_id','created_at', 'updated_at']);
            }
        } else {
            $model = Payment::whereHas('factor', function ($query) {
                $query->where('visited', 1);
            })->where('pay_subject',1)->select(['id','price','pay_type','pay_subject','factor_id','user_id','created_at', 'updated_at']);
        }

        $datatables = DataTables::eloquent($model)
            ->setRowAttr([
                'data-itemId' => function($model) {
                    return $model->id;
                },
                'data-status' => function($model) {
                    return $model->factor->visited;
                },
            ])
            ->addColumn('check', function ($model) {
                return '<label class="checkradio_style1 type2"><input type="checkbox" name="id[]" value="'.$model->id.'" data-select-row=""><span class="box"></span></label>';
            }, 1)
            ->addColumn('order_detail', function ($model) {
                return "شماره فاکتور: "."<br/>".$model->factor->title."<br/>".
                       " هزینه فاکتور: "."<i class='show_money_value'>".$model->price."</i> تومان";
            }, 1)
            ->addColumn('visited', function ($model) {
                if($model->factor->visited == 1) {
                    return '<span class="cl_blue">پیگیری نشده</span>';
                } elseif($model->factor->visited == 2){
                    return '<span class="cl_green2">پیگیری شده</span>';
                } else {
                    return '<span class="cl_red">لغو شده</span>';
                }
            }, 1)
            ->addColumn('order_user', function ($model) {
                return "نام کاربر: ".$model->user->fullName()."<br/>"." ایمیل کاربر: ".$model->user->email;
            }, 1)
            ->editColumn('created_at', '{{ShowDate($created_at)}} <br> {{ShowTime($created_at)}}')
            ->editColumn('pay_type', function ($model) {
                if($model->pay_type == 1) {
                    return '<span class="cl_blue">پرداخت آنلاین</span>';
                } elseif($model->pay_type == 2) {
                    return '<span class="cl_green2">پرداخت در محل</span>';
                } else {
                    return '<span class="cl_green2">پرداخت با موجودی</span>';
                }
            }, 1)
            ->addColumn('edit', function ($model) {
                return '<a href="'.route('admin.factor.edit',$model->id).'" class="btn_style3 blue"><i class="icon i-search"></i></a>';
            })
            ->escapeColumns([]);

        if ($factor_id = $datatables->request->get('factor_id')) {
            $datatables->where('factor_id', $factor_id);
        }

        if ($user_id = $datatables->request->get('user_id')) {
            $datatables->where('user_id', $user_id);
        }

        if ($pay_type_id = $datatables->request->get('pay_type_id')) {
            $datatables->where('pay_type', $pay_type_id);
        }

        return $datatables->make(true);
    }
}
