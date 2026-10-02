<?php

namespace App\Mail;

use App\Message;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class EmailFromAdmin extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $message;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user,Message $message)
    {
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.from_admin')->subject("از طرف مدیر سایت ".__('content.site_name'))->with([
            'name' => $this->user->name,
            'title' => $this->message->title,
            'message' => $this->message->message,
        ]);
    }
}

