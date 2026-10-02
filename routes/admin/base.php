<?php
Route::group(['prefix' => env('ADMIN_ROUTE'), 'namespace' => 'Admin', 'middleware' => ['admin.login','auth.admin:admins', 'acl']], function () {

    ############################################################
    # Base #
    ############################################################
   
    Route::group(['namespace' => 'Base'], function () {
        /******************************/
        //User
        /******************************/
        Route::get('user/{user}/loginAs', ['as' => 'admin.user.loginas', 'uses' => 'UserController@loginAs']);

        //Home
        Route::get('/', ['as' => 'admin.home.index', 'uses' => 'HomeController@index']);

        /******************************/
        //About us
        /******************************/
        Route::group(['protect_alias' => 'aboutus'], function () {
            Route::resource('aboutUs', 'AboutUsController', ['as' => 'admin']);
        });
        Route::post('/aboutUs/DataTable', ['as' => 'admin.aboutUs.DataTable', 'uses' => 'AboutUsController@DataTable']);

        /******************************/
        //Contacts
        /******************************/
        Route::post('/contact/DataTable', ['as' => 'admin.contact.DataTable', 'uses' => 'ContactController@DataTable']);
        Route::group(['protect_alias' => 'contact'], function () {
            Route::resource('contact', 'ContactController', ['as' => 'admin']);
        });

        //Get State cities
        Route::get('/state/getChildren/{state?}', ['as' => 'admin.state.children', 'uses' => 'StateController@getChildren']);
        //Roles
        Route::group(['is' => 'administrator|atlas-administrator'], function () {
            Route::resource('role', 'RoleController', ['as' => 'admin']);
        });
        Route::post('/role/DataTable', ['as' => 'admin.role.DataTable', 'uses' => 'RoleController@DataTable']);

        //Permission
        Route::group(['is' => 'atlas-administrator'], function () {
            Route::resource('permission', 'PermissionController', ['as' => 'admin']);
        });
        Route::post('/permission/DataTable', ['as' => 'admin.permission.DataTable', 'uses' => 'PermissionController@DataTable']);

        //Log Activity
        Route::group(['protect_alias' => 'logactivity'], function () {
            Route::resource('logactivity', 'LogActivityController', ['as' => 'admin']);
        });
        Route::post('/logactivity/DataTable', ['as' => 'admin.logactivity.DataTable', 'uses' => 'LogActivityController@DataTable']);

        //Admin
        Route::group(['is' => 'administrator|atlas-administrator'], function () {
            Route::resource('admin', 'AdminController', ['as' => 'admin']);
        });
        Route::post('/admin/DataTable', ['as' => 'admin.admin.DataTable', 'uses' => 'AdminController@DataTable']);
        Route::post('/admin/changePassword', ['as' => 'admin.admin.changePassword', 'uses' => 'AdminController@changePassword']);

        //User
        Route::group(['protect_alias' => 'user'], function () {
            //User type
            Route::any('user/changeType/{user}', ['as' => 'admin.user.change-type', 'uses' => 'UserController@changeType']);
            Route::resource('user', 'UserController', ['as' => 'admin']);
            Route::post('/user/excel', ['as' => 'admin.user.export', 'uses' => 'UserController@export']);
            Route::post('/state/change', ['as' => 'admin.state.change', 'uses' => 'UserController@StateChange']);
        });
        Route::post('/user/DataTable', ['as' => 'admin.user.DataTable', 'uses' => 'UserController@DataTable']);

        //Sortable
        Route::patch('/sort', ['as' => 'admin.sort.update', 'uses' => 'SortableController@update']);

        //Switch
        Route::patch('/switch/{object}', ['as' => 'admin.switch.update', 'uses' => 'SwitchController@update']);

        //Language
        Route::get('/language/{lang}', ['as' => 'admin.language', 'uses' => 'LanguageController@show']);

        //Delete
        Route::delete('/delete-file', ['as' => 'admin.ajax.delete.file', 'uses' => 'DeleteController@deleteFile']);

        //Fine Uploader
        Route::post('/uploader/upload', ['as' => 'admin.uploader.upload', 'uses' => '\Optimus\FineuploaderServer\Controller\LaravelController@upload']);
        Route::delete('/uploader/delete/{uuid}', ['as' => 'admin.uploader.delete', 'uses' => '\Optimus\FineuploaderServer\Controller\LaravelController@delete']);
        Route::get('/uploader/session', ['as' => 'admin.uploader.session', 'uses' => '\Optimus\FineuploaderServer\Controller\LaravelController@session']);

        //About Setting
        Route::group(['protect_alias' => 'about'], function () {
            Route::get('/about', ['as' => 'admin.about.index', 'uses' => 'AboutController@index']);
            Route::post('/about', ['as' => 'admin.about.update', 'uses' => 'AboutController@update']);
        });

        //App link Setting
        Route::group(['protect_alias' => 'applink'], function () {
            Route::get('/applink', ['as' => 'admin.applink.index', 'uses' => 'AppLinkController@index']);
            Route::post('/applink', ['as' => 'admin.applink.update', 'uses' => 'AppLinkController@update']);
        });

        //ContactUs Setting
        /*Route::group(['protect_alias' => 'contact-us'], function () {
            Route::get('/contact-us', ['as' => 'admin.contact-us.index', 'uses' => 'ContactUsController@index']);
            Route::post('/contact-us', ['as' => 'admin.contact-us.update', 'uses' => 'ContactUsController@update']);
            Route::delete('/contact-us', ['as' => 'admin.contact-us.destroy', 'uses' => 'ContactController@destroy']);
        });*/

        //Social Setting
        Route::group(['protect_alias' => 'social'], function () {
            Route::get('/social', ['as' => 'admin.social.index', 'uses' => 'SocialController@index']);
            Route::post('/social', ['as' => 'admin.social.update', 'uses' => 'SocialController@update']);
        });

        //Mobile Pre Order Setting
        Route::group(['protect_alias' => 'mobilepreorder'], function () {
            Route::get('/mobilepreorder', ['as' => 'admin.mobilepreorder.index', 'uses' => 'MobilePreOrderController@index']);
            Route::post('/mobilepreorder', ['as' => 'admin.mobilepreorder.update', 'uses' => 'MobilePreOrderController@update']);
        });

        //Site Content Setting
        Route::group(['protect_alias' => 'sitecontent'], function () {
            Route::get('/sitecontent', ['as' => 'admin.sitecontent.index', 'uses' => 'SiteContentController@index']);
            Route::post('/sitecontent', ['as' => 'admin.sitecontent.update', 'uses' => 'SiteContentController@update']);
        });

       /* //Article
        Route::group(['protect_alias' => 'article'], function () {
            Route::resource('article', 'ArticleController', ['as' => 'admin']);
        });
        Route::post('/article/DataTable', ['as' => 'admin.article.DataTable', 'uses' => 'ArticleController@DataTable']);

        //Article Category
        Route::group(['protect_alias' => 'articlecategory'], function () {
            Route::resource('articleCategory', 'ArticleCategoryController', ['as' => 'admin']);
        });
        Route::post('/articleCategory/DataTable', ['as' => 'admin.articleCategory.DataTable', 'uses' => 'ArticleCategoryController@DataTable']);*/

        //Site content image
        Route::group(['protect_alias' => 'sitecontentimage'], function () {
            Route::resource('siteContentImage', 'SiteContentImageController', ['as' => 'admin']);
        });
        Route::post('/siteContentImage/DataTable', ['as' => 'admin.siteContentImage.DataTable', 'uses' => 'SiteContentImageController@DataTable']);


        //News
        Route::group(['protect_alias' => 'news'], function () {
            Route::resource('news', 'NewsController', ['as' => 'admin']);
        });
        Route::post('/news/DataTable', ['as' => 'admin.news.DataTable', 'uses' => 'NewsController@DataTable']);

        //Policy
        Route::group(['protect_alias' => 'policy'], function () {
            Route::resource('policy', 'PolicyController', ['as' => 'admin']);
        });
        Route::post('/policy/DataTable', ['as' => 'admin.policy.DataTable', 'uses' => 'PolicyController@DataTable']);

        //Faq
        Route::group(['protect_alias' => 'faq'], function () {
            Route::resource('faq', 'FaqController', ['as' => 'admin']);
        });
        Route::post('/faq/DataTable', ['as' => 'admin.faq.DataTable', 'uses' => 'FaqController@DataTable']);

        //Guide
        Route::group(['protect_alias' => 'guide'], function () {
            Route::resource('guide', 'GuideController', ['as' => 'admin']);
        });
        Route::post('/guide/DataTable', ['as' => 'admin.guide.DataTable', 'uses' => 'GuideController@DataTable']);

        //Picture Gallery
        Route::group(['protect_alias' => 'picturegallery'], function () {
            Route::resource('picturegallery', 'PictureGalleryController', ['as' => 'admin']);
        });
        Route::post('/picturegallery/DataTable', ['as' => 'admin.picturegallery.DataTable', 'uses' => 'PictureGalleryController@DataTable']);

        //Video Gallery
        Route::group(['protect_alias' => 'videogallery'], function () {
            Route::resource('videogallery', 'VideoGalleryController', ['as' => 'admin']);
        });
        Route::post('/videogallery/DataTable', ['as' => 'admin.videogallery.DataTable', 'uses' => 'VideoGalleryController@DataTable']);

        //NewsLetter
        Route::group(['protect_alias' => 'newsletter'], function () {
            Route::resource('newsletter', 'NewsletterController', ['as' => 'admin']);
            Route::post('/newsletter/excel', ['as' => 'admin.newsletter.export', 'uses' => 'NewsletterController@export']);
        });
        Route::post('/newsletter/DataTable', ['as' => 'admin.newsletter.DataTable', 'uses' => 'NewsletterController@DataTable']);

        //Bank
        Route::group(['protect_alias' => 'bank'], function () {
            Route::resource('bank', 'BankController', ['as' => 'admin']);
        });
        Route::post('/bank/DataTable', ['as' => 'admin.bank.DataTable', 'uses' => 'BankController@DataTable']);

        //Education
        Route::group(['protect_alias' => 'education'], function () {
            Route::resource('education', 'EducationController', ['as' => 'admin']);
        });
        Route::post('/education/DataTable', ['as' => 'admin.education.DataTable', 'uses' => 'EducationController@DataTable']);

        //Comment
        Route::group(['protect_alias' => 'comment'], function () {
            Route::resource('comment', 'CommentController', ['as' => 'admin']);
        });
        Route::post('/comment/DataTable', ['as' => 'admin.comment.DataTable', 'uses' => 'CommentController@DataTable']);

        //Slider
        Route::group(['protect_alias' => 'slider'], function () {
            Route::resource('slider', 'SliderController', ['as' => 'admin']);
        });
        Route::post('/slider/DataTable', ['as' => 'admin.slider.DataTable', 'uses' => 'SliderController@DataTable']);

        //Member
        Route::group(['protect_alias' => 'member'], function () {
            Route::resource('member', 'MemberController', ['as' => 'admin']);
            Route::resource('member_category', 'MemberCategoryController', ['as' => 'admin']);
        });
        Route::post('/member/DataTable', ['as' => 'admin.member.DataTable', 'uses' => 'MemberController@DataTable']);
        Route::post('/member_category/DataTable', ['as' => 'admin.member_category.DataTable', 'uses' => 'MemberCategoryController@DataTable']);

        //Color
        Route::group(['protect_alias' => 'color'], function () {
            Route::resource('color', 'ColorController', ['as' => 'admin']);
        });
        Route::post('/color/DataTable', ['as' => 'admin.color.DataTable', 'uses' => 'ColorController@DataTable']);

        //Ticket
        Route::group(['protect_alias' => 'ticket'], function () {
            Route::resource('ticket', 'TicketController', ['as' => 'admin']);
        });
        Route::post('/ticket/DataTable', ['as' => 'admin.ticket.DataTable', 'uses' => 'TicketController@DataTable']);

        //Chat
        Route::group(['protect_alias' => 'chat'], function () {
            Route::resource('chat', 'ChatController', ['as' => 'admin']);
        });
        Route::post('/chat/DataTable', ['as' => 'admin.chat.DataTable', 'uses' => 'ChatController@DataTable']);

        //Contact us
        Route::group(['protect_alias' => 'contact'], function () {
            Route::resource('contactUs', 'ContactUsController', ['as' => 'admin']);
        });
        Route::post('/contactUs/DataTable', ['as' => 'admin.contactUs.DataTable', 'uses' => 'ContactUsController@DataTable']);

        // Category
        Route::group(['protect_alias' => 'category'], function () {
            Route::resource('/category', 'CategoryController', ['as' => 'admin']);
        });
        Route::post('/category/data-table', 'CategoryController@dataTable')->name('admin.category.data-table');

        // Category2
        Route::group(['protect_alias' => 'category2'], function () {
            Route::resource('/category2', 'Category2Controller', ['as' => 'admin']);
        });
        Route::post('/category2/data-table', 'Category2Controller@dataTable')->name('admin.category2.data-table');

        // Tag
        Route::group(['protect_alias' => 'tag'], function () {
            Route::resource('/tag', 'TagController', ['as' => 'admin']);
        });
        Route::post('/tag/data-table', 'TagController@dataTable')->name('admin.tag.data-table');

        // Tag2
        Route::group(['protect_alias' => 'tag2'], function () {
            Route::resource('/tag2', 'Tag2Controller', ['as' => 'admin']);
        });
        Route::post('/tag2/data-table', 'Tag2Controller@dataTable')->name('admin.tag2.data-table');

        //Calendar
        Route::group(['protect_alias' => 'calendar'], function () {
            Route::resource('calendar', 'CalendarController', ['as' => 'admin']);
        });

        //Week
        Route::group(['protect_alias' => 'week'], function () {
            Route::resource('week', 'WeekController', ['as' => 'admin']);
        });

        //Send Type
        Route::group(['protect_alias' => 'sendtype'], function () {
            Route::resource('send_type', 'SendTypeController', ['as' => 'admin']);
        });
        Route::post('/send_type/ChangeContent', ['as' => 'admin.send_type.ChangeContent', 'uses' => 'SendTypeController@ChangeContent']);
        Route::post('/send_type/ShowState', ['as' => 'admin.send_type.ShowState', 'uses' => 'SendTypeController@ShowState']);
        Route::post('/send_type/StatePrice', ['as' => 'admin.send_type.StatePrice', 'uses' => 'SendTypeController@StatePrice']);
        Route::post('/send_type/StateChange', ['as' => 'admin.send_type.StateChange', 'uses' => 'SendTypeController@StateChange']);
        Route::post('/send_type/CityPrice', ['as' => 'admin.send_type.CityPrice', 'uses' => 'SendTypeController@CityPrice']);
        Route::post('/send_type/DataTable', ['as' => 'admin.send_type.DataTable', 'uses' => 'SendTypeController@DataTable']);

        //Pay Type
        Route::group(['protect_alias' => 'paytype'], function () {
            Route::resource('pay_type', 'PayTypeController', ['as' => 'admin']);
        });
        Route::post('/pay_type/ChangeContent', ['as' => 'admin.pay_type.ChangeContent', 'uses' => 'PayTypeController@ChangeContent']);
        Route::post('/pay_type/ShowState', ['as' => 'admin.pay_type.ShowState', 'uses' => 'PayTypeController@ShowState']);
        Route::post('/pay_type/StatePrice', ['as' => 'admin.pay_type.StatePrice', 'uses' => 'PayTypeController@StatePrice']);
        Route::post('/pay_type/StateChange', ['as' => 'admin.pay_type.StateChange', 'uses' => 'PayTypeController@StateChange']);
        Route::post('/pay_type/CityPrice', ['as' => 'admin.pay_type.CityPrice', 'uses' => 'PayTypeController@CityPrice']);
        Route::post('/pay_type/DataTable', ['as' => 'admin.pay_type.DataTable', 'uses' => 'PayTypeController@DataTable']);

        //Factor
        Route::group(['protect_alias' => 'factor'], function () {
            Route::resource('factor', 'FactorController', ['as' => 'admin']);
        });
        Route::post('/factor/DataTable', ['as' => 'admin.factor.DataTable', 'uses' => 'FactorController@DataTable']);

        //Inventory
        Route::group(['protect_alias' => 'inventory'], function () {
            Route::resource('inventory', 'InventoryController', ['as' => 'admin']);
        });
        Route::post('/inventory/DataTable', ['as' => 'admin.inventory.DataTable', 'uses' => 'InventoryController@DataTable']);

        //CheckOut
        Route::group(['protect_alias' => 'checkout'], function () {
            Rouhttp://localhost/shanilo/products?category=18te::resource('checkout', 'CheckOutController', ['as' => 'admin']);
        });
        Route::post('/checkout/DataTable', ['as' => 'admin.checkout.DataTable', 'uses' => 'CheckOutController@DataTable']);

        //Statistic
        Route::group(['protect_alias' => 'statistic'], function () {
            Route::get('/statistic/index', ['as' => 'admin.statistic.index', 'uses' => 'StatisticController@index']);
            Route::get('/statistic/sales', ['as' => 'admin.statistic.sales', 'uses' => 'StatisticController@sales']);
        });
        Route::post('/statistic/DataTable', ['as' => 'admin.statistic.DataTable', 'uses' => 'StatisticController@DataTable']);

        //Pages
        Route::group(['protect_alias' => 'page'], function () {
            Route::resource('page', 'PageController', ['as' => 'admin']);
        });
        Route::post('/page/DataTable', ['as' => 'admin.page.DataTable', 'uses' => 'PageController@DataTable']);
        Route::post('/page/gallery', ['as' => 'admin.page.gallery', 'uses' => 'PageController@gallery']);
        Route::post('/page/galleryDestroy', ['as' => 'admin.page.galleryDestroy', 'uses' => 'PageController@galleryDestroy']);

        //Page Item
        Route::group(['protect_alias' => 'page'], function () {
            Route::resource('pageItem', 'PageItemController', ['as' => 'admin']);
        });
        Route::post('/pageItem/DataTable', ['as' => 'admin.pageItem.DataTable', 'uses' => 'PageItemController@DataTable']);

        //Country
        Route::group(['protect_alias' => 'country'], function () {
            Route::resource('country', 'CountryController', ['as' => 'admin']);
        });
        Route::post('/country/DataTable', ['as' => 'admin.country.DataTable', 'uses' => 'CountryController@DataTable']);
    });
    ############################################################
    # End Base #
    ############################################################


    ############################################################
    # Advertisement #
    ############################################################
    Route::group(['namespace' => 'Advertisement'], function () {
        //AdPlan
        Route::group(['protect_alias' => 'adplan'], function () {
            Route::resource('adplan', 'AdPlanController', ['as' => 'admin']);
        });
        Route::post('/adplan/DataTable', ['as' => 'admin.adplan.DataTable', 'uses' => 'AdPlanController@DataTable']);
        //AdTime
        Route::group(['protect_alias' => 'adtime'], function () {
            Route::resource('adtime', 'AdTimeController', ['as' => 'admin']);
        });
        Route::post('/adtime/DataTable', ['as' => 'admin.adtime.DataTable', 'uses' => 'AdTimeController@DataTable']);
        //AdSection
        Route::group(['protect_alias' => 'adsection'], function () {
            Route::resource('adsection', 'AdSectionController', ['as' => 'admin']);
        });
        Route::post('/adsection/DataTable', ['as' => 'admin.adsection.DataTable', 'uses' => 'AdSectionController@DataTable']);
        //AdDetail
        Route::group(['protect_alias' => 'addetail'], function () {
            Route::resource('addetail', 'AdDetailController', ['as' => 'admin']);
        });
        Route::post('/addetail/DataTable', ['as' => 'admin.addetail.DataTable', 'uses' => 'AdDetailController@DataTable']);
        //AdRequest
        Route::group(['protect_alias' => 'adrequest'], function () {
            Route::resource('adrequest', 'AdRequestController', ['as' => 'admin']);
        });
        Route::post('/adrequest/DataTable', ['as' => 'admin.adrequest.DataTable', 'uses' => 'AdRequestController@DataTable']);
        //Advertisement
        Route::group(['protect_alias' => 'advertisement'], function () {
            Route::resource('advertisement', 'AdvertisementController', ['as' => 'admin']);
        });
        Route::post('/advertisement/DataTable', ['as' => 'admin.advertisement.DataTable', 'uses' => 'AdvertisementController@DataTable']);
        Route::post('/advertisement/choosePlan', ['as' => 'admin.advertisement.choosePlan', 'uses' => 'AdvertisementController@choosePlan']);
        Route::post('/advertisement/chooseTime', ['as' => 'admin.advertisement.chooseTime', 'uses' => 'AdvertisementController@chooseTime']);
    });
    ############################################################
    # End Advertisement #
    ############################################################

});

Route::group(['prefix' => env('ADMIN_ROUTE'), 'namespace' => 'Admin\Auth'], function () {
    Route::get('/login', ['as' => 'login', 'uses' => 'LoginController@showLoginForm']);
    Route::post('/login', ['as' => 'auth.login', 'uses' => 'LoginController@login']);
    Route::post('/logout', ['as' => 'admin.auth.logout', 'uses' => 'LoginController@logout']);
    Route::get('/login_lang/{lang}', ['as' => 'admin.auth.language', 'uses' => 'LoginController@lang']);
    // Password Reset Routes...
    Route::get('/password/request', ['as' => 'admin.password.request', 'uses' => 'ForgotPasswordController@showLinkRequestForm']);
    Route::post('/password/email', ['as' => 'admin.password.email', 'uses' => 'ForgotPasswordController@sendResetLinkEmail']);
    Route::get('/password/reset/{token}', ['as' => 'password.reset', 'uses' => 'ResetPasswordController@showResetForm']);
    Route::post('/password/reset', ['as' => 'admin.password.reset', 'uses' => 'ResetPasswordController@reset']);
});
