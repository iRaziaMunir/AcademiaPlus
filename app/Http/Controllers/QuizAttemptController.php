<?php

namespace App\Http\Controllers;

use App\DTOs\QuizAttemptDTO;
use App\DTOs\AnswerDTO;
use App\Http\Requests\QuizAttemptRequest;
use App\Models\QuizAttempt;
use App\Services\QuizAttemptService;
use Illuminate\Support\Facades\Log;

class QuizAttemptController extends Controller
{
    protected $quizAttemptService;

    public function __construct(QuizAttemptService $quizAttemptService)
    {
        $this->quizAttemptService = $quizAttemptService;
    }

    // Record a quiz attempt
    public function attempt(QuizAttemptRequest $request)
    {
        // Log the incoming request
        Log::info('Quiz attempt request received', $request->all());

        // Convert request to DTO
        $answers = array_map(function ($answer) {
            return new AnswerDTO($answer['question_id'], $answer['selected_option']);
        }, $request->answers);

        $dto = new QuizAttemptDTO(
            $request->assignment_id,
            $request->student_id,
            $answers
        );

        // Delegate the creation to the service
        $attempt = $this->quizAttemptService->createAttempt($dto);

        return response()->json([
            'message' => 'Quiz attempt recorded successfully',
            'attempt' => $attempt,
            'total_score' => $attempt->score
        ], 201);
    }

    // Get all attempts for a specific quiz assignment
    public function index($assignmentId)
    {
        $attempts = QuizAttempt::where('assignment_id', $assignmentId)->with('answers')->get();
        return response()->json($attempts);
    }
}

// namespace App\Http\Controllers;

// use App\Http\Requests\QuizAttemptRequest;
// use App\Models\QuizAttempt;
// use Illuminate\Http\Request;

// class QuizAttemptController extends Controller
// {
//     // Record a quiz attempt
//     public function attempt(QuizAttemptRequest $request)
//     {
//         $attempt = QuizAttempt::create($request->all());

//         return response()->json(['message' => 'Quiz attempt recorded', 'attempt' => $attempt]);
//     }

//     // Get attempts for a specific quiz assignment
//     public function index($assignmentId)
//     {
//         $attempts = QuizAttempt::where('assignment_id', $assignmentId)->get();

//         return response()->json($attempts);
//     }
// }

// namespace App\Http\Controllers;

// use App\Http\Requests\AttemptQuizRequest;
// use App\Http\Requests\QuizAttemptRequest;
// use App\Models\QuizAttempt;
// use App\Models\QuizAttemptAnswer;
// use App\Models\Question;
// use Illuminate\Http\Request;

// class QuizAttemptController extends Controller
// {
//     // Record a quiz attempt
//     public function attempt(QuizAttemptRequest $request)
//     {
//         // Create a new quiz attempt
//         $attempt = QuizAttempt::create([
//             'assignment_id' => $request->assignment_id,
//             'student_id' => $request->student_id,
//             'status' => 'in-progress'  // Initially mark as in-progress
//         ]);

//         // Iterate through each answer in the request
//         $totalScore = 0;
//         foreach ($request->answers as $answer) {
//             // Find the related question
//             $question = Question::findOrFail($answer['question_id']);
            
//             // Check if the selected answer is correct
//             $isCorrect = $answer['selected_option'] === $question->correct_option;
            
//             // Increase the score if correct
//             if ($isCorrect) {
//                 $totalScore += 1;  // You can adjust scoring logic based on your rules
//             }
            
//             // Save the student's answer
//             QuizAttemptAnswer::create([
//                 'attempt_id' => $attempt->id,
//                 'question_id' => $answer['question_id'],
//                 'selected_option' => $answer['selected_option'],
//                 'is_correct' => $isCorrect
//             ]);
//         }

//         // After evaluating all answers, update the status and score
//         $attempt->update([
//             'score' => $totalScore,
//             'status' => 'completed'  // Mark as completed after the quiz is attempted
//         ]);

//         // Return the quiz attempt result
//         return response()->json([
//             'message' => 'Quiz attempt recorded successfully',
//             'attempt' => $attempt,
//             'total_score' => $totalScore
//         ]);
//     }

//     // Get all attempts for a specific quiz assignment
//     public function index($assignmentId)
//     {
//         $attempts = QuizAttempt::where('assignment_id', $assignmentId)->with('answers')->get();
//         return response()->json($attempts);
//     }
// }

