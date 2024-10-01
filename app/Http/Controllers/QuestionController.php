<?php
namespace App\Http\Controllers;

use App\Http\Requests\UpdateQuestionRequest;
use App\Services\QuestionService;
use App\DTOs\QuestionDTO;
use App\Http\Requests\CreateQuestionRequest;
use App\Models\Question;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    protected $questionService;

    public function __construct(QuestionService $questionService)
    {
        $this->questionService = $questionService;
    }

    public function create(CreateQuestionRequest $request)
    {
        Log::info('Incoming request for creating a question', $request->all());

        $dto = new QuestionDTO(
            $request->input('quiz_id'),
            $request->input('question_text'),
            $request->input('options'),
            $request->input('correct_option')
        );

        try {
            $question = $this->questionService->createQuestion($dto);

            return response()->json([
                'message' => 'Question created successfully',
                'question' => $question,
            ], 201); // 201 Created

        } catch (\Exception $e) {
            Log::error('Error creating question', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'An error occurred while creating the question'], 500);
        }
    }


    public function update(UpdateQuestionRequest $request, $id)
    {
        Log::info('Incoming request for updating a question', $request->all());

        // Find the question by ID
        $question = Question::findOrFail($id);

        // Create a DTO
        $dto = new QuestionDTO(
            $request->input('quiz_id'),
            $request->input('question_text'),
            $request->input('options'),
            $request->input('correct_option')
        );

        try {
            $updatedQuestion = $this->questionService->updateQuestion($question, $dto);

            return response()->json([
                'message' => 'Question updated successfully',
                'question' => $updatedQuestion,
            ], 200); // 200 OK

        } catch (\Exception $e) {
            Log::error('Error updating question', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'An error occurred while updating the question'], 500);
        }
    }

    public function delete($id)
    {
        Log::info('Incoming request for deleting a question with ID: ' . $id);

        // Find the question by ID
        $question = Question::findOrFail($id);

        try {
            return $this->questionService->deleteQuestion($question);

        } catch (\Exception $e) {
            Log::error('Error deleting question', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'An error occurred while deleting the question'], 500);
        }
    }
}


// namespace App\Http\Controllers;

// use App\Http\Requests\CreateQuestionRequest;
// use App\Models\Question;
// use App\Models\Quiz;

// class QuestionController extends Controller
// {
//     public function create(CreateQuestionRequest $request)
//     {
//         // Validate and retrieve the input data
//         $validatedData = $request->validated();

//         // Create a new question
//         $question = Question::create([
//             'quiz_id' => $validatedData['quiz_id'],
//             'question_text' => $validatedData['question_text'],
//             'options' => json_encode($validatedData['options']), // Store options as JSON
//             'correct_option' => $validatedData['correct_option'],
//         ]);

//         $question->options = json_decode($question->options);
//         return response()->json([
//             'message' => 'Question created successfully',
//             'question' => $question,
//         ], 201); // 201 Created response
//     }


// }
