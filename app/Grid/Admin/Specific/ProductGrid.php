<?php

namespace App\Grid\Admin\Specific;

use App\Models\Specific\Product;
use Morilog\Jalali\jDate;
use SrkGrid\GridView\BaseGrid;
use SrkGrid\GridView\GridView;

class ProductGrid implements BaseGrid
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
        $updateProduct = auth()->user()->can('update.product');
        $deleteProduct = auth()->user()->can('delete.product');
        return $grid->headerColumns([
            ['disable' => $deleteProduct ? true : false, 'head' => '<label class="checkradio_style1 type2"><input type="checkbox" name="" data-select-all="data-select-row"><span class="box"></span></label>'],
            ['head' => 'عکس'],
            ['head' => 'عنوان'],
            ['head' => 'فروشگاه'],
            ['head' => 'تاریخ ایجاد'],
            ['head' => 'تاریخ ویرایش'],
            ['head' => 'وضعیت'],
            ['head' => 'نمایش', 'disable' => $updateProduct ? true : false],
            ['head' => 'ویرایش','disable' => $updateProduct ? true : false],
        ])
            ->addColumns(function ($model) {
                return '<label class="checkradio_style1 type2"><input type="checkbox" name="id[]" value="' . $model->id . '" data-select-row=""><span class="box"></span></label>';
            })
            ->addColumns(function ($model) {
                return '<img src="' . $model->takeImage('main', '60/60') . '"/>';
            })
            ->addColumns('title')
            ->addColumns(function ($model) {
                return $model->shop->title;
            })
            ->addColumns(function ($model) {
                return jDate::forge($model->created_at)->format('Y/m/d H:i');
            })
            ->addColumns(function ($model) {
                return jDate::forge($model->updated_at)->format('Y/m/d H:i');
            })
            ->addColumns(function ($model) {
                return '<label class="checkradio_style2 switchery-sm">
                               <input name="display" type="checkbox" class="js-switch switch_for_all"
                               data-id="' . $model->id . '"
                               data-model="' . get_class($model) . '"
                               data-database="mysql"
                               data-link="' . route('admin.switch.update', $model->id) . '"
                               value="1" ' . ($model->display == 1 ? 'checked="checked"' : '') . ' >
                            </label>';
            })
            ->addColumns(function ($model) {
                return '<a target="_blank" href="' . route('admin.product.show', $model->id) . '" class="btn_style3 blue"><i class="icon-eye2"></i></a>';
            })
            ->addColumns(function ($model) {
                return '<a href="' . route('admin.product.edit', $model->id) . '" class="btn_style3 blue"><i class="i-edit"></i></a>';
            })
            ->renderGrid();
    }
}
