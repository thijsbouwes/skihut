<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserEventInvoice extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $events;
    public $activate_account;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $events)
    {
        $this->user = $user;
        $this->events = $events;

        if ($user->last_login === null) {
            // Generate a new reset password token
            $token = app('auth.password.broker')->createToken($user);
            $this->activate_account = url(config('app.url').route('password.reset', ['token' => $token, 'email' => $user->email], false));
        } else {
            $this->activate_account = false;
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(sprintf('%s invoice 💲', $this->user->name))
            ->markdown('emails.users.invoice');
    }
}
