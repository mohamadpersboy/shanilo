<?php

namespace App\Grid\Admin;

use SrkGrid\GridView\BaseGrid;
use SrkGrid\GridView\GridView;

class SocialNetworkGrid implements BaseGrid
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
            ['head'=>'عنوان'],
            ['head'=>'لینک'],
            ['head'=>'ایکون'],
            ['head'=>'فالوور'],
            ['head'=>'فعالیت'],
        ])
        ->addColumns('title')
        ->addColumns('link')
        ->addColumns(function ($query) {
            return "<img width=50px height=50px src={$query->icon}>";
        })
        ->addColumns('follower')
        ->addColumns(function ($query) {
            $url = route('social_network.delete', $query->id);
            return "<a data-url='{$url}' style='color:red' class='pointer delete-image'>حذف</a>";
        })
        ->renderGrid();
    }
}
