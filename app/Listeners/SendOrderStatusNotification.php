<?php

namespace App\Listeners;

use App\Events\OrderStatusChanged;
use App\Models\Specific\Announcement;
use App\Models\Specific\Order;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Smsir;
class SendOrderStatusNotification
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
     * @param  OrderStatusChanged $event
     * @return void
     */
    public function handle(OrderStatusChanged $event)
    {
        $order = $event->getOrder()->fresh();
        if($order->status==0 && $order->hasAddedWalletTransaction()){
            $order->disconfirm();
        }
        $this->sendMessageToCustomer($order);
        $this->sendMessageToSeller($order);
    }

    // protected function sendMessageToCustomer(Order $order)
    // {
    //     $messages = [
    //         0 => "سفارش شما از فروشگاه %shop% با شماره %id% و به مبلغ %price% کنسل شد.",
    //         1 => "سفارش شما از فروشگاه %shop% با شماره %id% و به مبلغ %price% با موفقیت ثبت شد.",
    //         2 => "سفارش شما از فروشگاه %shop% با شماره %id% و به مبلغ %price% از طرف فروشگاه تایید شد.",
    //         3 => "",
    //         4 => "سفارش شما از فروشگاه %shop% با شماره %id% و به مبلغ %price% ارسال شد.",
    //         5 => "",
    //         6 => "سفارش شما از فروشگاه %shop% با شماره %id% و به مبلغ %price% کنسل و مبلغ سفارش به موجودی شما اضافه شد.",
    //     ];
    //     $message = $order->status == 0 && $order->hasAddedWalletTransaction() ? $messages[6] : $messages[$order->status];
    //     if ($message) {
    //         $message = $this->replaceMessage($order, $message);
    //         $announcementMessage = announcementMessage($order->shop, $message, route('front.profile.order.show', $order));
    //         Announcement::create([
    //             'user_id' => $order->user_id,
    //             'message' => $announcementMessage
    //         ]);
    //         \Smsir::sendToCustomerClub([$message], [$order->user->mobile]);
    //     }
    // }
    
        protected function sendMessageToCustomer(Order $order)
    {
                $messages = [
            0 => "سفارش شما از فروشگاه %shop% با شماره %id% و به مبلغ %price% کنسل شد.",
            1 => "سفارش شما از فروشگاه %shop% با شماره %id% و به مبلغ %price% با موفقیت ثبت شد.",
            2 => "سفارش شما از فروشگاه %shop% با شماره %id% و به مبلغ %price% از طرف فروشگاه تایید شد.",
            3 => "",
            4 => "سفارش شما از فروشگاه %shop% با شماره %id% و به مبلغ %price% ارسال شد.",
            5 => "",
            6 => "سفارش شما از فروشگاه %shop% با شماره %id% و به مبلغ %price% کنسل و مبلغ سفارش به موجودی شما اضافه شد.",
        ];
        $messages_template = [
            0 => array('data'=>array('data1'=>$order->shop->title,'data2'=>$order->id,'data3'=>showPrice($order->total)),'id'=>31357),
            1 => array('data'=>array('data1'=>$order->shop->title,'data2'=>$order->id,'data3'=>showPrice($order->total)),'id'=>31355),
            2 => array('data'=>array('data1'=>$order->shop->title,'data2'=>$order->id,'data3'=>show_Price($order->total)),'id'=>31281),
            3 => "",
            4 => array('data'=>array('data1'=>$order->shop->title,'data2'=>$order->id,'data3'=>show_Price($order->total)),'id'=>31282),
            5 => "",
            6 => array('data'=>array('data1'=>$order->shop->title,'data2'=>$order->id,'data3'=>showPrice($order->total)),'id'=>31340),
        ];
        $message = $order->status == 0 && $order->hasAddedWalletTransaction() ? $messages[6] : $messages[$order->status];
        $template = $order->status == 0 && $order->hasAddedWalletTransaction() ? $messages_template[6] : $messages_template[$order->status];
        if ($message) {
            $message = $this->replaceMessage($order, $message);
            $announcementMessage = announcementMessage($order->shop, $message, route('front.profile.order.show', $order));
            Announcement::create([
                'user_id' => $order->user_id,
                'message' => $announcementMessage
            ]);
            Smsir::ultraFastSend($template['data'],$template['id'],$order->user->mobile);
        }
    }

    // protected function sendMessageToSeller(Order $order)
    // {
    //     $messages = [
    //         0 => "سفارش با شماره %id% از فروشگاه %shop% به مبلغ %price% کنسل شد.",
    //         1 => "شما سفارش جدیدی از فروشگاه %shop% با شماره %id% و به مبلغ %price% دارید.",
    //         2 => "",
    //         3 => "",
    //         4 => "",
    //         5 => "دریافت سفارش با شماره %id% از فروشگاه %shop% به مبلغ %price% توسط کاربر تایید شد. ",
    //         6 => "سفارش با شماره %id% از فروشگاه %shop% به مبلغ %price% کنسل و مبلغ سفارش به موجودی مشتری اضافه گشت.",
    //     ];
    //     $message = $order->status == 0 && $order->hasAddedWalletTransaction() ? $messages[6] : $messages[$order->status];
    //     if ($message) {
    //         $message = $this->replaceMessage($order, $message);
    //         $announcementMessage = announcementMessage($order->shop, $message, route('front.profile.order.show', $order));
    //         Announcement::create([
    //             'user_id' => $order->shop->user_id,
    //             'message' => $announcementMessage
    //         ]);
    //         //  \Smsir::sendToCustomerClub([$message],[$order->shop->user->mobile]);
    //     }
    // }
    
        protected function sendMessageToSeller(Order $order)
    {
        
                $messages = [
            0 => "سفارش با شماره %id% از فروشگاه %shop% به مبلغ %price% کنسل شد.",
            1 => "شما سفارش جدیدی از فروشگاه %shop% با شماره %id% و به مبلغ %price% دارید.",
            2 => "",
            3 => "",
            4 => "",
            5 => "دریافت سفارش با شماره %id% از فروشگاه %shop% به مبلغ %price% توسط کاربر تایید شد. ",
            6 => "سفارش با شماره %id% از فروشگاه %shop% به مبلغ %price% کنسل و مبلغ سفارش به موجودی مشتری اضافه گشت.",
        ];
        $messages_template = [
            0 => array('data'=>array('data1'=>$order->shop->title,'data2'=>$order->id,'data3'=>showPrice($order->total)),'id'=>31357),
            1 => array('data'=>array('data1'=>$order->shop->title,'data2'=>$order->id,'data3'=>show_Price($order->total)),'id'=>31280),
            2 => "",
            3 => "",
            4 => "",
            5 => array('data'=>array('data1'=>$order->shop->title,'data2'=>$order->id,'data3'=>show_Price($order->total)),'id'=>31284),
            6 => array('data'=>array('data1'=>$order->shop->title,'data2'=>$order->id,'data3'=>show_Price($order->total)),'id'=>31283),
        ];
        $message = $order->status == 0 && $order->hasAddedWalletTransaction() ? $messages[6] : $messages[$order->status];
        $template = $order->status == 0 && $order->hasAddedWalletTransaction() ? $messages_template[6] : $messages_template[$order->status];
        if ($message) {
            $message = $this->replaceMessage($order, $message);
            $announcementMessage = announcementMessage($order->shop, $message, route('front.profile.order.show', $order));
            Announcement::create([
                'user_id' => $order->shop->user_id,
                'message' => $announcementMessage
            ]);
            Smsir::ultraFastSend($template['data'],$template['id'],$order->shop->user->mobile);
        }
    }

    /**
     * @param Order $order
     * @param $message
     * @return mixed
     */
    protected function replaceMessage(Order $order, $message)
    {
        $message = str_replace(['%shop%', '%id%', '%price%'], [$order->shop->title, $order->id, showPrice($order->total)], $message);
        return $message;
    }
}
