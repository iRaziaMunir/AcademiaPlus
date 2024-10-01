<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizAssignmentController;
use App\Http\Controllers\QuizAttemptController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;

// Authentication Routes


// JWT Authenticated Routes
// Route::middleware('request.log')->group(function() {

    Route::controller(AuthController::class)->group(function(){
        // Route::post('/login', 'login')->middleware('request.log');
        Route::post('/login', 'login');

        Route::post('/register', 'register');
    });
// });

Route::middleware('jwtAuth')->group(function() {

    Route::controller(AuthController::class)->group(function(){

        Route::get('/logout', 'logout');
        Route::post('/refresh', 'refresh');
        Route::get('/user-profile', 'getUser');
    });

    Route::controller(AdminController::class)->group(function(){

        Route::post('admin/add-user',  'addUser')
            ->middleware('custom.permission:user can add users');

        //view all students submissions based on statuses
        Route::get('admin/view-students',  'index')
            ->middleware('custom.permission:user can view students');
    });
   
    Route::controller(StudentController::class)->group(function(){
        //view all students submissions with out filtering
        Route::get('admin/view-submissions', 'index');
            // ->middleware('custom.permission:user can view students');

        Route::patch('admin/submission/{submission}/accept', 'accept')
            ->middleware('custom.permission:user can accept student submission request');

        Route::patch('admin/submission/{submission}/reject', 'reject')
            ->middleware('custom.permission:user can reject student submission request');
    });
    Route::controller(QuestionController::class)->group(function(){

        // Question Management
        Route::post('/create-questions',  'create')
        ->middleware('custom.permission:user can create quiz');

        // Route to update an existing question
        Route::put('/update-question/{id}',  'update')
        ->middleware('custom.permission:user can update quiz');

        // Route to delete a question
        Route::delete('/delete-question/{id}',  'delete')
        ->middleware('custom.permission:user can delete quiz');
    });
    
    Route::controller(QuizController::class)->group(function(){

        // Quiz Management
        Route::post('/create-quiz',  'create')
        ->middleware('custom.permission:user can create quiz');

        Route::get('/view-quizzes',  'index')
        ->middleware('custom.permission:user can view all quizzes');

        Route::put('/update-quiz/{id}',  'update')
        ->middleware('custom.permission:user can update quiz');

        Route::delete('/delete-quiz/{id}',  'destroy')
        ->middleware('custom.permission:user can delete quiz');

        Route::get('/view-quiz-with-questions/{quizId}',  'getQuizWithQuestions')
        ->middleware('custom.permission:user can view all quizzes');
    });

    Route::controller(QuizAssignmentController::class)->group(function(){
        // Quiz Assignment
        Route::post('/assign-quiz', 'assign')
        ->middleware('custom.permission:user can assign quiz');

        Route::get('/view-quiz/{quizId}', 'assignedQuizzes')
        ->middleware('custom.permission:user can view assigned quizzes');

        Route::get('/view-assigned-quizzes', 'allAssignedQuizzes')
        ->middleware('custom.permission:user can view assigned quizzes');

    });

    Route::controller(QuizAttemptController::class)->group(function(){

        // Quiz Attempt
        Route::post('/attempt-quiz',  'attempt')
        ->middleware('custom.permission:user can attempt assigned quizzes');
        // ->middleware('custom.permission:user can view assigned quizzes');

        Route::get('/view-quiz-attempt/{attemptId}',  'index')
        ->middleware('custom.permission:user can view quizzes results');


        // Additional Route for Getting Attempts for a Specific Quiz Assignment
        // Route::get('/{assignmentId}/attempts',  'index')
        // ->middleware('custom.permission:user can view quizzes results');
    });
        
    Route::get('/view-video/{attemptId}', [VideoController::class, 'index'])
    ->middleware('custom.permission:user can create quiz');

});

//public routes
Route::controller(StudentController::class)->group(function(){

    // Student Submission Route
    Route::post('/submission', 'store');
    // ->middleware('custom.permission:user can attempt assigned quizzes');

    // Set Password Routes
    Route::post('/set-password/{token}', 'setPassword');

});

Route::post('/set-password/{token}', [AdminController::class, 'setPassword']);
Route::post('/set-student-password/{token}', [StudentController::class, 'setStudentPassword']);
Route::post('/reset-student-password', [StudentController::class, 'resendPasswordSetupEmail']);


Route::post('/store-video', [VideoController::class, 'store']);

// });
// ->middleware('custom.permission:user can create quiz');


// use App\Http\Controllers\AdminController;
// use App\Http\Controllers\AuthController;
// use App\Http\Controllers\QuestionController;
// use App\Http\Controllers\QuizAssignmentController;
// use App\Http\Controllers\QuizAttemptController;
// use App\Http\Controllers\QuizController;
// use App\Http\Controllers\StudentController;
// use App\Http\Controllers\VideoController;
// use Illuminate\Support\Facades\Route;

// Route::controller(AuthController::class)->group(function(){
//     Route::post('/login',  'login');
//     Route::post('/register', 'register');
// });

// Route::middleware('jwtAuth')->group(function(){
    
//     Route::controller(AuthController::class)->group(function(){
//         Route::get('/logout',  'logout');
//         Route::post('/refresh',  'refresh');
//         Route::get('/user-profile',  'getUser');
//     });

//     Route::post('/admin/add-user', [AdminController::class, 'addUser']);

//     // Route to get all submissions for admin
//     Route::get('/admin/view-submissions', [StudentController::class, 'index']);

//     // Route to accept a submission
//     Route::patch('/admin/submission/{submission}/accept', [StudentController::class, 'accept']);

//     // Route to reject a submission
//     Route::patch('/admin/submission/{submission}/reject', [StudentController::class, 'reject']);

//     Route::post('/create-questions', [QuestionController::class, 'create']);

//     Route::post('/create-quiz', [QuizController::class, 'create']);
//     Route::get('/view-quizzes', [QuizController::class, 'index']);
//     Route::put('/update-quiz/{id}', [QuizController::class, 'update']);
//     Route::delete('/delete-quiz/{id}', [QuizController::class, 'destroy']);

//     Route::get('/view-quiz-with-questions/{quizId}', [QuizController::class, 'getQuizWithQuestions']);

//     Route::post('/assign-quiz', [QuizAssignmentController::class, 'assign']);
//     Route::get('/view-quiz/{quizId}', [QuizAssignmentController::class, 'index']);

//     Route::post('/attempt-quiz', [QuizAttemptController::class, 'attempt']);
//     Route::get('/view-quiz-assignment/{assignmentId}', [QuizAttemptController::class, 'index']);

//     Route::post('/store-video', [VideoController::class, 'store']);
//     Route::get('/view-quiz-attempt/{attemptId}', [VideoController::class, 'index']);
//     // Route to set password after approval

//     // Get attempts for a specific quiz assignment
//     Route::get('/{assignmentId}/attempts', [QuizAttemptController::class, 'index']);
//     Route::get('/admin/students', [AdminController::class, 'index'])->name('admin.students');
// });

// Route::post('/submission', [StudentController::class, 'store']);
// Route::post('/set-password/{token}', [StudentController::class, 'setPassword']);
// Route::post('/set-password/{token}', [AdminController::class, 'setPassword']);