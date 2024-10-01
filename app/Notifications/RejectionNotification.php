<?php

// app/Notifications/RejectionNotification.php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RejectionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Student Submission Rejected')
            ->greeting('Dear Applicant,')
            ->line('We regret to inform you that your student submission has been rejected.')
            ->line('Thank you for your interest.');
    }
}
