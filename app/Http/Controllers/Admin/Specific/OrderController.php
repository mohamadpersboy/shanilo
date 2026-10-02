<?php

namespace App\Http\Controllers\Admin\Specific;

use App\Grid\Admin\Specific\OrderGrid;
use App\Models\Specific\Order;
use DataTables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SrkGrid\GridView\Grid;

class OrderController extends Controller
{
    const STATUSES = [
        0 => 'کنسل',
        1 => 'ثبت شد',
        2 => 'تایید شد',
        3 => 'تماس بین مشتری و کاربر',
        4 => 'ارسال شد',
        5 => 'دریافت شد',
    ];
    const  PAYMENT_STATUSES = [
        'successful' => 'موفق',
        'unsuccessful' => 'ناموفق',
        'pending' => 'در انتظار پرداخت',
    ];

    public function index()
    {
        $items = [
            ["title" => 'مدیریت سفارشات', "link" => route('admin.order.index')]
        ];

        $view = Grid::make(OrderGrid::class, $this->setFilters(request()));

        $data = [
            'items' => $items,
            'orders' => Order::count(),
            'view' => $view
        ];
        return view('admin.specific.order.index', $data);
    }

    public function showAsUser(Order $order)
    {
        auth()->login($order->user);
        return redirect()->route('front.profile.order.show', $order);
    }

    public function showAsSeller(Order $order)
    {
        auth()->login($order->shop->user);
        return redirect()->route('front.profile.order.show', $order);
    }

    /**
     * @param Request $request
     * @return Builder
     */
    protected function setFilters(Request $request)
    {
        $query = Order::query();
        if ($request->get('name')) {
            $query->whereHas('user', function (Builder $builder) use ($request) {
                $builder->where('name', $request->get('name'));
            });
        }
        if ($request->get('family')) {
            $query->whereHas('user', function (Builder $builder) use ($request) {
                $builder->where('family', $request->get('family'));
            });
        }
        if ($request->get('mobile')) {
            $query->whereHas('user', function (Builder $builder) use ($request) {
                $builder->where('mobile', $request->get('mobile'));
            });
        }
        if ($request->get('order_id')) {
            $query->where('id', $request->get('order_id'));
        }
        if ($request->get('status')) {
            $query->where('status', $request->get('status'));
        }
        if ($request->get('payment_type')) {
            $query->whereHas('payment', function (Builder $builder) use ($request) {
                $builder->whereHas('payType', function (Builder $builder) use ($request) {
                    $builder->where('type', $request->get('payment_type'));
                });
            });
        }
        if ($request->get('payment_status')) {
            $query->whereHas('payment', function (Builder $builder) use ($request) {
                $builder->where('status', $request->get('payment_status'));
            });
        }
        if ($request->get('date_from')) {
            $query->where('created_at', '>=', jalaliToCarbon($request->get('date_from')));
        }
        if ($request->get('date_to')) {
            $query->where('created_at', '<=', jalaliToCarbon($request->get('date_to')));
        }
        if ($trackingCode = $request->get('tracking_code')) {
            $query->whereHas('payment', function (Builder $builder) use ($trackingCode) {
                $builder->where('tracking_code', $trackingCode);
            });
        }
        return $query;
    }


}
