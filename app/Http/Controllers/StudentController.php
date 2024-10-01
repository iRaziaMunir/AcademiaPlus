<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStudentRequest;
use App\Http\Requests\PasswordSetupRequest;
use Illuminate\Support\Facades\Log;
use App\Models\StudentSubmission;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Notifications\PasswordSetup;
use App\Notifications\RejectionNotification;
use App\Notifications\StudentSubmissionConfirmation;
use Illuminate\Support\Facades\Notification;

class StudentController extends Controller
{
    // Handle form submission via API
    public function store(CreateStudentRequest $request)
    {
        // $request->validate([
        //     'email' => 'required|email|unique:student_submissions',
        //     'cv_file' => 'required|file|mimes:doc,docx,pdf,csv|max:2048',
        // ]);
        Log::info($request->all()); // Log all incoming request data
        // Store the CV file
        $cvPath = $request->file('cv_file')->store('cvs');

        // Create a new submission
        $submission = StudentSubmission::create([
            'name' => $request->name,
            'email' => $request->email,
            'cv_file' => $cvPath,
            'status' => 'pending',
        ]);
        Log::info('Store method called');
        // Send confirmation email
        Notification::send($submission, new StudentSubmissionConfirmation($submission));

        return response()->json(['success' => true, 'message' => 'Your submission has been received!'], 201);
    }

    // Show all submissions for admin (API)
    public function index()
    {
        $submissions = StudentSubmission::all();
        
        if ($submissions->isEmpty()) {

            return ['success' => false, 'message' => 'No submissions found'];
        }
        return response()->json($submissions);
    }

    // Accept a submission (API)
    public function accept(StudentSubmission $submission)
    {
        // Update submission status
        $submission->update(['status' => 'accepted']);

        // Send password setup email to the student
        $token = Str::random(60); // Generate a token for password setup
        Log::info('Generated Token: ' . $token);

        // Save the token in the student submission table
        $submission->token = $token;
        $submission->save();

        // Check if the token is saved in the database
        Log::info('Token saved in submission: ' . $submission->token);
        Notification::send($submission, new PasswordSetup($token));

        return response()->json(['success' => true, 'message' => 'Submission accepted! A password setup email has been sent.']);
    }

    // Reject a submission (API)
    public function reject(StudentSubmission $submission)
    {
        $submission->update(['status' => 'rejected']);
        Log::info('Submission is rejected');
        Notification::send($submission, new RejectionNotification);
        return response()->json(['success' => true, 'message' => 'Submission rejected! A rejection email has been sent.']);
    }
    
    public function setStudentPassword(PasswordSetupRequest $request, $token)
    {
        // Log the incoming token and request for debugging
        Log::info('Incoming token:', ['token' => $token]);
        Log::info('Incoming request:', ['request' => $request->all()]);

        // Find the submission using the token
        $submission = StudentSubmission::where('token', $token)->first();
        
        // Log if the token is not found
        if (!$submission) {
            Log::error('Token not found or invalid', ['token' => $token]);
            return response()->json([
                'success' => false,
                'message' => 'Invalid token.',
            ], 404);
        }

        // Check if a user with the provided email already exists
        $existingUser = User::where('email', $submission->email)->first();
        if ($existingUser) {
            Log::warning('User with this email already exists', ['email' => $submission->email]);
            return response()->json([
                'success' => false,
                'message' => 'A user with this email already exists.',
            ], 400); // Bad Request
        }

        // Create the user in the 'users' table
        $user = User::create([
            'name' => $submission->name,
            'email' => $submission->email,
            'password' => Hash::make($request->password),
            'student_id' => $submission->id
        ]);

        // Assign the 'student' role to the user
        $user->assignRole('student');

        // Update the submission to link to the newly created user
        $submission->update(['student_id' => $user->id]);

        // Log success
        Log::info('Password set and user created', ['user_id' => $user->id]);

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'Password has been set and the user has been created!',
        ]);
    }

    public function resendPasswordSetupEmail(StudentSubmission $submission)
{
    // Generate a new token
    $token = Str::random(60);

    // Update the submission with the new token
    $submission->token = $token;
    $submission->save();

    // Send the notification email
    Notification::send($submission, new PasswordSetup($token));

    // Log token generation and email sending
    Log::info('Resent password setup email', [
        'submission_id' => $submission->id, 
        'token' => $token
    ]);
}

    
}

// namespace App\Http\Controllers;

// use App\Http\Requests\CreateStudentRequest;
// use App\Http\Requests\PasswordSetupRequest;
// use App\DTOs\StudentSubmissionDTO;
// use App\DTOs\PasswordSetupDTO;
// use App\Models\StudentSubmission;
// use App\Services\StudentSubmissionService;
// use Illuminate\Support\Facades\Log;

// class StudentController extends Controller
// {
//     protected StudentSubmissionService $studentSubmissionService;

//     public function __construct(StudentSubmissionService $studentSubmissionService)
//     {
//         $this->studentSubmissionService = $studentSubmissionService;
//     }

//     public function store(CreateStudentRequest $request)
//     {
//         Log::info('Incoming request for student submission', $request->all());
    
//         // Retrieve the file and ensure it is an instance of UploadedFile
//         $cvFile = $request->file('cv_file');
    
//         if (!$cvFile instanceof \Illuminate\Http\UploadedFile) {
//             return response()->json(['success' => false, 'message' => 'Invalid file upload.'], 400);
//         }
    
//         // Create DTO with the UploadedFile object
//         $dto = new StudentSubmissionDTO($request->name, $request->email, $cvFile);
    
//         // Create submission
//         $this->studentSubmissionService->createSubmission($dto);
    
//         return response()->json(['success' => true, 'message' => 'Your submission has been received!'], 201);
//     }

//     // public function index()
//     // {
//     //     $submissions = StudentSubmission::all();
//     //     if ($submissions->isEmpty()) {
//     //         return ['success' => false, 'message' => 'No submissions found'];
//     //     }
//     //     return response()->json($submissions);
//     // }

//     public function accept(StudentSubmission $submission)
//     {
//         $this->studentSubmissionService->acceptSubmission($submission);

//         return response()->json(['success' => true, 'message' => 'Submission accepted! A password setup email has been sent.']);
//     }

//     public function reject(StudentSubmission $submission)
//     {
//         $this->studentSubmissionService->rejectSubmission($submission);

//         return response()->json(['success' => true, 'message' => 'Submission rejected! A rejection email has been sent.']);
//     }

//     public function setPassword(PasswordSetupRequest $request, $token)
//     {
//         Log::info('Setting password with token: ' . $token);
        
//         $dto = new PasswordSetupDTO($token, $request->password);
// // dd($dto);
//         if ($this->studentSubmissionService->setPassword($dto)) {
//             return response()->json(['success' => true, 'message' => 'Password has been set and the user has been created!']);
//         }

//         return response()->json(['success' => false, 'message' => 'An error occurred while setting the password.'], 400);
//     }
// }

