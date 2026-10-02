<?php

use App\Models\Base\State;

Route::get('download', 'DownloadController@download')->name('download');
Route::group(['namespace' => 'Front', 'middleware' =>
    [
        'front.login',
        /*'HTMLMin\HTMLMin\Http\Middleware\MinifyMiddleware',*/
        'confirmed'
    ]
], function () {

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Specific
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    Route::group(['namespace' => 'Specific'], function () {
        Route::post('msg', 'Profile\MsgController@store')->name('msg.store');
        Route::get('msg/{id}', 'Profile\MsgController@show')->name('msg.show');
        Route::get('msg_shop', 'Profile\MsgController@msgShop')->name('shopMsg.show');
        Route::get('my_msg', 'Profile\MsgController@myMsg')->name('myMsg.show');
        Route::get('msg_ticket', 'Profile\MsgController@ticket')->name('ticketMsg.show');
        Route::post('msg_reply/{id}', 'Profile\MsgController@reply')->name('replyMsg.show');
        Route::get('msg_send_ticket_form', 'Profile\MsgController@sendTicketForm')->name('sendTicketForm');
        Route::post('msg_send_ticket', 'Profile\MsgController@sendTicket')->name('sendTicket');
        Route::post('product_message_front', 'ProductMessageController@store')->name('product_message_front.store');
        #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
        # Test post price
        #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
        Route::get('/post', ['as' => 'front.post.index', 'uses' => 'TestPostController@index']);

        /**:::::::::::::::**| Users and shops page |**:::::::::::::::**/
        Route::get('/@{uid}', function ($uid) {
            $user = \App\Models\Base\User::where('uid', $uid)->first();
            if ($user) {
                return redirect($user->path());
            }
            $shop = \App\Models\Specific\Shop::where('uid', $uid)->first();
            if ($shop) {
                return redirect($shop->path());
            }
            abort(404);
        });
        /**:::::::::::::::**| User page |**:::::::::::::::**/
        Route::group(['prefix' => 'user-page'], function () {
            /**:::::::::::::::**| User page edit |**:::::::::::::::**/
            Route::group(['middleware' => 'auth'], function () {
                Route::patch('update-user-single-field/{user}', ['as' => 'front.user-page.update-field', 'uses' => 'UserPageController@updateField']);
                Route::post('upload-user-profile-image/{user}', ['as' => 'front.user-page.upload-profile-image', 'uses' => 'UserPageController@uploadProfileImage']);
                Route::post('upload-user-background-image/{user}', ['as' => 'front.user-page.upload-background-image', 'uses' => 'UserPageController@uploadBackgroundImage']);
                Route::post('toggleFollow/{user}', ['as' => 'front.user-page.toggleFollow', 'uses' => 'UserPageController@toggleFollow']);
                Route::post('toggleBlock/{user}', ['as' => 'front.user-page.toggleBlock', 'uses' => 'UserPageController@toggleBlock']);

            });
            Route::get('getFollowers/{user}', ['as' => 'front.user-page.getFollowers', 'uses' => 'UserPageController@getFollowers']);
            Route::get('getFollowings/{user}', ['as' => 'front.user-page.getFollowings', 'uses' => 'UserPageController@getFollowings']);

            Route::get('personal/{user}/{slug?}', ['as' => 'front.user-page.personal', 'uses' => 'UserPageController@index']);
            Route::get('about/{user}/{slug?}', ['as' => 'front.user-page.about', 'uses' => 'UserPageController@about']);
            Route::get('favorites/{user}/{slug?}', ['as' => 'front.user-page.favorites', 'uses' => 'UserPageController@favorites']);
            Route::get('shops/{user}/{slug?}', ['as' => 'front.user-page.shops', 'uses' => 'UserPageController@shops']);
            Route::get('suggestions/{user}/{slug?}', ['as' => 'front.user-page.suggestions', 'uses' => 'UserPageController@suggestions']);
            Route::get('articles/{user}/{slug?}', ['as' => 'front.user-page.articles', 'uses' => 'UserPageController@articles']);
            Route::get('articles/{user}/{article}/{slug?}', ['as' => 'front.user-page.article', 'uses' => 'UserPageController@article']);
        });

        /**:::::::::::::::**| Shop page |**:::::::::::::::**/
        Route::group(['prefix' => 'shop-page'], function () {

            /**:::::::::::::::**| Shop page edit |**:::::::::::::::**/
            Route::group(['middleware' => 'auth'], function () {
                Route::patch('update-shop-single-field/{shop}', ['as' => 'front.shop-page.update-field', 'uses' => 'ShopPageController@updateField']);
                Route::post('upload-shop-profile-image/{shop}', ['as' => 'front.shop-page.upload-profile-image', 'uses' => 'ShopPageController@uploadProfileImage']);
                Route::post('upload-shop-background-image/{shop}', ['as' => 'front.shop-page.upload-background-image', 'uses' => 'ShopPageController@uploadBackgroundImage']);
                Route::post('toggleFollow/{shop}', ['as' => 'front.shop-page.toggleFollow', 'uses' => 'ShopPageController@toggleFollow']);
            });
            Route::get('getFollowers/{shop}', ['as' => 'front.shop-page.getFollowers', 'uses' => 'ShopPageController@getFollowers']);

            Route::get('index/{shop}/{slug?}', ['as' => 'front.shop-page.index', 'uses' => 'ShopPageController@index']);
            Route::get('about/{shop}/{slug?}', ['as' => 'front.shop-page.about', 'uses' => 'ShopPageController@about']);
            Route::get('articles/{shop}/{slug?}', ['as' => 'front.shop-page.articles', 'uses' => 'ShopPageController@articles']);
            Route::get('clients/{shop}/{slug?}', ['as' => 'front.shop-page.clients', 'uses' => 'ShopPageController@clients']);
            Route::get('products/{shop}/{slug?}', ['as' => 'front.shop-page.products', 'uses' => 'ShopPageController@products']);
            Route::get('specialsuggestions/{shop}/{slug?}', ['as' => 'front.shop-page.specialSuggestions', 'uses' => 'ShopPageController@specialSuggestions']);
            Route::get('specialsells/{shop}/{slug?}', ['as' => 'front.shop-page.specialSells', 'uses' => 'ShopPageController@specialSells']);
            Route::get('articles/{shop}/{article}/{slug?}', ['as' => 'front.shop-page.article', 'uses' => 'ShopPageController@article']);

        });

        /**:::::::::::::::**| Comments |**:::::::::::::::**/
        Route::group(['prefix' => 'comment'], function () {
            Route::get('{object}/{id}', ['as' => 'front.comment.index', 'uses' => 'CommentController@index']);
            Route::group(['middleware' => 'auth'], function () {
                Route::post('{object}/{id}/store', ['as' => 'front.comment.store', 'uses' => 'CommentController@store']);
                Route::delete("{comment}/destroy", ['as' => 'front.comment.destroy', 'uses' => 'CommentController@destroy']);
                Route::post("{comment}/reply", ['as' => 'front.comment.reply', 'uses' => 'CommentController@reply']);
            });
        });

        /**:::::::::::::::**| Reports |**:::::::::::::::**/
        Route::group(['prefix' => 'report', 'middleware' => 'auth'], function () {
            Route::get('{object}/{id}', ['as' => 'front.report.create', 'uses' => 'ReportController@create']);
            Route::post('{object}/{id}', ['as' => 'front.report.store', 'uses' => 'ReportController@store']);
        });

        /**:::::::::::::::**| Favorite |**:::::::::::::::**/
        Route::group(['prefix' => 'favorite'], function () {
            Route::post('toggle/{productDetail}', ['as' => 'front.favorite.toggle', 'uses' => 'FavoriteController@toggle']);
            Route::delete('{productDetail}', ['as' => 'front.favorite.destroy', 'uses' => 'FavoriteController@destroy']);
        });

        /**:::::::::::::::**| Announcement |**:::::::::::::::**/
        Route::group(['prefix' => 'announcement'], function () {
            Route::patch('{announcement}/seen', ['as' => 'front.announcement.seen', 'uses' => 'AnnouncementController@seen']);
        });


        #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
        # NotifyList
        # Messages
        #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
        Route::group(['middleware' => 'auth'], function () {
            /**:::::::::::::::**| NotifyList |**:::::::::::::::**/
            Route::group(['prefix' => 'notifylist'], function () {
                Route::post('toggle/{object}/{id}', ['as' => 'front.notifylist.toggle', 'uses' => 'NotifyListController@toggle']);
            });
            /**:::::::::::::::**| Messages |**:::::::::::::::**/
            Route::group(['prefix' => 'message'], function () {
                Route::get('{type}/{id}/create', ['as' => 'front.message.create', 'uses' => 'MessageController@create']);
                Route::post('/', ['as' => 'front.message.store', 'uses' => 'MessageController@store']);
            });
            Route::group(['prefix' => 'timeline'], function () {
                Route::get('/', ['as' => 'front.timeline.index', 'uses' => 'TimelineController@index']);
                Route::get('پیشنهادات-ویژه', ['as' => 'front.timeline.special-suggestions', 'uses' => 'TimelineController@specialSuggestions']);
                Route::get('پیشنهادات-دوستان', ['as' => 'front.timeline.friends-suggestions', 'uses' => 'TimelineController@friendsSuggestions']);
                Route::get('فروش-ویژه', ['as' => 'front.timeline.special-sells', 'uses' => 'TimelineController@specialSells']);
                Route::get('جدیدترین-مجلات', ['as' => 'front.timeline.articles', 'uses' => 'TimelineController@articles']);
            });
        });

        /**:::::::::::::::**| Products |**:::::::::::::::**/
        Route::group(['prefix' => 'products'], function () {
            Route::get('/', ['as' => 'front.product.index', 'uses' => 'ProductController@index']);
            Route::get('/detail/{productDetail}/{slug?}', ['as' => 'front.product.show', 'uses' => 'ProductController@show']);
            Route::get('/clients/{productDetail}', ['as' => 'front.product.clients', 'uses' => 'ProductController@clients']);
            Route::get('{id}/get', ['as' => 'front.product.getByKey', 'uses' => 'ProductController@getByKey']);
        });
        /**:::::::::::::::**| Shop archive |**:::::::::::::::**/
        Route::group(['prefix' => 'shops'], function () {
            Route::get('/', ['as' => 'front.shop.index', 'uses' => 'ShopController@index']);
        });

        /**:::::::::::::::**| Comparison |**:::::::::::::::**/
        Route::group(['prefix' => 'comparison'], function () {
            Route::get('/', ['as' => 'front.comparison.index', 'uses' => 'ComparisonController@index']);
            Route::post('/{product}/toggle', ['as' => 'front.comparison.toggle', 'uses' => 'ComparisonController@toggle']);
            Route::delete('/{product}', ['as' => 'front.comparison.destroy', 'uses' => 'ComparisonController@destroy']);
        });

        /**:::::::::::::::**| SpecialSuggestion |**:::::::::::::::**/
        Route::get('/پیشنهادات-ویژه', ['as' => 'front.specialSuggestion.index', 'uses' => 'SpecialSuggestionController@index']);
        /**:::::::::::::::**| SpecialSells |**:::::::::::::::**/
        Route::get('/فروش-ویژه', ['as' => 'front.specialSell.index', 'uses' => 'SpecialSellController@index']);

        #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
        # Cart
        # All routes related to cart are here
        #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
        Route::group(['prefix' => 'cart'], function () {
            Route::get('/step1', ['as' => 'front.cart.step1', 'uses' => 'CartController@step1']);
            Route::post('update-count/{cartDetailProduct}', ['as' => 'front.cart.update-count', 'uses' => 'CartController@updateCount']);
            Route::patch('update-show-as-customer/{cartDetail}', ['as' => 'front.cart.update-show-as-customer', 'uses' => 'CartController@updateShowAsCustomer']);
            Route::group(['middelware' => ['auth', 'cart-auth']], function () {
                Route::get('/step2/{cartDetail}', ['as' => 'front.cart.step2', 'uses' => 'CartController@step2']);
                Route::get('/step3/{cartDetail}', ['as' => 'front.cart.step3', 'uses' => 'CartController@step3']);
                Route::get('/step4/{cartDetail}', ['as' => 'front.cart.step4', 'uses' => 'CartController@step4']);
                Route::get('/step5/{cartDetail}', ['as' => 'front.cart.step5', 'uses' => 'CartController@step5']);
                Route::get('/step6/{cartDetail}', ['as' => 'front.cart.step6', 'uses' => 'CartController@step6']);

                Route::patch('/{cartDetail}/updateField', ['as' => 'front.cart.update-field', 'uses' => 'CartController@updateField']);
            });
            Route::post('/{productDetail}/toggle', ['as' => 'front.cart.toggle', 'uses' => 'CartController@toggle'])->middleware('shop.middleware');
            Route::delete('/{productDetail}', ['as' => 'front.cart.destroy', 'uses' => 'CartController@destroy']);
        });

        #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
        # Payment
        # All routes related to payment are here
        #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
        Route::group(['prefix' => 'payment'], function () {
            Route::any('/verifyOrder', ['as' => 'front.payment.verifyOrder', 'uses' => 'PaymentController@verifyOrder']);
            Route::get('/pay/{cartDetail}', ['as' => 'front.payment.pay', 'uses' => 'PaymentController@pay']);
            Route::get('/result/{order}', ['as' => 'front.payment.result', 'uses' => 'PaymentController@result']);
        });

        #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
        # Search
        #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
        Route::get('/search', ['as' => 'front.search', 'uses' => 'SearchController@index']);

    });


    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Helpers
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    /**:::::::::::::::**| Resend sms |**:::::::::::::::**/
    Route::get('/resend-sms/{hashed}', ['as' => 'front.auth.resend_sms', function ($hashed) {
        $user = Auth::check() ? Auth::user() : \App\Models\Specific\TemporaryUser::where('hashed', $hashed)->first();
        if (!$user) {
            $passwordReset = \App\Models\Base\PasswordResetMobile::where('token', $hashed)->first();
            if (!$passwordReset) {
                abort(404);
            }
            $code = rand(10000, 99999);
            $hashed = str_replace('/', '', bcrypt($code));
            \App\Models\Base\PasswordResetMobile::create([
                'mobile' => $passwordReset->mobile,
                'code' => $code,
                'token' => $hashed,
                'expired_at' => Carbon\Carbon::now()->addMinutes(15)
            ]);
            //(new \App\Http\Controllers\Front\Auth\ForgotPasswordController())->sendMobileConfirmationSMS($passwordReset->mobile,$code);
            \Session::put('hashed', $hashed);
            Smsir::ultraFastSend(['VerificationCode' => $code], 31279, $passwordReset->mobile);
            return back();
        }
        sendConfirmationSMS($user);
        return back();
    }]);

    /**:::::::::::::::**| Single field validation |**:::::::::::::::**/
    Route::post('single-field-validation', ['as' => 'front.singleField.validation', function (\Illuminate\Http\Request $request) {
        $data = $request->get('data');
        if (isset($data['uid'])) {
            $data['uid'] = trim(str_replace('@', '', $data['uid']));
        }
        Validator::make($data, [
            $request->get('field') => $request->get('rules')
        ])->validate();
        return [
            'true'
        ];
    }]);

    /**:::::::::::::::**| Get product categories children |**:::::::::::::::**/
    Route::get('/get-children/product-category/{productCategory?}/', ['as' => 'front.getChildren.productCategory', function (\App\Models\Specific\ProductCategory $productCategory) {
        return $productCategory->children()->get(['id as value', 'title']);
    }]);

    /**:::::::::::::::**| Get product categories technical specification |**:::::::::::::::**/
    Route::get('/get-technical-specifications/{product?}/{productCategory?}', ['as' => 'front.getTechnicalSpecifications', function ($product = null, \App\Models\Specific\ProductCategory $productCategory = null) {
        $data = [
            'productCategoryTechnicalSpecifications' => \App\Models\Specific\ProductCategoryTechnicalSpecification::where('product_category_id', $productCategory->id)
                ->select('product_category_technical_specifications.*')
                ->join('technical_specifications', 'product_category_technical_specifications.technical_specification_id', '=', 'technical_specifications.id')
                ->orderBy('technical_specifications.position')->get(),
        ];
        if ($product && is_numeric($product)) {
            $data['product'] = \App\Models\Specific\Product::findOrFail($product);
        }
        return [
            'view' => \Illuminate\Support\Facades\View::make('front.partial.ajax.product-technical-specification', $data)->render()
        ];
    }]);

    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # Profile
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    Route::group(['namespace' => 'Specific\Profile', 'middleware' => 'auth', 'prefix' => 'profile'], function () {

        /**:::::::::::::::**| Profile |**:::::::::::::::**/
        Route::get('my-profile', ['as' => 'front.profile.index', 'uses' => 'ProfileController@index']);
        Route::patch('my-profile', ['as' => 'front.profile.update', 'uses' => 'ProfileController@update']);


        /**:::::::::::::::**| Change password |**:::::::::::::::**/
        Route::get('/تغییر-رمز-عبور', ['as' => 'front.profile.password.index', 'uses' => 'PasswordController@index']);
        Route::patch('/change_password', ['as' => 'front.profile.password.update', 'uses' => 'PasswordController@update']);

        /**:::::::::::::::**| Orders |**:::::::::::::::**/
        Route::group(['prefix' => 'order'], function () {
            Route::get('/{type}/index', ['as' => 'front.profile.order.index', 'uses' => 'OrderController@index']);
            Route::get('/{order}/show', ['as' => 'front.profile.order.show', 'uses' => 'OrderController@show']);
            Route::patch('/{order}/updateStatus', ['as' => 'front.profile.order.update-status', 'uses' => 'OrderController@updateStatus']);
        });
        /**:::::::::::::::**| Article |**:::::::::::::::**/
        Route::resource('article', 'ArticleController', ['as' => 'front.profile']);

        /**:::::::::::::::**| Messages |**:::::::::::::::**/
        Route::get('messages', ['as' => 'front.profile.message.index', 'uses' => 'MessageController@index']);
        Route::get('{message}/messages', ['as' => 'front.profile.message.show', 'uses' => 'MessageController@show']);
        Route::get('tickets', ['as' => 'front.profile.message.tickets', 'uses' => 'MessageController@tickets']);
        Route::post('tickets', ['as' => 'front.profile.message.storeTicket', 'uses' => 'MessageController@storeTicket']);
        Route::post('messages', ['as' => 'front.profile.message.store', 'uses' => 'MessageController@store']);

        /**:::::::::::::::**| Shops |**:::::::::::::::**/
        Route::resource('shop', 'ShopController', ['as' => 'front.profile']);
        Route::get('shop/{shop}/getCoveredStates', ['as' => 'front.profile.shop.get-covered-states', 'uses' => 'ShopController@getCoveredStates']);
        Route::post('shop/{shop}/setCoveredStates', ['as' => 'front.profile.shop.set-covered-states', 'uses' => 'ShopController@setCoveredStates']);
        Route::get('shop/{shop}/getCoveredCities', ['as' => 'front.profile.shop.get-covered-cities', 'uses' => 'ShopController@getCoveredCities']);
        Route::get('shop/{shop}/getCoveredCitiesList/{state?}', ['as' => 'front.profile.shop.get-covered-cities-list', 'uses' => 'ShopController@getCoveredCitiesList']);
        Route::post('shop/{shop}/{state}/setCoveredCities', ['as' => 'front.profile.shop.set-covered-cities', 'uses' => 'ShopController@setCoveredCities']);
        Route::get('shop/{shop}/clients', ['as' => 'front.profile.shop.clients', 'uses' => 'ShopController@clients']);

        /**:::::::::::::::**| Products |**:::::::::::::::**/
        Route::resource('product', 'ProductController', ['as' => 'front.profile']);
        Route::post('product/{product}/uploadGalleryImage', ['as' => 'front.profile.product.gallery.store', 'uses' => 'ProductController@uploadGalleryImage']);
        Route::delete('product/{product}/{attachment}/deleteGalleryImage', ['as' => 'front.profile.product.gallery.destroy', 'uses' => 'ProductController@destroyGalleryImage']);

        /**:::::::::::::::**| ProductDetails |**:::::::::::::::**/
        Route::get('productDetail/{product}/create', ['as' => 'front.profile.productDetail.create', 'uses' => 'ProductDetailController@create']);
        Route::post('productDetail/{product}', ['as' => 'front.profile.productDetail.store', 'uses' => 'ProductDetailController@store']);
        Route::get('productDetail/{productDetail}/edit', ['as' => 'front.profile.productDetail.edit', 'uses' => 'ProductDetailController@edit']);
        Route::patch('productDetail/{productDetail}', ['as' => 'front.profile.productDetail.update', 'uses' => 'ProductDetailController@update']);
        Route::patch('productDetail/{productDetail}/setAsIndex', ['as' => 'front.profile.productDetail.setAsIndex', 'uses' => 'ProductDetailController@setAsIndex']);
        Route::delete('productDetail/{productDetail}', ['as' => 'front.profile.productDetail.destroy', 'uses' => 'ProductDetailController@destroy']);

        /**:::::::::::::::**| ProductPropertyOptions |**:::::::::::::::**/
        Route::post('productPropertyDetail', ['as' => 'front.profile.productPropertyDetail.store', 'uses' => 'ProductPropertyDetailController@store']);
        Route::delete('productPropertyDetail/{productPropertyDetail}', ['as' => 'front.profile.productPropertyDetail.destroy', 'uses' => 'ProductPropertyDetailController@destroy']);

        /**:::::::::::::::**| Special Suggestions |**:::::::::::::::**/
        Route::post('specialSuggestion/{productDetail}', ['as' => 'front.profile.specialSuggestion.store', 'uses' => 'SpecialSuggestionController@store']);
        Route::delete('specialSuggestion/{specialSuggestion}', ['as' => 'front.profile.specialSuggestion.destroy', 'uses' => 'SpecialSuggestionController@destroy']);

        /**:::::::::::::::**| First page special suggestion |**:::::::::::::::**/
        Route::get('firstPageSpecialSuggestion/{specialSuggestion}/create', ['as' => 'front.profile.firstPageSpecialSuggestion.create', 'uses' => 'FirstPageSpecialSuggestionController@create']);
        Route::post('firstPageSpecialSuggestion', ['as' => 'front.profile.firstPageSpecialSuggestion.store', 'uses' => 'FirstPageSpecialSuggestionController@store']);
        Route::post('firstPageSpecialSuggestion/verify', ['as' => 'front.profile.firstPageSpecialSuggestion.verify', 'uses' => 'FirstPageSpecialSuggestionController@verify']);

        /**:::::::::::::::**| Special Sells |**:::::::::::::::**/
        Route::post('specialSells/{productDetail}', ['as' => 'front.profile.specialSell.store', 'uses' => 'SpecialSellController@store']);
        Route::delete('specialSells/{specialSell}', ['as' => 'front.profile.specialSell.destroy', 'uses' => 'SpecialSellController@destroy']);

        /**:::::::::::::::**| First page special sell |**:::::::::::::::**/
        Route::get('firstPageSpecialSell/{specialSell}/create', ['as' => 'front.profile.firstPageSpecialSell.create', 'uses' => 'FirstPageSpecialSellController@create']);
        Route::post('firstPageSpecialSell', ['as' => 'front.profile.firstPageSpecialSell.store', 'uses' => 'FirstPageSpecialSellController@store']);
        Route::post('firstPageSpecialSell/verify', ['as' => 'front.profile.firstPageSpecialSell.verify', 'uses' => 'FirstPageSpecialSellController@verify']);
        /**:::::::::::::::**| Addresses |**:::::::::::::::**/
        Route::resource('address', 'AddressController', ['as' => 'front.profile']);

        /**:::::::::::::::**| Announcements |**:::::::::::::::**/
        Route::get('اعلانها', ['as' => 'front.profile.announcement.index', 'uses' => 'AnnouncementController@index']);
        Route::delete('delete-announcement/{announcement}', ['as' => 'front.profile.announcement.delete', 'uses' => 'AnnouncementController@destroy']);

        /**:::::::::::::::**| Comments |**:::::::::::::::**/
        Route::get('نظرات-من', ['as' => 'front.profile.comment.index', 'uses' => 'CommentController@index']);
        Route::get('{comment}/نظرات-من', ['as' => 'front.profile.comment.edit', 'uses' => 'CommentController@edit']);
        Route::patch('comments/{comment}', ['as' => 'front.profile.comment.update', 'uses' => 'CommentController@update']);
        Route::delete('comments/{comment}/delete', ['as' => 'front.profile.comment.delete', 'uses' => 'CommentController@destroy']);

        /**:::::::::::::::**| Friends to share product |**:::::::::::::::**/
        Route::get('/friends-to-share', ['as' => 'front.friends-to-share', 'uses' => 'ShareController@friendsToShare']);
        Route::post('/share-with-friends', ['as' => 'front.share-with-friends', 'uses' => 'ShareController@shareWithFriends']);

        /**:::::::::::::::**| Wallet |**:::::::::::::::**/
        Route::group(['prefix' => 'wallet'], function () {
            Route::get('/', ['as' => 'front.profile.wallet.index', 'uses' => 'WalletController@index']);
            Route::get('/{wallet}/transactions', ['as' => 'front.profile.wallet.transactions', 'uses' => 'WalletController@transactions']);
        });

        /**:::::::::::::::**| BankCart |**:::::::::::::::**/
        Route::resource('bankCart', 'BankCartController', ['as' => 'front.profile']);

        /**:::::::::::::::**| Checkout |**:::::::::::::::**/
        Route::group(['prefix' => 'checkout'], function () {
            Route::get('/', ['as' => 'front.profile.checkout.index', 'uses' => 'CheckoutController@index']);
            Route::post('/', ['as' => 'front.profile.checkout.store', 'uses' => 'CheckoutController@store']);
        });

        /**:::::::::::::::**| Credit |**:::::::::::::::**/
        Route::group(['prefix' => 'credit'], function () {
            Route::get('/', ['as' => 'front.profile.credit.index', 'uses' => 'CreditController@index']);

            Route::get('/request_checkout_index', ['as' => 'front.profile.credit.request.index', 'uses' => 'CreditController@requestCreditIndex']);
            Route::post('/request_checkout', ['as' => 'front.profile.credit.request.store', 'uses' => 'CreditController@requestCredit']);

            Route::post('/', ['as' => 'front.profile.credit.store', 'uses' => 'CreditController@store']);
            Route::post('/verify', ['as' => 'front.profile.credit.verify', 'uses' => 'CreditController@verify']);
        });


    });


    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#
    # End specific
    #-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#-#

});

