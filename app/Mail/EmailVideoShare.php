<?php

namespace App\Mail;

use App\Models\Base\VideoGallery;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class EmailVideoShare extends Mailable
{
    use Queueable, SerializesModels;

    protected $product;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(VideoGallery $video_gallery)
    {
        $this->video_gallery = $video_gallery;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.video')->subject("از طرف دوست شما: ".$this->video_gallery->title)->with([
            'title' => $this->video_gallery->title,
            'link' => route('front.videogallery.show',$this->video_gallery->id),
            'image' => $this->video_gallery->takeImage('video_picture_preview','290/280'),
        ]);
    }
}

