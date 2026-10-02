<?php

namespace App\Mail;


use App\Models\Base\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;


class EmailConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new message instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.confirm')->subject("فعال سازی حساب کاربری (آچار چرخ)")->with([
            'user_confirm' => $this->user->hashed,
        ]);
    }
}

