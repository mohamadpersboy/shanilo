<?php

namespace App\Grid\Front\Profile;

use SrkGrid\GridView\BaseGrid;
use SrkGrid\GridView\GridView;

class CreditLogGrid implements BaseGrid
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
        return $grid->headerColumns([
            ['head' => 'شناسه تراکنش'],
            ['head' => 'مبلغ'],
            ['head' => 'نوع'],
            ['head' => 'تاریخ']
        ])
            ->addColumns('id')
            ->setParentTableAttribute(['class' => 'table_style1'])
            ->setTerminateGet()
            ->addColumns(function ($query) {
                $price = showPrice($query->price, null, null);
                if ($query->status == 'decrease') {
                    return "<span class='price sub'>{$price}</span>";
                } else {
                    return "<span class='price add'>{$price}</span>";
                }
            })
            ->addColumns(function ($query) {
                switch ($query->type) {
                    case 'charge':
                        return 'شارژ کیف پول';
                        break;
                    case 'request checkout':
                        return 'درخواست تسویه';
                        break;
                    case 'payment':
                        return 'خرید';
                        break;
                    case 'shop cancel':
                        return 'کنسل کردن خرید توسط فروشگاه';
                        break;
                    case 'customer cancel':
                        return 'کنسل کردن خرید توسط مشتری';
                        break;
                }
            })
            ->addColumns(function ($query) {
                return show_persian_with_month($query->created_at);
            })
            ->renderGrid();
    }
}
