<?php
/**
 * Created by PhpStorm.
 * User: TD-PLUS
 * Date: 11/13/2018
 * Time: 12:26 PM
 */

namespace App\Http\Helpers\Comparison;

use App\Models\Specific\Comparison as ComparisonModel;
use App\Interfaces\CookieBaseModels;
use App\Models\Specific\ComparisonDetail;

class Comparison implements CookieBaseModels
{
    protected $comparison;

    public function __construct($comparisonId)
    {
        if ($comparisonId) {
            if ($comparison = ComparisonModel::find($comparisonId)) {
                $this->comparison = $comparison;
            } else {
                $this->comparison = $this->make();
            }
        } else {
            $this->comparison = $this->make();
        }
    }

    public function get()
    {
        return $this->favorite;
    }

    public function make()
    {
        $comparison = ComparisonModel::create();
        \Cookie::queue('comparison', $comparison->id);
        return $comparison;
    }

    public function details()
    {
        return ComparisonDetail::where('comparison_id', $this->comparison->id)->orderBy('created_at','desc')->get();
    }

    public function has($object)
    {
        return $this->comparison->details()->where('product_id', $object->id)->exists();
    }

    public function add($object)
    {
        $deletedItems=[];
        if($this->count()>=3){
            $deletedItem=$this->comparison->details()->limit(1)->first();
            $deletedItems[]=$deletedItem;
            $deletedItem->delete();
        }
        if(!$this->isAddable($object)) {
            $deletedItems=$this->details();
            $this->clear();
        }
        $this->comparison->details()->create([
            'product_id'=>$object->id
        ]);
        return $deletedItems;
    }

    public function remove($object)
    {
        return $this->comparison->details()->where('product_id', $object->id)->delete();
    }

    public function count()
    {
        return $this->comparison->details()->count();
    }

    protected function isAddable($object)
    {
        if ($this->count()) {
            $product = $this->comparison->details()->first()->product;
            $arry1=$product->productCategoryTechnicalSpecifications()->pluck('technical_specification_id')->toArray();
            $arry2= $object->productCategoryTechnicalSpecifications()->pluck('technical_specification_id')->toArray();
            return !array_diff($arry1,$arry2) && !array_diff($arry2,$arry1);
        }
        return true;
    }

    protected function clear()
    {
        $this->comparison->details()->delete();
    }
}
