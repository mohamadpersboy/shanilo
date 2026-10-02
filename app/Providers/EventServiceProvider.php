<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\ProductCountChanged' => [
            'App\Listeners\SendProductCountChangedNotification',
        ],
        'App\Events\ProductHasOff' => [
            'App\Listeners\SendProductOffNotification',
        ],
        'App\Events\ProductAdded' => [
            'App\Listeners\SendProductAddedNotification',
        ],
        'App\Events\UserSuggestedAProduct' => [
            'App\Listeners\SendProductSuggestionNotification',
        ],
        'App\Events\MessageSent' => [
            'App\Listeners\SendNewMessageNottification',
        ],
        'App\Events\OrderStatusChanged' => [
            'App\Listeners\SendOrderStatusNotification',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
