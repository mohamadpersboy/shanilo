<?php

namespace App\Grid\Admin;

use SrkGrid\GridView\BaseGrid;
use SrkGrid\GridView\GridView;

class ProductMessageGrid implements BaseGrid
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
            ['head' => 'کاربر'],
            ['head' => 'شرح'],
        ])->addColumns(function ($query) {
            return optional($query->user)->name . ' ' . optional($query->user)->family;
        })->addColumns('description')
            ->renderGrid();
    }
}
