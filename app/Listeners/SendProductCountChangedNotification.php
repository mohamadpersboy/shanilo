<?php

namespace App\Listeners;

use App\Events\ProductCountChanged;
use App\Models\Base\Announcement;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendProductCountChangedNotification
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
     * @param  ProductCountChanged  $event
     * @return void
     */
    public function handle(ProductCountChanged $event)
    {
        $productDetail=$event->productDetail;
        $data=[];
        $productDetail->notifyLists->each(function ($nofityList)use ($productDetail,&$data){
            $data[]=[
                'user_id'=>$nofityList->user_id,
                'message'=>announcementMessage($productDetail,'موجود و قابل خرید می باشد.')
            ];
        });
        \DB::table('announcements')->insert($data);
    }
}
