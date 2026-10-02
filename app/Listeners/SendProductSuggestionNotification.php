<?php

namespace App\Listeners;

use App\Events\UserSuggestedAProduct;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendProductSuggestionNotification
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
     * @param  UserSuggestedAProduct  $event
     * @return void
     */
    public function handle(UserSuggestedAProduct $event)
    {
        $text="توسط کاربر %user% به شما ارسال شده است.";
        $text=str_replace('%user%',"<a href='".auth()->user()->path()."'><b>".getUsersFullName(auth()->user())."</b></a>",$text);
        $message=announcementMessage($event->getProductDetail(),$text);
        $data=[];
        foreach ($event->getUsers() as $user){
            if($user->id==auth()->id())
                continue;
            $data[]=[
                'user_id'=>$user->id,
                'message'=>$message
            ];
        }
        \DB::table('announcements')->insert($data);
    }
}
