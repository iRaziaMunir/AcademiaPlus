<?php

namespace App\Http\Controllers;

use App\DTOs\QuizAssignmentDTO;
use App\Http\Requests\AssignQuizRequest;
use App\Models\QuizAssignment;
use App\Services\QuizAssignmentService;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class QuizAssignmentController extends Controller
{
    protected $quizAssignmentService;

    public function __construct(QuizAssignmentService $quizAssignmentService)
    {
        $this->quizAssignmentService = $quizAssignmentService;
    }

    public function assign(AssignQuizRequest $request)
    {
        Log::info('Incoming request for assigning a quiz', $request->all());

        $assignedAt = $request->assigned_at ? Carbon::parse($request->assigned_at) : null;
        $dueAt = $request->due_at ? Carbon::parse($request->due_at) : null;

        // Create DTO with request data
        $dto = new QuizAssignmentDTO(
            $request->quiz_id,
            $request->student_id,
            $assignedAt, 
            $dueAt,
            $request->status ?? null
        );

        $assignment = $this->quizAssignmentService->assignQuiz($dto);

        return response()->json([
            'message' => 'Quiz assigned successfully',
            'assignment' => $assignment,
        ], 201);
    }

     // Get assignments for a quiz
    public function assignedQuizzes($quizId)
    {
        Log::info('Fetching assignments for quiz ID: ' . $quizId);

        $assignments = QuizAssignment::where('quiz_id', $quizId)->get();

        return response()->json($assignments);
    }

    public function allAssignedQuizzes()
    {
        Log::info('Fetching assignments for quiz ID: ');

        $assignments = QuizAssignment::where('status', 'assigned')->get();

        return response()->json($assignments);
    }

}



// namespace App\Http\Controllers;

// use App\Http\Requests\AssignQuizRequest;
// use App\Models\QuizAssignment;
// use Illuminate\Http\Request;

// class QuizAssignmentController extends Controller
// {
//     // Assign a quiz to a student
//     public function assign(AssignQuizRequest $request)
//     {
//         $assignment = QuizAssignment::create($request->all());

//         return response()->json(['message' => 'Quiz assigned successfully', 'assignment' => $assignment]);
//     }

//     // Get assignments for a quiz
//     public function index($quizId)
//     {
//         $assignments = QuizAssignment::where('quiz_id', $quizId)->get();

//         return response()->json($assignments);
//     }
// }

