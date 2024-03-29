<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $undecryptedPassword;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $undecryptedPassword)
    {
        $this->user = $user;
        $this->undecryptedPassword = $undecryptedPassword;
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.user_created')->with([
            'user' => $this->user,
            'undecryptedPassword' => $this->undecryptedPassword
        ]);
    }
}