<?php

Route::group(['namespace' => 'Front',
    'middleware' => ['front.login']
    /*'middleware'=>'HTMLMin\HTMLMin\Http\Middleware\MinifyMiddleware'*/], function () {

    Route::group(['middleware' => 'confirmed'], function () {
        ############################################################
        # Base #
        ############################################################
        Route::group(['namespace' => 'Base'], function () {
            Route::get('/test', 'HomeController@test');
            Route::get('/sliders','HomeController@sliders');
            Route::get('/social_network','HomeController@socialNetwork');
            //Home
            Route::get('/', ['as' => 'front.home.index', 'uses' => 'HomeController@index']);

            //Reset
            /* Route::get('/reset', ['as' => 'front.home.reset', 'uses' => 'HomeController@reset']);*/
            //Search for cities
            Route::get('/search-for-cities', ['as' => 'front.home.search-for-cities', 'uses' => 'HomeController@searchForCities']);
            //About Us
            Route::get('/درباره-ما', ['as' => 'front.about.index', 'uses' => 'AboutController@index']);
            //Article
            Route::get('/مقالات', ['as' => 'front.article.index', 'uses' => 'ArticleController@index']);
            Route::get('/مقالات/{article}/{title?}', ['as' => 'front.article.show', 'uses' => 'ArticleController@show']);
            //Contact Us
            Route::get('/تماس-با-ما', ['as' => 'front.contact.index', 'uses' => 'ContactController@index']);

            Route::get('/ارسال-ایمیل', ['as' => 'front.contact.create', 'uses' => 'ContactController@create']);

            Route::post('/contact/create', ['as' => 'front.contact.store', 'uses' => 'ContactController@store']);
            //News
            Route::get('اطلاعیه-ها', ['as' => 'front.news.index', 'uses' => 'NewsController@index']);
            Route::get('/اطلاعیه-ها/{news}/{title?}', ['as' => 'front.news.show', 'uses' => 'NewsController@show']);
            //Policy
            Route::get('قوانین-و-سیاست-های-سایت/', ['as' => 'front.policy.index', 'uses' => 'PolicyController@index']);
            //FAQ
            Route::get('/پرسش-و-پاسخ-متداول', ['as' => 'front.faq.index', 'uses' => 'FaqController@index']);
            //Guide
            Route::get('/راهنمای-سایت', ['as' => 'front.guide.index', 'uses' => 'GuideController@index']);
            //Picture Gallery
            Route::get('گالری-عکس', ['as' => 'front.picturegallery.index', 'uses' => 'PictureGalleryController@index']);
            //Video Gallery
            Route::get('گالری-ویدیو', ['as' => 'front.videogallery.index', 'uses' => 'VideoGalleryController@index']);
            Route::get('{videoGallery}/گالری-ویدیو', ['as' => 'front.videogallery.show', 'uses' => 'VideoGalleryController@show']);
            //NewsLetter
            Route::get('/عضویت-در-خبرنامه', ['as' => 'front.newsletter.index', 'uses' => 'NewsletterController@index']);
            Route::post('/newsletter/store', ['as' => 'front.newsletter.store', 'uses' => 'NewsletterController@store']);
            Route::get('/newsletter/{newsletter}', ['as' => 'front.newsletter.destroy', 'uses' => 'NewsletterController@destroy']);

            //Share
            Route::post('/share/store', ['as' => 'front.share.store', 'uses' => 'ShareController@store']);
            //State
            Route::post('/state/change', ['as' => 'front.state.change', 'uses' => 'StateController@change']);
            //Site Map
            Route::get('نقشه-سایت', ['as' => 'front.sitemap.index', 'uses' => 'SiteMapController@index']);


            //Auto fill selects
            Route::get('/get-cities/{state?}', ['as' => 'front.autoselect.getcities', 'uses' => function (\App\Models\Base\State $state) {
                return $state->cities()/*->whereHas('send_types')*/
                ->orderBy('name')->get(['name as title', 'id as value']);
            }]);
            Route::get('/get-position/{type}/{id?}', ['as' => 'front.map.position', 'uses' => function ($type, $id) {
                $class = 'App\\Models\\Base\\' . ucfirst($type);
                $location = $class::find($id);
                return [
                    'latitude' => $location->latitude,
                    'longitude' => $location->longitude,
                    'zoom' => $type == 'state' ? 8 : 14
                ];
            }]);

            //refresh captcha
            Route::get('/refresh-captcha', ['as' => 'front.refresh-captcha', 'uses' => function (\App\Models\Base\State $state) {
                return [
                    'src' => Captcha::src('flat')
                ];
            }]);
        });
        ############################################################
        # End Base #
        ############################################################


        ############################################################
        # Advertisement #
        ############################################################
        Route::group(['namespace' => 'Advertisement'], function () {
            //Advertisement
            Route::get('/تبلیغات', ['as' => 'front.advertisement.index', 'uses' => 'AdvertisementController@index']);
            Route::post('/advertisement/choosePlan', ['as' => 'front.advertisement.choosePlan', 'uses' => 'AdvertisementController@choosePlan']);
            Route::post('/advertisement/chooseTime', ['as' => 'front.advertisement.chooseTime', 'uses' => 'AdvertisementController@chooseTime']);
            Route::post('/advertisement/store', ['as' => 'front.advertisement.store', 'uses' => 'AdvertisementController@store']);
        });
        ############################################################
        # End Advertisement #
        ############################################################

        //Product
        /*    Route::get('/محصولات/{category?}', ['as' => 'front.product.index', 'uses' => 'ProductController@index']);
            Route::get('/محصول/{title}/{product?}', ['as' => 'front.product.show', 'uses' => 'ProductController@show']);
            Route::post('/product/search', ['as' => 'front.product.search', 'uses' => 'ProductController@search']);
            Route::post('/product/like', ['as' => 'front.product.like', 'uses' => 'ProductController@like']);
            Route::post('/product/bookmark', ['as' => 'front.product.bookmark', 'uses' => 'ProductController@bookmark']);
            Route::post('/product/notice', ['as' => 'front.product.notice', 'uses' => 'ProductController@notice']);
            Route::post('/product/rate', ['as' => 'front.product.rate', 'uses' => 'ProductController@rate']);*/
        //Comment
        Route::post('/comment/addComment', ['as' => 'front.comment.addComment', 'uses' => 'CommentController@addComment']);
        Route::post('/comment/getUserComments', ['as' => 'front.comment.getUserComments', 'uses' => 'CommentController@getUserComments']);
        Route::post('/comment/deleteComment', ['as' => 'front.comment.deleteComment', 'uses' => 'CommentController@deleteComment']);
        Route::post('/comment/getAllComments', ['as' => 'front.comment.getAllComments', 'uses' => 'CommentController@getAllComments']);
        Route::post('/comment/answerComment', ['as' => 'front.comment.answerComment', 'uses' => 'CommentController@answerComment']);
        Route::post('/comment/getChildComments', ['as' => 'front.comment.getChildComments', 'uses' => 'CommentController@getChildComments']);
    });


    Route::group(['namespace' => 'Auth'], function () {
        // Login Routes...
        Route::post('/logout', ['as' => 'front.auth.logout', 'uses' => 'FrontLoginController@logout']);
        Route::group(['middleware' => 'guest'], function () {
            Route::get('/ورود-به-سایت', ['as' => 'front.auth.login.show', 'uses' => 'FrontLoginController@showLoginForm']);
            Route::post('/login-auth', ['as' => 'front.auth.login', 'uses' => 'FrontLoginController@login']);

            // Registration Routes...
            Route::get('/عضویت-در-سایت', ['as' => 'front.auth.register.show', 'uses' => 'RegisterController@showRegistrationForm']);

            // Route::post('/confirm', ['as' => 'front.auth.confirm','uses' => 'RegisterController@confirm']);
            //Route::get('/confirm/{code}', ['as' => 'front.auth.confirm','uses' => 'RegisterController@confirm']);
            // Password Reset Routes...

            //Route::get('/تایید-شماره-همراه-فراموشی', ['as' => 'front.auth.forgot.mobile', 'uses' => 'ForgotPasswordController@showMobileForm']);
            Route::post('/password/mobile', ['as' => 'front.auth.password.mobile', 'uses' => 'ForgotPasswordController@sendResetMobile']);
            Route::post('/password/mobile/confirm', ['as' => 'front.auth.password.mobile.do.confirm', 'uses' => 'ForgotPasswordController@confirm']);
            Route::get('/password/mobile/check-code', ['as' => 'front.auth.password.mobile.confirm', 'uses' => 'ForgotPasswordController@showMobileConfirmation']);
            Route::get('/فراموشی-رمز-عبور', ['as' => 'front.auth.password.request', 'uses' => 'ForgotPasswordController@showLinkRequestForm']);
            //Route::post('/password/email', ['as' => 'front.auth.password.email', 'uses' => 'ForgotPasswordController@sendResetLinkEmail']);
            // Route::post('/password/confirm', ['as' => 'front.auth.password.confirm','uses' => 'ForgotPasswordController@confirm']);
            Route::get('/password/reset', ['as' => 'front.password.reset', 'uses' => 'ResetPasswordController@showResetForm']);
            Route::post('/password/reset', ['as' => 'front.auth.password.reset', 'uses' => 'ResetPasswordController@reset']);
        });
    });

    Route::group(['namespace' => 'Auth'], function () {
        Route::get('/تایید-شماره-همراه', ['as' => 'front.auth.register.mobile', 'uses' => 'RegisterController@showMobileConfirmation']);
        Route::post('/register', ['as' => 'front.auth.register', 'uses' => 'RegisterController@register']);
        Route::post('/confirm', ['as' => 'front.auth.register.confirm', 'uses' => 'RegisterController@confirm']);
        Route::get('/confirmed', ['as' => 'front.auth.register.confirmed', 'uses' => 'RegisterController@showFavoriteCategories'])->middleware('auth');
        Route::post('/set-user-favorite-categories', ['as' => 'front.auth.register.set-favorites', 'uses' => 'RegisterController@setFavoriteCategories'])->middleware('auth');
    });
});




