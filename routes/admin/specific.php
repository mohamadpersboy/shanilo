<?php
Route::group(['prefix' => env('ADMIN_ROUTE'), 'namespace' => 'Admin', 'middleware' => ['admin.login','auth.admin:admins', 'acl']], function () {
    Route::get('slider/create', 'SliderController@create')->name('slider.create');
    Route::post('slider/store', 'SliderController@store')->name('slider.store');
    Route::post('slider/delete/{id}', 'SliderController@delete')->name('slider.delete');
    Route::get('social_network','SocialNetworkController@index')->name('social_network.index');
    Route::post('social_network','SocialNetworkController@store')->name('social_network.store');
    Route::post('social_network/delete/{id}','SocialNetworkController@delete')->name('social_network.delete');
    ############################################################
    # Specific #
    ############################################################
    Route::group(['namespace' => 'Specific'], function () {
        Route::post('product_message','ProductMessageController@store')->name('product_message.store');
        /**:::::::::::::::**| Plans |**:::::::::::::::**/
        Route::group(['protect_alias' => 'plan'], function () {
            Route::resource('plan', 'PlanController', ['as' => 'admin']);
        });
        Route::post('/plan/DataTable', ['as' => 'admin.plan.DataTable', 'uses' => 'PlanController@DataTable']);


        /**:::::::::::::::**| Product Category |**:::::::::::::::**/
        Route::group(['protect_alias' => 'productcategory'], function () {
            Route::resource('productCategory', 'ProductCategoryController', ['as' => 'admin']);
        });
        Route::post('/productCategory/DataTable', ['as' => 'admin.productCategory.DataTable', 'uses' => 'ProductCategoryController@DataTable']);

        /**:::::::::::::::**| Order |**:::::::::::::::**/
        Route::group(['protect_alias' => 'order'], function () {
            Route::resource('order', 'OrderController', ['as' => 'admin']);
        });
        Route::post('/order/DataTable', ['as' => 'admin.order.DataTable', 'uses' => 'OrderController@DataTable']);
        Route::post('/order/export', ['as' => 'admin.order.export', 'uses' => 'OrderController@export']);
        Route::get('/order/{order}/showAsUser', ['as' => 'admin.order.showAsUser', 'uses' => 'OrderController@showAsUser']);
        Route::get('/order/{order}/showAsSeller', ['as' => 'admin.order.showAsSeller', 'uses' => 'OrderController@showAsSeller']);
        /**:::::::::::::::**| Payment |**:::::::::::::::**/
        Route::group(['protect_alias' => 'payment'], function () {
            Route::resource('payment', 'PaymentController', ['as' => 'admin']);
        });
        Route::post('/payment/DataTable', ['as' => 'admin.payment.DataTable', 'uses' => 'PaymentController@DataTable']);

        /**:::::::::::::::**| Technical Specification |**:::::::::::::::**/
        Route::group(['protect_alias' => 'technicalspecification'], function () {
            Route::resource('technicalSpecification', 'TechnicalSpecificationController', ['as' => 'admin']);
        });
        Route::post('/technicalSpecification/DataTable', ['as' => 'admin.technicalSpecification.DataTable', 'uses' => 'TechnicalSpecificationController@DataTable']);

        /**:::::::::::::::**| Messages |**:::::::::::::::**/
        Route::group(['protect_alias' => 'message'], function () {
            Route::resource('message', 'MessageController', ['as' => 'admin']);
        });
        Route::post('/message/DataTable', ['as' => 'admin.message.DataTable', 'uses' => 'MessageController@DataTable']);

        /**:::::::::::::::**| Products |**:::::::::::::::**/
        Route::group(['protect_alias' => 'product'], function () {
            Route::resource('product', 'ProductController', ['as' => 'admin']);
        });
        Route::post('/product/DataTable', ['as' => 'admin.product.DataTable', 'uses' => 'ProductController@DataTable']);
        Route::get('/product/getProductDetails/{product?}', ['as' => 'admin.shop.getProductDetails', 'uses' => 'ProductController@getProductDetails']);

        /**:::::::::::::::**| Shops |**:::::::::::::::**/
        Route::group(['protect_alias' => 'shop'], function () {
            Route::resource('shop', 'ShopController', ['as' => 'admin']);
        });
        Route::post('/shop/DataTable', ['as' => 'admin.shop.DataTable', 'uses' => 'ShopController@DataTable']);
        Route::get('/shop/getProducts/{shop?}', ['as' => 'admin.shop.getProducts', 'uses' => 'ShopController@getProducts']);

        /**:::::::::::::::**| First page special suggestions |**:::::::::::::::**/
        Route::group(['protect_alias' => 'firstpagespecialsuggestion'], function () {
            Route::resource('firstPageSpecialSuggestion', 'FirstPageSpecialSuggestionController', ['as' => 'admin']);
        });
        Route::post('/firstPageSpecialSuggestion/DataTable', ['as' => 'admin.firstPageSpecialSuggestion.DataTable', 'uses' => 'FirstPageSpecialSuggestionController@DataTable']);

        /**:::::::::::::::**| First page special sells |**:::::::::::::::**/
        Route::group(['protect_alias' => 'firstpagespecialsell'], function () {
            Route::resource('firstPageSpecialSell', 'FirstPageSpecialSellController', ['as' => 'admin']);
        });
        Route::post('/firstPageSpecialSell/DataTable', ['as' => 'admin.firstPageSpecialSell.DataTable', 'uses' => 'FirstPageSpecialSellController@DataTable']);

        /**:::::::::::::::**| Articles |**:::::::::::::::**/
        Route::group(['protect_alias' => 'article'], function () {
            Route::resource('article', 'ArticleController', ['as' => 'admin']);
        });
        Route::post('/article/DataTable', ['as' => 'admin.article.DataTable', 'uses' => 'ArticleController@DataTable']);
        Route::post('article/active','ArticleController@active')->name('article.active');
        Route::post('article/deactive','ArticleController@deActive')->name('article.deactive');
        /**:::::::::::::::**| ViolationReport |**:::::::::::::::**/
        Route::group(['protect_alias' => 'violationreport'], function () {
            Route::resource('violationReport', 'ViolationReportController', ['as' => 'admin']);
        });
        Route::post('/violationReport/DataTable', ['as' => 'admin.violationReport.DataTable', 'uses' => 'ViolationReportController@DataTable']);

        /**:::::::::::::::**| Checkouts |**:::::::::::::::**/
        Route::group(['protect_alias' => 'checkout'], function () {
            Route::resource('checkout', 'CheckoutController', ['as' => 'admin']);
        });
        Route::post('/checkout/DataTable', ['as' => 'admin.checkout.DataTable', 'uses' => 'CheckoutController@DataTable']);
        Route::post('/checkout/export', ['as' => 'admin.checkout.export', 'uses' => 'CheckoutController@export']);

        /** Credit */

        Route::get('/credit', ['as' => 'admin.credit.index', 'uses' => 'CreditController@index']);
        Route::get('/credit/{credit}', ['as' => 'admin.profile.credit.request.edit', 'uses' => 'CreditController@edit']);
        Route::patch('/credit/{credit}', ['as' => 'admin.profile.create.request.update', 'uses' => 'CreditController@update']);


        /**:::::::::::::::**| Brand |**:::::::::::::::**/
        Route::group(['protect_alias' => 'brand'], function () {
            Route::resource('brand', 'BrandController', ['as' => 'admin']);
        });
        Route::post('/brand/DataTable', ['as' => 'admin.brand.DataTable', 'uses' => 'BrandController@DataTable']);

        /**:::::::::::::::**| Plan |**:::::::::::::::**/
        Route::group(['protect_alias' => 'plan'], function () {
            Route::resource('plan', 'PlanController', ['as' => 'admin']);
        });
        Route::post('/plan/DataTable', ['as' => 'admin.plan.DataTable', 'uses' => 'PlanController@DataTable']);

        /**:::::::::::::::**| State |**:::::::::::::::**/
        Route::group(['protect_alias' => 'state'], function () {
            Route::resource('state', 'StateController', ['as' => 'admin']);
        });
        Route::post('/state/DataTable', ['as' => 'admin.state.DataTable', 'uses' => 'StateController@DataTable']);
        /**:::::::::::::::**| City |**:::::::::::::::**/
        Route::group(['protect_alias' => 'city'], function () {
            Route::resource('city', 'CityController', ['as' => 'admin']);
        });
        Route::post('/city/DataTable', ['as' => 'admin.city.DataTable', 'uses' => 'CityController@DataTable']);
    });
    ############################################################
    # End Specific #
    ############################################################
});
