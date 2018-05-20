<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewUserWelcome extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;

    public $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;

        // Generate a new reset password token
        $this->token = app('auth.password.broker')->createToken($user);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.users.welcome');
    }
}
