<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use App\Services\QuizService;
use App\DTOs\QuizDTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuizController extends Controller
{
    protected $quizService;

    public function __construct(QuizService $quizService)
    {
        $this->quizService = $quizService;
    }

    // Create a quiz
    public function create(CreateQuizRequest $request)
    {
        Log::info('Incoming request for creating a quiz', $request->all());

        $dto = new QuizDTO(
            $request->title,
            $request->description,
            $request->scheduled_at,
            $request->expires_at,
        );

        $quiz = $this->quizService->createQuiz($dto);

        return response()->json([
            'message' => 'Quiz created successfully',
            'quiz' => $quiz
        ], 201);
    }

    // Get all quizzes with their questions
    public function index()
    {
        Log::info('Incoming request to fetch all quizzes');

        $quizzes = $this->quizService->getQuizzes();

        return response()->json($quizzes, 200);
    }

    // Get a specific quiz with its questions
    public function getQuizWithQuestions($quizId)
    {
        Log::info('Incoming request to fetch quiz with ID: ' . $quizId);

        $quiz = $this->quizService->getQuizWithQuestions($quizId);

        if (!$quiz) {
            Log::error('Quiz not found with ID: ' . $quizId);
            return response()->json([
                'message' => 'No quiz found with ID ' . $quizId
            ], 404);
        }

        return response()->json($quiz, 200);
    }

    // Update a quiz
    public function update(UpdateQuizRequest $request, $id)
    {
        Log::info('Incoming request to update quiz with ID: ' . $id);

        $dto = new QuizDTO(
            $request->title,
            $request->description,
            $request->scheduled_at,
            $request->expires_at,
        );

        $quiz = $this->quizService->updateQuiz($dto, $id);

        if (!$quiz) {
            Log::error('Quiz not found with ID: ' . $id);
            return response()->json([
                'message' => 'No quiz found with ID ' . $id
            ], 404);
        }

        return response()->json([
            'message' => 'Quiz updated successfully',
            'quiz' => $quiz
        ], 200);
    }

    // Delete a quiz
    public function destroy($id)
    {
        Log::info('Incoming request to delete quiz with ID: ' . $id);

        $quiz = $this->quizService->deleteQuiz($id);

        if (!$quiz) {
            Log::error('Quiz not found with ID: ' . $id);
            return response()->json([
                'message' => 'No quiz found with ID ' . $id
            ], 404);
        }

        return response()->json([
            'message' => 'Quiz deleted successfully'
        ], 200);
    }
}


// namespace App\Http\Controllers;

// use App\Http\Requests\CreateQuizRequest;
// use App\Http\Requests\DeleteQuizRequest;
// use App\Http\Requests\GetQuizRequest;
// use App\Models\Quiz;
// use Illuminate\Http\Request;

// class QuizController extends Controller
// {
//     // Create a quiz
//     public function create(CreateQuizRequest $request)
//     {
//         $quiz = Quiz::create($request->all());
//         // dd($quiz);
//         return response()->json(['message' => 'Quiz created successfully', 'quiz' => $quiz]);
//     }

//     // Get all quizzes
//     public function index()
//     {
//         $quizzes = Quiz::with('questions')->get();
//         return response()->json($quizzes);
//     }

//     public function getQuizWithQuestions($quizId)
//     {
//         try 
//         {
//             // This will throw a ModelNotFoundException if no quiz is found
//             $quiz = Quiz::with('questions')->findOrFail($quizId);

//             return response()->json($quiz, 200);
//         } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
//             // Return a custom JSON response if the quiz is not found
//             return response()->json([
//                 'message' => 'There is no quiz with ID. '.$quizId,
//             ], 404);
//         }
//     }

//     // Update a quiz
//     public function update(Request $request, $id)
//     {
//         $quiz = Quiz::findOrFail($id);
//         $quiz->update($request->all());

//         return response()->json(['message' => 'Quiz updated successfully', 'quiz' => $quiz]);
//     }

//     // Delete a quiz
//     public function destroy($id)
//     {
//         try 
//         {
//             $quiz = Quiz::findOrFail($id);
//              $quiz->delete();
//              return response()->json(['message' => 'Quiz deleted successfully']);

//         } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
//             // Return a custom JSON response if the quiz is not found
//             return response()->json([
//                 'message' => 'There is no quiz with ID. '.$id,
//             ], 404);
//         }
//     }
// }
