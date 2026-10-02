<?php

namespace App\Grid\Admin\Specific;

use SrkGrid\GridView\BaseGrid;
use SrkGrid\GridView\GridView;

class ShopGrid implements BaseGrid
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
        $permissionUpdate = auth()->user()->can('update.shop');
        $permissionDelete = auth()->user()->can('delete.shop');

        return $grid->headerColumns([
            ['head' => '<input type="checkbox" class="check-all">', 'disable' => $permissionDelete ? true : false],
            ['head' => 'عکس'],
            ['head' => 'عنوان'],
            ['head' => 'تاریخ ایجاد'],
            ['head' => 'تاریخ ویرایش'],
            ['head' => 'نمایش', 'disable' => $permissionUpdate ? true : false],
        ])
            ->addColumns(function ($query) {
                return '<input class="delete-select" type="checkbox" name="id[]" value="' . $query->id . '" data-select-row="">';
            })
            ->addColumns(function ($query) {
                return '<img src="' . $query->takeImage('avatar', '60/60') . '"/>';
            })
            ->addColumns('title')
            ->addColumns('created_at')
            ->addColumns('updated_at')
            ->rowIndex()
            ->addColumns(function ($query) {
                return '<a target="_blank" href="' . route('admin.shop.show', $query->id) . '" class="btn_style3 blue"><i class="icon-eye2"></i></a>';
            })
            ->renderGrid();
    }
}
