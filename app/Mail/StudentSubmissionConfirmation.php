<?php

namespace App\Mail;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class StudentSubmissionConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $student;

    public function __construct(Student $student)
    {
        $this->student = $student;
    }

    public function build()
    {
        return $this->markdown('emails.student-confirmation')
                    ->subject('Student Submission Confirmation')
                    ->with([
                        'studentName' => $this->student->name,
                    ]);
    }
}
