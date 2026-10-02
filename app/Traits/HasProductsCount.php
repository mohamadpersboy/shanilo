<?php
/**
 * Created by PhpStorm.
 * User: milad
 * Date: 7/11/2018
 * Time: 11:19 AM
 */

namespace App\Traits;


use App\Models\Specific\MainCategory;
use Illuminate\Database\Eloquent\Builder;

trait HasProductsCount
{
    public function getProductsCount(MainCategory $mainCategory = null)
    {
        if (!$mainCategory) {
            return $this->products->count();
        }
        return $this->products()->whereHas('productCategory', function (Builder $builder) use ($mainCategory) {
            $builder->whereHas('mainCategory',function (Builder $builder)use ($mainCategory){
                if($mainCategory->children->count()){
                    $builder->whereHas('parent',function (Builder $builder)use ($mainCategory){
                        $builder->where('id',$mainCategory->id);
                    });
                }else{
                    $builder->where('id',$mainCategory->id);
                }
            });
        })->count();
    }
}