<?php

namespace App\Http\Controllers\Admin\Specific;

use App\Grid\Admin\Specific\CreditGrid;
use App\Models\RequestCheckoutCredit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SrkGrid\GridView\Grid;

class CreditController extends Controller
{
    /**
     * Show request credit
     *
     * @author Reza Sarlak
     * @return \Response
     */
    public function index()
    {
        $data = RequestCheckoutCredit::with(['user'])->latest('id');

        $grid = Grid::make(CreditGrid::class, $data);

        $items = [["title" => 'مدیریت درخواست تسویه']];

        $data = [
            'items' => $items,
            'grid' => $grid
        ];

        return view('admin.pages.request_checkout_credit.index', $data);
    }

    /**
     * Show form request
     *
     * @param RequestCheckoutCredit $credit
     * @return \Response
     */
    public function edit(RequestCheckoutCredit $credit)
    {
        return view('admin.pages.request_checkout_credit.form', compact('credit'));
    }

    /**
     * Update status request
     *
     * @param Request $request
     * @param RequestCheckoutCredit $credit
     * @return \Response
     */
    public function update(Request $request, RequestCheckoutCredit $credit)
    {
        /** VERY IMPORTANT */
        /* This condition reason :
        /* because  use observe ->  next status done Fire this action ( credit - requestPrice = new credit)
        */
        if ($credit->status == 'done') {
            session()->flash('err', 'این درخواست قبلا تسویه شده است و شما دیگر نمیتوانید روی آن عملی انجام دهید');
            return redirect()->back();
        }

        $request->validate([
            'status' => 'required',
            'tracking_code' => 'required_if:status,done'
        ], [
            'tracing_code.required_if' => 'در صورتی که وضعیت برابر تسویه باشد باید کرد پیگیری را واردنمایید . '
        ]);

        ($credit->update(['status' => $request->status, 'tracking_code' => $request->tracking_code, 'done_at' => $request->status == 'done' ? now() : null]));

        return redirect()->back();
    }
}
