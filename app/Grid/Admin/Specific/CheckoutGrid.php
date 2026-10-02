<?php

namespace App\Grid\Admin\Specific;


use SrkGrid\GridView\BaseGrid;
use SrkGrid\GridView\GridView;

class CheckoutGrid implements BaseGrid
{

    /**
     * Render method for get html view result
     *
     * @param GridView $grid
     * @param $data
     * @param $localization
     * @return mixed
     */
    public function render($grid, $data, $localization = null)
    {
        $grid = $grid->headerColumns([
            ['head' => 'فروشگاه'],
            ['head' => 'مبلغ'],
            ['head' => 'وضعیت'],
            ['head' => 'کدپیگیری'],
            ['head' => 'تاریخ ایجاد'],
            ['head' => 'تاریخ ویرایش'],
            ['head' => 'ویرایش', 'disableExcel' => false],
        ])
            ->addColumns(function ($query) {
                return $query->wallet->shop->title;
            })
            ->addColumns('format_price')
            ->addColumns(function ($query) {
                switch ($query->status) {
                    case 'done':
                        $condition = '<label class="label label-success">' . $query->condition_checkout . '</label>';
                        break;
                    case 'pending':
                        $condition = '<label class="label label-warning">' . $query->condition_checkout . '</label>';
                        break;
                    case 'denied':
                        $condition = '<label class="label label-danger">' . $query->condition_checkout . '</label>';
                        break;
                }
                return $condition;
            })
            ->addColumns('tracking_code')
            ->addColumns('created_jalali')
            ->addColumns('updated_jalali')
            ->addColumns(function ($query) {
                $html = "";
                $routeEdit = route('admin.checkout.edit', $query->id);
                $html .= "<a href='{$routeEdit}' class='btn_style3 blue'><i class='i-edit'></i></a>";
                return $html;
            })
            ->makeExcel('گزارش تسویه فروشگاه')
            ->renderGrid();

        return $grid;
    }
}
