<?php

namespace App\Grid\Admin\Specific;




use SrkGrid\GridView\BaseGrid;
use SrkGrid\GridView\GridView;

class CreditGrid implements BaseGrid
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
            ['head' => 'شماره درخواست'],
            ['head' => 'نام درخواست کننده'],
            ['head' => 'مبلغ درخواست'],
            ['head' => 'تاریخ درخواست'],
            ['head' => 'شماره پیگیری'],
            ['head' => 'تاریخ تسویه'],
            ['head' => 'فعالیت','disableExcel'=>false],
        ])->rowIndex()
            ->addColumns('id')
            ->addColumns(function ($query) {
                return optional($query->user)->full_name;
            })
            ->addColumns('price')
            ->addColumns('request_at')
            ->addColumns('tracking_code')
            ->addColumns('done_at')
            ->addColumns(function ($query) {
                $editRoute = route('admin.profile.credit.request.edit',$query->id);
                $html = '';
                $html .= "<a class='btn_style3 blue' href='{$editRoute}'><i class='i-edit'></i></a>";

                return $html;
            })
            ->makeExcel('گزارش تسویه')
            ->renderGrid();
        return $grid;
    }
}
