<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;

class SetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;

    public function __construct(User $user)
    {
        $this->user = $user;

        // Generate a temporary signed URL valid for 24 hours
        $this->token = URL::temporarySignedRoute(
            'password.setup', // Named route for setting up the password
            Carbon::now()->addHours(24),
            ['user' => $this->user->id]
        );
    }

    public function build()
    {
        return $this->subject('Set Your Password')
                    ->view('emails.set_password')
                    ->with([
                        'url' => $this->token,
                        'userName' => $this->user->name,
                    ]);
    }
}
