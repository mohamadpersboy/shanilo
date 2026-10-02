<?php
/**
 * Created by PhpStorm.
 * User: milad
 * Date: 10/31/2018
 * Time: 9:43 AM
 */

namespace App\Http\Helpers\Favorite;


use App\Interfaces\CookieBaseModels;
use App\Models\Specific\Favorite as FavoriteModel;
use App\Models\Specific\FavoriteDetail;
use App\Models\Specific\ProductDetail;

class Favorite implements CookieBaseModels
{
    protected $favorite;

    public function __construct($favoriteId)
    {
        if($favoriteId){
            if($favorite=FavoriteModel::find($favoriteId)){
                $this->favorite=$favorite;
            }else{
                $this->favorite=$this->make();
            }
        }else{
            $this->favorite=$this->make();
        }
    }

    public function get(){
        return $this->favorite;
    }

    public function make()
    {
        $favorite=FavoriteModel::create();
        \Cookie::queue('favorite',$favorite->id);
        return $favorite;
    }

    public function details()
    {
        return FavoriteDetail::where('favorite_id',$this->favorite->id)->get();
    }

    public function has($object)
    {
        return $this->favorite->details()->where('product_detail_id',$object->id)->exists();
    }

    public function add($object)
    {
       return $this->favorite->details()->create([
            'product_detail_id'=>$object->id
        ]);
    }

    public function remove($object)
    {
        return $this->favorite->details()->where('product_detail_id',$object->id)->delete();
    }

    public function count()
    {
        return $this->favorite->details()->count();
    }
}
