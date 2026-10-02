<?php

namespace App\Http\Controllers\Front\Base;

use App\Models\Base\Announcement;
use App\Models\Base\Article;
use App\Models\Base\City;
use App\Models\Base\Comment;
use App\Models\Base\Payment;
use App\Models\Base\User;
use App\Models\Specific\Cart;
use App\Models\Specific\CartDetail;
use App\Models\Specific\Checkout;
use App\Models\Specific\Comparison;
use App\Models\Specific\ComparisonDetail;
use App\Models\Specific\Favorite;
use App\Models\Specific\FirstPageSpecialSell;
use App\Models\Specific\FirstPageSpecialSuggestion;
use App\Models\Specific\Follower;
use App\Models\Specific\MainCategory;
use App\Models\Specific\Message;
use App\Models\Specific\NotifyList;
use App\Models\Specific\Order;
use App\Models\Specific\Plan;
use App\Models\Specific\Product;
use App\Models\Specific\ProductCategory;
use App\Models\Specific\ProductCategoryTechnicalSpecification;
use App\Models\Specific\ProductDetail;
use App\Models\Specific\ProductProperty;
use App\Models\Specific\Shop;
use App\Models\Specific\Slider;
use App\Models\Specific\SpecialSell;
use App\Models\Specific\SpecialSuggestion;
use App\Models\Specific\SuggestedProduct;
use App\Models\Specific\TemporaryUser;
use App\Models\Specific\UserSuggestion;
use App\Models\Specific\ViolationReport;
use App\Models\Specific\Wallet;
use App\Models\Specific\WalletTransaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Slider as ModelsSlider;
use App\Models\SocialNetwork;
use DB;
use Symfony\Component\HttpFoundation\JsonResponse;

class HomeController extends Controller
{
    public function index()
    {
        $data = [
            'productCategories' => ProductCategory::visible()->parents()->orderBy('position')->get(),
            'firstPageSpecialSuggestions' => $this->getFirstPageSpecialSuggestions(),
            'specialSellCategories' => $this->getFirstPageSpecialSellCategories(),
            'plans' => Plan::visible()->whereHas('firstPageSpecialSuggestions', function (Builder $builder) {
                $builder->remaining();
            })->orderBy('position')->get(),
            'shops' => Shop::query()->has('products', '>', 0)
                ->visible()->orderByFollowers('desc')->orderByRate('desc')->limit(9)->get(),
                'sliders'=>DB::table('home_sliders')->whereNull('deleted_at')->whereIn('type', ['mobile','desktop'])->get(),
                'min_image'=>DB::table('home_sliders')->whereNull('deleted_at')->where('type', 'min_image')->first()
                
        ];
        return view('front.pages.home.index', $data);
    }


    /**
     * @param Request $request
     * @return array
     */
    public function searchForCities(Request $request)
    {
        $keyWord = $request->get('q');
        if (!$keyWord) {
            return [];
        }
        $cities = City::where(function (Builder $builder) use ($keyWord) {
            $builder->where('name', 'like', "%{$keyWord}%")
                ->orWhere(function (Builder $builder) use ($keyWord) {
                    $builder->whereHas('state', function (Builder $builder) use ($keyWord) {
                        $builder->where('name', 'like', "%$keyWord%");
                    });
                });
        })->visible()->orderBy('name')->select(['id', 'state_id', 'name as text'])->groupBy('name')->get();
        foreach ($cities as $city) {
            $city->text = $city->text . ' (' . $city->state->name . ') ';
        }
        return [
            'results' => $cities,
            'total_count' => $cities->count()
        ];
    }

    /**
     * @return mixed
     */
    protected function getFirstPageSpecialSuggestions()
    {
        return FirstPageSpecialSuggestion::remaining()
            ->whereHas('specialSuggestion', function (Builder $builder) {
            })->orderBy('created_at', 'desc')->limit(8)->get();
    }

    /**
     * @return mixed
     */
    protected function getFirstPageSpecialSellCategories()
    {
        return ProductCategory::visible()->parents()->whereHas('products', function (Builder $builder) {
            $builder->visible()->whereHas('details', function (Builder $builder) {
                $builder->visible()->whereHas('specialSell', function (Builder $builder) {
                    $builder->whereHas('firstPageSpecialSell');
                });
            });
        })->inRandomOrder()->limit(3)->get();
    }

    public function sliders()
    {
        $sliders = ModelsSlider::get();

        return response()->json([
            'sliders'=>$sliders,
        ], JsonResponse::HTTP_OK);
    }

    public function socialNetwork()
    {
        $socialNetworks = SocialNetwork::query()->get();

        return response()->json(['social_networks'=>$socialNetworks]);
    }
}
