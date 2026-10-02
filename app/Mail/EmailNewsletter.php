<?php

namespace App\Mail;

use App\Models\Base\Newsletter;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailNewsletter extends Mailable
{
    use Queueable, SerializesModels;

    protected $newsletter;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Newsletter $newsletter)
    {
        $this->newsletter = $newsletter;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.newsletter')->with([
            'newsletterid' => $this->newsletter->hashed,
        ]);
    }
}

