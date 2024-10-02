<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Password; // Import Password facade

class SetupPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        if (!$this->user) {
            throw new \Exception('User data is missing');
        }
        // Create a password reset token
        $token = Password::createToken($this->user);
        // Pass the token and user to the view
        // return $this->view('emails.setup_password')->with([
        //     'user' => $this->user,
        //     'link' => url('/password-setup/' . $this->user->id . '?token=' . $token),
        // ]);
        return $this->view('emails.setup_password')->with([
            'name' => $this->user->name,
            'url' => url('/password-setup/' . $this->user->id . '?token=' . $token),
        ]);
    }
}
