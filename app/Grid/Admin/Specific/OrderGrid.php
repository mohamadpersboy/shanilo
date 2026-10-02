<?php

namespace App\Grid\Admin\Specific;

use SrkGrid\GridView\BaseGrid;
use SrkGrid\GridView\GridView;

class OrderGrid implements BaseGrid
{
    /**
     * Render method for get html view result
     *
     * @param GridView $grid
     * @param $data
     * @param $parameters
     * @return mixed
     */
    public function render($grid, $data, $parameters = null)
    {
        $check = auth()->user()->can('update.order');
        return $grid->headerColumns([
            ['head' => 'شماره سفارش'],
            ['head' => 'نام مشتری'],
            ['head' => 'پرداخت شده'],
            ['head' => 'وضعیت', 'disableExcel' => false],
            ['head' => 'وضعیت', 'disable' => false],
            ['head' => 'وضعیت پرداخت', 'disableExcel' => false],
            ['head' => 'وضعیت پرداخت', 'disable' => false],
            ['head' => 'نوع پرداخت'],
            ['head' => trans('content.tbl_creation_date')],
            ['head' => 'نمایش بعنوان مشتری', 'disable' => ($check) ?: false, 'disableExcel' => false],
            ['head' => 'نمایش بعنوان فروشگاه', 'disable' => ($check) ?: false, 'disableExcel' => false],
        ])
            ->addColumns('id')
            ->addColumns(function ($query) {
                return getUsersFullName($query->user);
            })
            ->addColumns(function ($model) {
                return showPrice($model->total);
            })
            ->addColumns(function ($query) {
                $statuses = [
                    0 => '<span class="label label-danger">کنسل</span>',
                    1 => '<span class="label label-warning">ثبت شد</span>',
                    2 => '<span class="label label-info">تایید شد</span>',
                    3 => '<span class="label label-default">تماس بین مشتری و کاربر</span>',
                    4 => '<span class="label label-info">ارسال شد</span>',
                    5 => '<span class="label label-success">دریافت شد</span>',
                ];
                return $statuses[$query->status];
            })
            ->addColumns(function ($query) {
                $statuses = [
                    0 => 'کنسل',
                    1 => 'ثبت شد',
                    2 => 'تایید شد',
                    3 => 'تماس بین مشتری و کاربر',
                    4 => 'ارسال شد',
                    5 => 'دریافت شد',
                ];
                return $statuses[$query->status];
            })
            ->addColumns(function ($query) {
                $statuses = [
                    'pending' => '<span class="label label-warning">درانتظار پرداخت</span>',
                    'successful' => '<span class="label label-success">موفق</span>',
                    'unsuccessful' => '<span class="label label-danger">ناموفق</span>',
                ];
                return $statuses[$query->payment->status];
            })
            ->addColumns(function ($query) {
                $statuses = [
                    'pending' => 'درانتظار پرداخت',
                    'successful' => 'موفق',
                    'unsuccessful' => 'ناموفق',
                ];
                return $statuses[$query->payment->status];
            })
            ->addColumns(function ($query) {
                return $query->payment->payType->title;
            })
            ->addColumns('created_at')
            ->addColumns(function ($query) {
                return '<a href="' . route('admin.order.showAsUser', $query->id) . '" class="btn_style3 blue" target="_blank"><i class="icon-eye2"></i></a>';
            })
            ->addColumns(function ($query) {
                return '<a href="' . route('admin.order.showAsSeller', $query->id) . '" class="btn_style3 blue" target="_blank"><i class="icon-eye2"></i></a>';
            })
            ->makeExcel('گزارش سفارشات')
            ->renderGrid();
    }
}
