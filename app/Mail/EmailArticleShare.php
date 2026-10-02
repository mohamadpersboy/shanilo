<?php

namespace App\Mail;

use App\Article;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class EmailArticleShare extends Mailable
{
    use Queueable, SerializesModels;

    protected $product;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.article')->subject("از طرف دوست شما: ".$this->article->title)->with([
            'title' => $this->article->title,
            'link' => route('front.article.show',[$this->article->id,removeSpecialChar($this->article->title)]),
            'image' => $this->article->takeImage('main','248/109'),
        ]);
    }
}

