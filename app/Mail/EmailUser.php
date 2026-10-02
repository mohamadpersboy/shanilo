<?php

namespace App\Mail;

use App\Models\Specific\ProductDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class EmailUser extends Mailable
{
    use Queueable, SerializesModels;

    protected $productDetail;

    /**
     * Create a new message instance.
     *
     * @param ProductDetail $productDetail
     */
    public function __construct(ProductDetail $productDetail)
    {
        $this->productDetail = $productDetail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.user')->subject("از طرف دوست شما: ".$this->productDetail->product->title)->with([
            'title' => $this->productDetail->product->title,
            'link' => $this->productDetail->path(),
            'image' => $this->productDetail->takeImage('main','350/0'),
        ]);
    }
}

