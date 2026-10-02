<?php

namespace App\Http\Controllers\Front\Specific;

use App\Http\Controllers\Front\Traits\Specific\HasForbiddenMessageAndView;
use App\Models\Specific\Article;
use App\Models\Base\User;
use App\Models\Specific\ProductDetail;
use App\Models\Specific\Shop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TimelineController extends Controller
{

    use HasForbiddenMessageAndView;

    const VIEW_ROOT = 'front.pages.timeline.';

    protected $dataFetcher;

    protected $data;
    protected $activeMenu;

    public function __construct()
    {
        $this->activeMenu = explode('@', \Route::getCurrentRoute()->getAction()['uses'])[1];
        $this->dataFetcher = camel_case("get {$this->activeMenu} data");
    }

    public function index()
    {
        $this->data = [
            'pageTitle' => 'دنبال شوندگان',
        ];
        $this->setData();
        if(\request()->ajax()){
            return $this->getAjaxData();
        }
        return $this->view('products');
    }

    public function specialSuggestions()
    {
        $this->data = [
            'pageTitle' => 'پیشنهادات ویژه',
        ];
        $this->setData();
        if(\request()->ajax()){
            return $this->getAjaxData();
        }
        return $this->view('products');
    }

    public function friendsSuggestions()
    {
        $this->data=[
            'pageTitle'=>'پیشنهادات دوستان'
        ];
        $this->setData();
        if(\request()->ajax()){
            return $this->getAjaxData();
        }
        return $this->view('products');
    }

    public function specialSells()
    {
        $this->data=[
            'pageTitle'=>'فروش ویژه'
        ];
        $this->setData();
        if(\request()->ajax()){
            return $this->getAjaxData();
        }
        return $this->view('products');
    }

    public function articles()
    {
        $this->data=[
            'pageTitle'=>'جدیدترین مجلات',
        ];
        $this->setData();
        if(\request()->ajax()){
           return  $this->getAjaxData('articles','articles');
        }
        return $this->view('articles');
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # PAGE DATA GENERATORS
    # Methods that generate data for each page in timeline
    # page
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected function setData()
    {
        $this->data['activeMenu']=$this->activeMenu;
        if (method_exists($this, $this->dataFetcher)) {
            $func = $this->dataFetcher;
            $this->data = array_merge($this->data, $this->$func());
        }
    }

    protected function getIndexData(){
        return [
            'productDetails' =>$this->getUserFollowingProducts()->paginate(20)
        ];
    }

    protected function getSpecialSuggestionsData(){
        return [
            'productDetails' =>$this->getUserFollowingProducts()->whereHas('specialSuggestion')->paginate(20)
        ];
    }

    protected function getFriendsSuggestionsData()
    {
        return [
            'productDetails'=>ProductDetail::visible()->index()
                ->whereHas('product',function (Builder $builder){
                    $builder->visible();
                })
                ->whereHas('userSuggestions',function (Builder $builder){
                $builder->where('user_id',auth()->id())->where('offerer_id','!=',auth()->id());
            })->paginate(20)
        ];
    }

    protected function getSpecialSellsData(){
        return [
            'productDetails'=>$this->getUserFollowingProducts()->whereHas('specialSell')->paginate(20)
        ];
    }

    protected function getArticlesData(){
        return [
            'articles'=>Article::visible()->whereIn('user_id',$this->getUserFollowingUsers()->pluck('id')->toArray())
                ->orWhereIn('shop_id',$this->getUserFollowingShops()->pluck('id')->toArray())->orderBy('created_at','desc')
                ->paginate(20)
        ];
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Helpers
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected function getAjaxData($viewName='products',$variableName='productDetails')
    {
        return [
            'view' => \View::make("front.partial.items.$viewName", [$variableName => $this->data[$variableName]])->render(),
            'hasMorePage' => hasMorePage($this->data[$variableName])
        ];
    }

    /**
     * @return mixed
     */
    protected function getUserFollowingProducts()
    {
        return ProductDetail::index()->visible()
            ->whereHas('product', function (Builder $builder) {
            $builder->visible()->whereHas('shop', function (Builder $builder) {
                $builder->where(function (Builder $builder) {
                    $shops = $this->getUserFollowingShops();
                    $users = $this->getUserFollowingUsers();
                    $builder->visible()->whereIn('id', $shops->pluck('id')->toArray())
                        ->orWhereIn('user_id', $users->pluck('id')->toArray());
                });
            });
        })->orderBy('created_at','desc');
    }

    public function getUserFollowingShops()
    {
        return auth()->user()->following->filter(function ($following) {
            return $following->followable instanceof Shop;
        })->map(function ($following) {
            return $following->followable;
        });
    }

    public function getUserFollowingUsers()
    {
        return auth()->user()->following->filter(function ($following) {
            return $following->followable instanceof User;
        })->map(function ($following) {
            return $following->followable;
        });
    }
}
