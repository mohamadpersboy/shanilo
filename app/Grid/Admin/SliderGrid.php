<?php

namespace App\Grid\Admin;

use SrkGrid\GridView\BaseGrid;
use SrkGrid\GridView\GridView;

class SliderGrid implements BaseGrid
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
            ['head'=>'عکس '],
            ['head'=>'نوع عکس'],
            ['head'=>'لینک'],
            ['head'=>'فعالیت'],
        ])
        ->addColumns(function ($query) {
            $url = url('storage/app/public/'.$query->path);
            return "<img height=100px width=100px src='{$url}'>";
        })
        ->addColumns(function ($query) {
            switch ($query->type) {
                case 'desktop':
                    return 'تصویر دسکتاپ';
                break;
                case 'mobile':
                    return 'تصویر موبایل';
                break;
                case 'min_image':
                    return 'تصویر کوچک';
                break;
            }
        })
        ->addColumns(function($query){
            return "<a href='{$query->link}'>{$query->link}</a>";
        })
        ->addColumns(function ($query) {
            $deleteRoute = route('slider.delete', $query->id);
            return "<span class='delete-image pointer' style='color:red' data-url={$deleteRoute}>حذف</span>";
        })->renderGrid();
    }
}
