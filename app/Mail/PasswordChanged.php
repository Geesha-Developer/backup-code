<?php

namespace App\Mail;

use App\Models\User;  // Ensure to import the User model
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $newPassword;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param string $newPassword
     * @return void
     */
    public function __construct(User $user, string $newPassword)
    {
        $this->user = $user;
        $this->newPassword = $newPassword;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Your Password Has Been Changed')
                    ->view('emails.password_changed')
                    ->with([
                        'username' => $this->user->email, // Assuming email is the username
                        'newPassword' => $this->newPassword,
                    ]);
    }
}
