<?php

namespace App\Http\Controllers\Admin\Specific;

use App\Models\Base\PayType;
use App\Models\Base\User;
use App\Models\Specific\FirstPageSpecialSell;
use App\Models\Specific\FirstPageSpecialSuggestion;
use App\Models\Specific\Order;
use App\Models\Specific\Payment;
use App\Models\Specific\SpecialSell;
use App\Models\Specific\SpecialSuggestion;
use DataTables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    const TYPES=[
        Order::class=>'سفارش',
        User::class=>'شارژ موجودی',
        FirstPageSpecialSell::class=>'فروش ویژه',
        FirstPageSpecialSuggestion::class=>'پیشنهاد ویژه'
    ];
    public function index()
    {
        $items = [
            ["title" => 'مدیریت سفارشات', "link" => route('admin.payment.index')]
        ];
        $data = [
            'items' => $items,
            'payments' => Payment::count(),
            'payTypes'=>PayType::orderBy('position')->get(),
            'types'=>self::TYPES
        ];
        return view('admin.specific.payment.index', $data);
    }

    public function DataTable(Request $request)
    {
        $model = $this->setFilters($request);
        return DataTables::eloquent($model)
            ->setRowAttr(['data-itemId' => '{{$id}}'])
            ->editColumn('status', function ($model) {
                $statuses = [
                    'pending' => '<span class="label label-warning">در انتظار پرداخت</span>',
                    'successful' => '<span class="label label-success">موفق</span>',
                    'unsuccessful' => '<span class="label label-danger">ناموفق</span>',
                ];
                return $statuses[$model->status];
            }, 1)
            ->editColumn('pay_type_id', function ($model) {
                return $model->payType->title;
            }, 1)
            ->editColumn('payable_type', function ($model) {

                return isset(self::TYPES[$model->payable_type])?self::TYPES[$model->payable_type]:'نامشخص';
            }, 1)
            ->editColumn('display', function ($model) {
                return '<label class="checkradio_style2 switchery-sm"><input name="display" type="checkbox" class="js-switch switch_for_all"
                               data-id="' . $model->id . '"
                               data-model="' . get_class($model) . '"
                               data-database="mysql"
                               data-link="' . route('admin.switch.update', $model->id) . '"
                               value="1" ' . ($model->display == 1 ? 'checked="checked"' : '') . ' >
                            </label>';
            }, 1)
            ->editColumn('created_at', '{{ShowDate($created_at)}} <br> {{ShowTime($created_at)}}')
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setFilters(Request $request)
    {
        $query = Payment::query()->orderBy('created_at','desc');
        if($payableType=$request->get('payable_type')){
            $query->where('payable_type',$payableType);
        }

        if ($payTypeId = $request->get('pay_type_id')) {
            $query->where('pay_type_id', $payTypeId);
        }
        if ($transactionId = $request->get('transaction_id')) {
            $query->where('transaction_id', $transactionId);
        }
        if ($trackingCode = $request->get('tracking_code')) {
            $query->where('tracking_code', $trackingCode);
        }
        if ($dateFrom = $request->get('date_from')) {
            $query->where('created_at', '>=', jalaliToCarbon($dateFrom));
        }
        if ($dateTo = $request->get('date_to')) {
            $query->where('created_at', '<=', jalaliToCarbon($dateTo));
        }
        if ($refId = $request->get('ref_id')) {
            $query->where('ref_id', '<=', jalaliToCarbon($refId));
        }
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }
        return $query;
    }
}
