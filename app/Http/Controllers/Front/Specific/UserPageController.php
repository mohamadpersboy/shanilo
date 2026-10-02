<?php

namespace App\Http\Controllers\Front\Specific;

use App\Http\Controllers\Front\Traits\Specific\HasForbiddenMessageAndView;
use App\Http\Requests\Front\Specific\ProfileRequest;
use App\Models\Specific\Article;
use App\Models\Base\User;
use App\Models\Specific\ProductDetail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserPageController extends Controller
{
    use HasForbiddenMessageAndView;

    const VIEW_ROOT = 'front.pages.user-page.';

    protected $activeMenu;

    protected $dataFetcher;

    protected $data;

    public function __construct()
    {
        $this->activeMenu = explode('@', \Route::getCurrentRoute()->getAction()['uses'])[1];
        $this->dataFetcher = camel_case("get {$this->activeMenu} data");
    }

    public function index(User $user)
    {
        $this->setData($user);
        if (\request()->ajax()) {
            return $this->getAjaxData();
        }
        return $this->view('index');
    }

    public function about(User $user)
    {
        $this->setData($user);
        return $this->view('about');
    }

    public function shops(User $user)
    {
        $this->setData($user);
        return $this->view('shops');
    }

    public function suggestions(User $user)
    {
        $this->setData($user);
        if (\request()->ajax()) {
            return $this->getAjaxData();
        }
        return $this->view('suggestions');
    }

    public function favorites(User $user)
    {
        if(!canEditUser($user)){
            abort(404);
        }
        $this->setData($user);
        if (\request()->ajax()) {
            return $this->getAjaxData();
        }
        return $this->view('favorites');
    }

    public function articles(User $user)
    {
        $this->setData($user);
        if (\request()->ajax()) {
            return [
                'view' => \View::make('front.partial.items.articles', ['articles' => $this->data['articles']])->render(),
                'hasMorePage' => hasMorePage($this->data['articles'])
            ];
        }
        return $this->view('article.index');
    }

    public function article(User $user, Article $article)
    {
        $this->setData($user);
        $this->data['article'] = $article;
        return $this->view('article.show');
    }


    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Update user
    # All modifications in user page such as upload image
    # And update the information
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#

    public function updateField(User $user, Request $request)
    {
        if (!canEditUser($user)) {
            return $this->forbiddenMessage();
        }
        $profileRequest = new ProfileRequest();

        $rules = $profileRequest->rules();
        $attributes = $profileRequest->attributes();
        $field = $request->get('field');
        $redirect = false;
        if ($field == 'mobile' && $request->get('value') != $user->mobile) {
            $user->confirm = 0;
            $user->save();
            $redirect = true;
        }
        $request->merge([$field => $request->get('value')]);
        $request->validate([
            'id' => "required|check_hash:{$request->get('_sid')}," . true,
            $field => isset($rules[$field]) ? $rules[$field] : ''
        ], [
            'id.required' => 'اطلاعات ارسال شده نامعتبر است.',
            'id.check_hash' => 'اطلاعات ارسال شده نامعتبر است.',
        ], $attributes);
        $user->update([$field => $request->get('value')]);
        if ($redirect) {
            return [
                'url' => back()->getTargetUrl()
            ];
        }
        return [
            'field' => $request->get('value')
        ];
    }

    public function uploadProfileImage(User $user, Request $request)
    {
        if (!canEditUser($user)) {
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
        $user->updateImage($request->file('avatar'), 'avatar', $request->get('cropper'), ['60/60', '90/90', '120/120', '172/172']);
        return [
            'url' => back()->getTargetUrl()
        ];
    }

    public function uploadBackgroundImage(User $user, Request $request)
    {
        if (!canEditUser($user)) {
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
        $user->updateImage($request->file('background'), 'background', $request->get('cropper'), ['60/60', '1200/500']);
        return [
            'url' => back()->getTargetUrl()
        ];
    }


    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # PAGE DATA GENERATORS
    # Methods that generate data for each page in user
    # page
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected function getIndexData(User $user)
    {
        $productDetails = ProductDetail::visible()->index()->whereHas('product', function (Builder $builder) use ($user) {
            $builder->visible()->whereHas('shop', function (Builder $builder) use ($user) {
                $builder->where('user_id', $user->id);
            });
        })->orderBy('created_at', 'desc')->paginate(8);
        $specialSuggestions = ProductDetail::visible()->where(function (Builder $builder) use ($user) {
            $builder->whereHas('specialSuggestion')
                ->whereHas('product', function (Builder $builder) use ($user) {
                    $builder->visible()->whereHas('shop', function (Builder $builder) use ($user) {
                        $builder->where('user_id', $user->id);
                    });
                });
        })->orderBy('created_at', 'desc')->limit(4)->get();
        $specialSells = ProductDetail::visible()->where(function (Builder $builder) use ($user) {
            $builder->whereHas('specialSell')
                ->whereHas('product', function (Builder $builder) use ($user) {
                    $builder->visible()->whereHas('shop', function (Builder $builder) use ($user) {
                        $builder->where('user_id', $user->id);
                    });
                });
        })->orderBy('created_at', 'desc')->limit(4)->get();
        return [
            'pageTitle' => getUsersFullName($user),
            'productDetails' => $productDetails,
            'specialSuggestions' => $specialSuggestions,
            'specialSells' => $specialSells
        ];
    }

    protected function getSuggestionsData(User $user)
    {
        $productDetails = ProductDetail::visible()->where(function (Builder $builder) use ($user) {
            $builder->whereHas('product', function (Builder $builder) {
                $builder->visible();
            })->whereHas('userSuggestions', function (Builder $builder) use ($user) {
                $builder->where([
                    'user_id' => $user->id,
                    'offerer_id' => $user->id
                ]);
            });
        })->paginate(12);
        return [
            'pageTitle' => 'پیشنهادات من | ' . getUsersFullName($user),
            'productDetails' => $productDetails
        ];
    }

    protected function getFavoritesData(User $user)
    {
        $productDetails = $user->favoriteProducts()->latest()->paginate(20);
        return [
            'pageTitle' => 'علاقه مندی های من | ' . getUsersFullName($user),
            'productDetails' => $productDetails
        ];
    }

    protected function getShopsData(User $user)
    {
        return [
            'pageTitle'=>'فروشگاه های من | '.getUsersFullName($user),
            'shops'=>$user->shops()->latest()->get()
        ];
    }

    protected function getArticlesData(User $user)
    {
        return [
            'pageTitle' => 'مجلات من | ' . getUsersFullName($user),
            'articles' => $user->articles()->visible()->latest()->paginate(12)
        ];
    }

    protected function getAboutData(User $user){
        return [
            'pageTitle'=>'درباره من | '.getUsersFullName($user),
        ];
    }

    protected function setData(User $user)
    {
        $this->data = [
            'activeMenu' => $this->activeMenu,
            'user' => $user
        ];
        if (method_exists($this, $this->dataFetcher)) {
            $func = $this->dataFetcher;
            $this->data = array_merge($this->data, $this->$func($user));
        }
    }
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # ACTIONS
    # Actions that can be performed on this user by another one
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    public function toggleFollow(User $user)
    {
        $message = announcementMessage(auth()->user(), 'شما را دنبال می کند.');
        if (!canFollowOrBlock($user)) {
            abort(404);
        }
        if (inFollowingList($user)) {
            auth()->user()->following()->where([
                'followable_id' => $user->id,
                'followable_type' => User::class,
            ])->delete();
            $user->hasAnnouncement($message)->delete();
            $data = [
                'text' => 'follow',
                'removeClass' => 'red',
                'addClass' => 'green',
            ];
        } else {
            auth()->user()->following()->create([
                'followable_id' => $user->id,
                'followable_type' => User::class,
            ]);
            $data = [
                'text' => 'unfollow',
                'removeClass' => 'green',
                'addClass' => 'red',
            ];

            if (!$user->hasAnnouncement($message)->exists()) {
                $user->announcements()->create([
                    'message' => $message
                ]);
            }
        }
        $data['view'] = \View::make('front.partial.items.follow-btn-modal', ['object' => $user])->render();
        return $data;
    }

    public function toggleBlock(User $user)
    {
        if (!canFollowOrBlock($user)) {
            abort(404);
        }
        if (inBlockList($user)) {
            auth()->user()->blockings()->detach([$user->id]);
            $data = [
                'text' => 'block',
                'removeClass' => 'green',
                'addClass' => 'red'
            ];
        } else {
            auth()->user()->blockings()->attach([$user->id]);
            $data = [
                'text' => 'unblock',
                'removeClass' => 'red',
                'addClass' => 'green'
            ];
        }
        return $data;
    }

    public function getFollowers(User $user)
    {
        $followers = $user->followers->map(function ($following) {
            return $following->user;
        })->filter(function ($follower){
            return !!$follower;
        });
        return [
            'view' => \View::make('front.partial.ajax.followers-modal', ['objects' => $followers])->render()
        ];
    }

    public function getFollowings(User $user)
    {
        $followings = $user->following->map(function ($following) {
            return $following->followable;
        })->filter(function ($follower){
            return !!$follower;
        });
        return [
            'view' => \View::make('front.partial.ajax.followers-modal', ['objects' => $followings])->render()
        ];
    }

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Helpers
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    protected function getAjaxData()
    {
        return [
            'view' => \View::make('front.partial.items.products', ['productDetails' => $this->data['productDetails']])->render(),
            'hasMorePage' => hasMorePage($this->data['productDetails'])
        ];
    }
}
