<?php

Route::namespace('Front')->group(function () {
    Route::post('short_link', 'ShortLinkController@getShortLink')->name('front.short.link');
});


Route::namespace('Front\Specific\Profile')->prefix('profile')->group(function () {
    Route::get('credit_log', 'WalletController@creditLog')->name('creditlog');
});
