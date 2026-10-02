<?php

namespace App\Mail;

use App\News;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class EmailNewsShare extends Mailable
{
    use Queueable, SerializesModels;

    protected $product;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(News $news)
    {
        $this->news = $news;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.news')->subject("از طرف دوست شما: ".$this->news->title)->with([
            'title' => $this->news->title,
            'link' => route('front.news.show',[$this->news->id,removeSpecialChar($this->news->title)]),
            'image' => $this->news->takeImage('main','248/109'),
        ]);
    }
}

