<?php
namespace App\Notifications;

use App\Models\StudentSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StudentSubmissionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $submission;

    public function __construct(StudentSubmission $submission)
    {
        $this->submission = $submission;
    }

    public function via($notifiable)
    {
        return ['mail']; // You can add other channels like 'database' or 'slack' if needed
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Student Submission')
            ->greeting('Hello Admin,')
            ->line('A new student submission has been received.')
            ->line('Name: ' . $this->submission->name)
            ->line('Email: ' . $this->submission->email)
            ->action('View Submission', url('/submissions/' . $this->submission->id))
            ->line('Thank you for using our application!');
    }
}
