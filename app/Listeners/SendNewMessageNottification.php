<?php

namespace App\Listeners;

use App\Events\MessageSent;
use App\Models\Specific\Announcement;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewMessageNottification
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
     * @param  MessageSent  $event
     * @return void
     */
    public function handle(MessageSent $event)
    {
        $message='%sender% پیغامی به شما فرستاده است.';
        $sender=$event->getMessage()->sender_id?getUsersFullName($event->getMessage()->sender):'';
        $message=str_replace('%sender%',$sender,$message);
        $parentMessage=$event->getMessage()->parent?:$event->getMessage();
        $route=$event->getMessage()->user_id?route('front.profile.message.show',$parentMessage):route('front.profile.message.tickets');
        $announcementMessage=announcementMessage($event->getMessage()->sender,$message,$route);
        Announcement::create([
            'user_id'=>$event->getMessage()->receiver_id,
            'message'=>$announcementMessage
        ]);
    }
}
