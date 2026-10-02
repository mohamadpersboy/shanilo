<?php

namespace App\Http\Controllers\Admin\Specific;

use App\Grid\Admin\Specific\CheckoutGrid;
use App\Models\Specific\Checkout;
use App\Models\Specific\Shop;

use App\Models\Specific\WalletTransaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;
use SrkGrid\GridView\Grid;

class CheckoutController extends Controller
{
    public function index()
    {
        $data = Checkout::with(['wallet.shop'])->latest();

        $view = Grid::make(CheckoutGrid::class, $data);

        $items = [
            ["title" => 'مدیریت درخواست های تسویه', "link" => route('admin.checkout.index')]
        ];

        $data = [
            'items' => $items,
            'checkouts' => Checkout::count(),
            'shops' => Shop::orderBy('title')->get(),
            'view'=>$view
        ];
        return view('admin.specific.checkout.index', $data);
    }

    public function edit(Checkout $checkout)
    {
        $items = [
            ["title" => 'مدیریت درخواست های تسویه', "link" => route('admin.checkout.index')],
            ["title" => 'ویرایش درخواست تسویه', "link" => route('admin.checkout.edit', $checkout)],
        ];
        $data = [
            'items' => $items,
            'checkout' => $checkout,
            'edit' => true,
        ];
        return view('admin.specific.checkout.edit', $data);
    }

    public function update(Checkout $checkout, Request $request)
    {
        $this->validator($request);
        if ($request->get('status') == 'done') {
            $checkout->update($request->only(['status', 'tracking_code']));
        } else {
            $checkout->update($request->only(['status']));
        }
        return redirect()->route('admin.checkout.index');
    }

    public function export(Request $request)
    {
        $checkouts = $this->setFilters($request)->get();
        $data = [];
        $statuses = [
            'done' => "تسویه شد",
            'pending' => "در انتظار تسویه",
            'denined' => "رد شد",
        ];
        foreach ($checkouts as $checkout) {
            $data[] = [
                $checkout->wallet->shop->title,
                showPrice($checkout->price),
                $statuses[$checkout->status],
                $checkout->tracking_code,
                ShowDate($checkout->created_at) . ' ' . ShowTime($checkout->created_at)
            ];
        }
        $time = time();
        Excel::create('checkouts-' . $time, function ($excel) use ($data) {
            $excel->sheet('TestSheet', function ($sheet) use ($data) {
                // Our first sheet
                $sheet->fromArray($data, null, 'A1', false, false)
                    ->prependRow(1, array(
                        'فروشگاه',
                        'مبلغ',
                        'وضعیت',
                        'کدپیگیری',
                        'تاریخ ایجاد',
                    ))->setRightToLeft(true)
                    ->setStyle(array(
                        'font' => array(
                            'name' => 'Tahoma',
                            'size' => 12,
                            'bold' => false
                        ),
                        'dir' => 'rtl'
                    ));
            });
        })->export('xlsx');
    }


    protected function setFilters(Request $request)
    {
        $query = Checkout::query();
        if ($shopId = $request->get('shop_id')) {
            $query->whereHas('wallet', function (Builder $builder) use ($shopId) {
                $builder->where('shop_id', $shopId);
            });
        }
        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }
        if ($trackingCode = $request->get('tracking_code')) {
            $query->where('tracking_code', $trackingCode);
        }
        if ($request->get('date_from')) {
            $query->where('created_at', '>=', jalaliToCarbon($request->get('date_from')));
        }
        if ($request->get('date_to')) {
            $query->where('created_at', '<=', jalaliToCarbon($request->get('date_to')));
        }
        return $query;
    }

    protected function validator(Request $request)
    {
        $this->validate($request, [
            'tracking_code' => 'required_if:status,done',
        ], [
            'tracking_code.required_if' => 'کد پیگیری الزامیست.',
        ]);

    }
}
