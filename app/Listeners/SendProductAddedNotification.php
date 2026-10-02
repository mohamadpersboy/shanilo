<?php

namespace App\Listeners;

use App\Events\ProductAdded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendProductAddedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ProductAdded  $event
     * @return void
     */
    public function handle(ProductAdded $event)
    {
        $productDetail=$event->product->details()->index()->first();
        $shop=$event->product->shop;
        $data=[];
        $shop->notifyLists->each(function ($nofityList)use ($shop, $productDetail,&$data){
            $messageText="توسط فروشگاه %shop% اضافه شد.";
            $messageText=str_replace("%shop%",$shop->title,$messageText);
            $data[]=[
                'user_id'=>$nofityList->user_id,
                'message'=>announcementMessage($productDetail,$messageText)
            ];
        });
        \DB::table('announcements')->insert($data);
    }
}
