<?php
namespace App\Services;

use App\DTOs\StudentSubmissionDTO;
use App\DTOs\PasswordSetupDTO;
use App\Models\StudentSubmission;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use App\Notifications\PasswordSetup;
use App\Notifications\RejectionNotification;
use App\Notifications\StudentSubmissionConfirmation;
use Illuminate\Support\Facades\Hash;

class StudentSubmissionService
{
    public function createSubmission(StudentSubmissionDTO $dto)
    {
        Log::info('Creating student submission', (array)$dto);

        // Store the CV file
        $cvPath = $dto->cvFile->store('cvs');

        // Create a new submission
        $submission = StudentSubmission::create([
            'name' => $dto->name,
            'email' => $dto->email,
            'cv_file' => $cvPath,
            'status' => 'pending',
        ]);

        // Send confirmation email
        Notification::send($submission, new StudentSubmissionConfirmation($submission));

        return $submission;
    }

    public function acceptSubmission(StudentSubmission $submission)
    {
        $submission->update(['status' => 'accepted']);
        $token = Str::random(60);

        $submission->token = $token;
        $submission->save();

        Log::info('Submission accepted with token', ['submission_id' => $submission->id, 'token' => $token]);
        Notification::send($submission, new PasswordSetup($token));
    }

    public function setPassword(PasswordSetupDTO $dto)
    {
        Log::info('Setting password for token', ['token' => $dto->token]);

        // Find the submission using the token
        $submission = StudentSubmission::where('token', $dto->token)->first();
// dd($submission);
        if (!$submission) {
            Log::error('Token not found or invalid', ['token' => $dto->token]);
            return null; // 
        }

        // Create the user
        $user = User::create([
            'name' => $submission->name,
            'email' => $submission->email,
            'password' => Hash::make($dto->password),
        ]);

        // Link the user to the submission
        $submission->update(['student_id' => $user->id]);

        Log::info('Password set and user created', ['user_id' => $user->id]);
        return $user;
    }

    public function resendPasswordSetupEmail(StudentSubmission $submission)
    {
        $token = Str::random(60);
        $submission->token = $token;
        $submission->save();

        Notification::send($submission, new PasswordSetup($token));
        Log::info('Resent password setup email', ['submission_id' => $submission->id, 'token' => $token]);
    }

    public function rejectSubmission(StudentSubmission $submission)
    {
        $submission->update(['status' => 'rejected']);
        Log::info('Submission rejected', ['submission_id' => $submission->id]);

        
        Notification::send($submission, new RejectionNotification($submission));
    }
}
