<?php
namespace App\Http\Helpers;

use App\Models\Specific\CartDetail;

class PostApi {

    public function price($products)
    {
        
        $products=array_filter($products,function ($w){
            return is_numeric($w) && $w<=50;
        });
       
        $products = array_reverse(array_sort(array_values($products)));
        $weights = [];
        foreach ($products as $index => $product) {
            if ($product >= 30) {
                array_push($weights, $product);
            } else {
                $weights = array_values(array_sort($weights));
                try {
                    $min = $weights[0];
                    $sum = $min + $product;
                    if ($sum <= 30) {
                        $weights[0] = $sum;
                    } else {
                        array_push($weights, $product);
                    }
                } catch (\Exception $e) {
                    array_push($weights, $product);
                }
            }
        }
        $plans=collect(config('post-plans'));
        dd(config());
        $prices = collect([]);
        foreach ($weights as $weight) {
            $prices->push( [
                'weight' => $weight,
                'price'=>$plans->where("min","<",$weight)->where("max",">=",$weight)->first()['price']
            ]);
        }
        return $prices->sum('price');
    }
}