<?php

namespace App\Listeners;

use App\Events\ProductHasOff;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendProductOffNotification
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
     * @param  ProductHasOff  $event
     * @return void
     */
    public function handle(ProductHasOff $event)
    {
        $productDetail=$event->productDetail;
        $data=[];
        $message="را میتوانید با تخفیف %discount%% خریداری نمایید.";
        $message=str_replace('%discount%',$productDetail->discount,$message);
        $productDetail->notifyLists->each(function ($notifyList)use ($productDetail,$message,&$data){
            $data[]=[
                'user_id'=>$notifyList->user_id,
                'message'=>announcementMessage($productDetail,$message)
            ];
        });
        \DB::table('announcements')->insert($data);
    }
}
