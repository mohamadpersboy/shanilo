<?php

namespace App\Http\Controllers\Front\Specific;

use App\Http\Controllers\Front\Traits\Specific\HasAjaxData;
use App\Http\Controllers\Front\Traits\Specific\HasForbiddenMessageAndView;
use App\Http\Requests\Front\Specific\ShopRequest;
use App\Models\Specific\Article;
use App\Models\Specific\Brand;
use App\Models\Specific\ProductCategory;
use App\Models\Specific\ProductDetail;
use App\Models\Specific\Shop;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopPageController extends Controller
{
    use HasForbiddenMessageAndView, HasAjaxData;

    protected $activeMenu;

    protected $data = [];

    const VIEW_ROOT = 'front.pages.shop-page.';
    protected $dataFetcher;

    public function __construct()
    {
        $this->activeMenu = explode('@', \Route::getCurrentRoute()->getAction()['uses'])[1];
        $this->dataFetcher = camel_case("get {$this->activeMenu} data");
    }

    public function index(Shop $shop)
    {
        $this->setData($shop);
        if (\request()->ajax()) {
            return $this->getAjaxData();
        }
        return $this->view('index');
    }

    public function products(Shop $shop)
    {
        $this->setData($shop);
        return $this->view('products');
    }

    public function specialSuggestions(Shop $shop)
    {
        $this->setData($shop);
        if (\request()->ajax()) {
            return $this->getAjaxData();
        }
        return $this->view('specialsuggestions');
    }

    public function specialSells(Shop $shop)
    {
        $this->setData($shop);
        if (\request()->ajax()) {
            return $this->getAjaxData();
        }
        return $this->view('specialsells');
    }

    public function clients(Shop $shop)
    {
        $this->setData($shop);
        if (\request()->ajax()) {
            return $this->getAjaxData('clients', 'clients');
        }
        return $this->view('clients');
    }

    public function articles(Shop $shop)
    {
        $this->setData($shop);
        if (\request()->ajax()) {
            return $this->getAjaxData('articles', 'articles');
        }
        return $this->view('article.index');
    }

    public function article(Shop $shop,$id)
    {
        $article = Article::query()->where('is_active',1)->findOrFail($id);
        $this->setData($shop);
        $this->data['article'] = $article;
       
        return $this->view('article.show');
    }

    public function about(Shop $shop)
    {
        $this->setData($shop);
        return $this->view('about');
    }



    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Update shop
    # All modifications in shop page such as upload image
    # And update the information
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#

    public function updateField(Shop $shop, Request $request)
    {
        if (!canEditShop($shop)) {
            return $this->forbiddenMessage();
        }
        $shopRequest = new ShopRequest();

        //Set method to patch and add the shop id to ignore unique validation rule
        $shopRequest->setMethod('PATCH');
        $shopRequest->merge(['id' => $request->get('id')]);

        $rules = $shopRequest->rules();
        $attributes = $shopRequest->attributes();
        $field = $request->get('field');

        $request->merge([$field => $request->get('value')]);
        $request->validate([
            'id' => "required|check_hash:{$request->get('_sid')}," . true,
            $field => isset($rules[$field]) ? $rules[$field] : ''
        ], [
            'id.required' => 'اطلاعات ارسال شده نامعتبر است.',
            'id.check_hash' => 'اطلاعات ارسال شده نامعتبر است.',
        ], $attributes);
        $shop->update([$field => $request->get('value')]);
        return [
            'field' => $request->get('value')
        ];
    }

    public function uploadProfileImage(Shop $shop, Request $request)
    {
        if (!canEditShop($shop)) {
            return $this->forbiddenMessage();
        }
        $this->validate($request, [
            'id' => "required|check_hash:{$request->get('_sid')}," . true,
            'avatar' => 'required|mimes:jpg,jpeg,png'
        ], [
            'id.required' => 'اطلاعات ارسال شده نامعتبر است.',
            'id.check_hash' => 'اطلاعات ارسال شده نامعتبر است.',
        ], [
            'avatar' => 'تصویر پروفایل'
        ]);
        $shop->updateImage($request->file('avatar'), 'avatar', $request->get('cropper'), ['60/60', '90/90', '120/120', '172/172']);
        return [
            'url' => back()->getTargetUrl()
        ];
    }

    public function uploadBackgroundImage(Shop $shop, Request $request)
    {
        if (!canEditShop($shop)) {
            return $this->forbiddenMessage();
        }
        $this->validate($request, [
            'id' => "required|check_hash:{$request->get('_sid')}," . true,
            'background' => 'required|mimes:jpg,jpeg,png'
        ], [
            'id.required' => 'اطلاعات ارسال شده نامعتبر است.',
            'id.check_hash' => 'اطلاعات ارسال شده نامعتبر است.',
        ], [
            'background' => 'تصویر پس زمینه'
        ]);
        $shop->updateImage($request->file('background'), 'background', $request->get('cropper'), ['1200/500', '350/160', '278/180', '60/60']);
        return [
            'url' => back()->getTargetUrl()
        ];
    }

    /**
     * @param Shop $shop
     * @return array
     */
    protected function setData(Shop $shop)
    {
        $this->data = [
            'activeMenu' => $this->activeMenu,
            'shop' => $shop
        ];

        if (method_exists($this, $this->dataFetcher)) {
            $func = $this->dataFetcher;
            $this->data = array_merge($this->data, $this->$func($shop));
        }
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # PAGE DATA GENERATORS
    # Methods that generate data for each page in shop
    # page
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected function getIndexData(Shop $shop)
    {
        $specialSuggestions = $this->getSpecialSuggestions($shop)->latest()->limit(4)->get();
        //
        $specialSells = $this->getSpecialSells($shop)->latest()->limit(4)->get();
        //
        $productDetails = ProductDetail::visible()->index()->where(function (Builder $builder) use ($shop) {
            $builder->whereHas('product', function (Builder $builder) use ($shop) {
                $builder->visible()->whereHas('shop', function (Builder $builder) use ($shop) {
                    $builder->where('id', $shop->id);
                });
            });
        })->latest()->paginate(20);
        //
        $articles = Article::visible()->whereHas('shop', function (Builder $builder) use ($shop) {
            $builder->visible()->where('id', $shop->id);
        })->latest()->limit(4)->get();

        return [
            'pageTitle'=>$shop->title,
            'specialSuggestions' => $specialSuggestions,
            'specialSells' => $specialSells,
            'productDetails' => $productDetails,
            'articles' => $articles
        ];
    }

    protected function getSpecialSuggestionsData(Shop $shop)
    {
        return [
            'pageTitle'=>'پیشنهادات ویژه | '.$shop->title,
            'productDetails' => $this->getSpecialSuggestions($shop)->latest()->paginate(20)
        ];
    }

    protected function getSpecialSellsData(Shop $shop)
    {
        return [
            'pageTitle'=>'فروش ویژه | '.$shop->title,
            'productDetails' => $this->getSpecialSells($shop)->latest()->paginate(20)
        ];
    }

    protected function getArticlesData(Shop $shop)
    {
        return [
            'pageTitle'=>'مجلات | '.$shop->title,
            'articles' => $shop->articles()->where('is_active', 1)->visible()->latest()->paginate(20)
        ];
    }

    protected function getClientsData(Shop $shop)
    {
        return [
            'pageTitle'=>'لیست مشتریان | '.$shop->title,
            'clients' => $shop->customers()->paginate(24)
        ];
    }

    protected function getProductsData(Shop $shop)
    {
        \request()->merge(['shop'=>$shop->id]);
        $productDetails = ProductDetail::visible()->index()->filter();
        $limit=\request()->get('limit')?:20;
        return [
            'pageTitle'=>'لیست محصولات | '.$shop->title,
            'productCategories'=>ProductCategory::visible()->parents()->orderBy('title')->get(),
            'brands'=>Brand::whereHas('products', function (Builder $builder) use ($shop) {
                $builder->visible()->where('shop_id', $shop->id);
            })->orderBy('title')->get(),
            'selectedCategory'=>\request()->get('category'),
            'selectedBrand'=>\request()->get('brand'),
            'selectedOrderByPrice'=>\request()->get('orderByPrice'),
            'selectedHasDiscount'=>\request()->get('hasDiscount'),
            'limit'=>$limit,
            'search'=>\request()->get('search'),
            'view'=>\request()->get('view')?:'box',
            'productDetails'=>$productDetails->latest()->offset(0)->limit($limit)->get(),
            'hasMorePage'=>$productDetails->latest()->offset($limit)->limit($limit)->get()->count()
        ];
    }

    protected function getAboutData(Shop $shop)
    {
        return [
            'pageTitle'=>'درباره فروشگاه | '.$shop->title,
        ];
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # ACTIONS
    # Actions that can be performed on this shop by a
    # user
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function toggleFollow(Shop $shop)
    {
        $message = announcementMessage(auth()->user(), str_replace('%shop%', $shop->title, 'فروشگاه %shop% را دنبال می کند.'));
        if (!canFollowOrBlock($shop)) {
            abort(404);
        }
        if (inFollowingList($shop)) {
            auth()->user()->following()->where([
                'followable_id' => $shop->id,
                'followable_type' => Shop::class,
            ])->delete();
            $shop->user->hasAnnouncement($message)->delete();
            $data = [
                'text' => 'follow',
                'removeClass' => 'red',
                'addClass' => 'green',
            ];
        } else {
            auth()->user()->following()->create([
                'followable_id' => $shop->id,
                'followable_type' => Shop::class,
            ]);
            $data = [
                'text' => 'unfollow',
                'removeClass' => 'green',
                'addClass' => 'red',
            ];

            if (!$shop->user->hasAnnouncement($message)->exists()) {
                $shop->user->announcements()->create([
                    'message' => $message
                ]);
            }
        }
        $data['view'] = \View::make('front.partial.items.follow-btn-modal', ['object' => $shop])->render();
        $data['counter']="#shop-followers-".$shop->id;
        $data['count']=$shop->followers_count;
        return $data;
    }

    public function getFollowers(Shop $shop)
    {
        $followers = $shop->followers->map(function ($following) {
            return $following->user;
        });
        return [
            'view' => \View::make('front.partial.ajax.followers-modal', ['objects' => $followers])->render()
        ];
    }


    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Helpers
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#

    protected function getSpecialSells(Shop $shop)
    {
        return ProductDetail::visible()->index()->where(function (Builder $builder) use ($shop) {
            $builder->whereHas('product', function (Builder $builder) use ($shop) {
                $builder->visible()->whereHas('shop', function (Builder $builder) use ($shop) {
                    $builder->where('id', $shop->id);
                });
            })->whereHas('specialSell');
        });
    }

    protected function getSpecialSuggestions(Shop $shop)
    {
        return ProductDetail::visible()->index()->where(function (Builder $builder) use ($shop) {
            $builder->whereHas('product', function (Builder $builder) use ($shop) {
                $builder->visible()->whereHas('shop', function (Builder $builder) use ($shop) {
                    $builder->where('id', $shop->id);
                });
            })->whereHas('specialSuggestion');
        });
    }
}
