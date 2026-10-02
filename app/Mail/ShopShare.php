<?php

namespace App\Mail;

use App\Models\Specific\Shop;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ShopShare extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Shop
     */
    private $shop;

    /**
     * Create a new message instance.
     *
     * @param Shop $shop
     */
    public function __construct(Shop $shop)
    {
        //
        $this->shop = $shop;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.article')->subject("از طرف دوست شما: ".$this->shop->title)->with([
            'title' => $this->shop->title,
            'link' => $this->shop->path(),
            'image' => $this->shop->takeImage('main','255/100'),
        ]);
    }
}
