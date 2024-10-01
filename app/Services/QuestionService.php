<?php
namespace App\Services;

use App\Models\Question;
use App\DTOs\QuestionDTO;
use Illuminate\Support\Facades\Log;

class QuestionService
{
  public function createQuestion(QuestionDTO $dto)
  {
      Log::info('Creating a new question in service.', (array)$dto);

      $question = Question::create([
          'quiz_id' => $dto->quizId,
          'question_text' => $dto->questionText,
          'options' => json_encode($dto->options), // Store options as JSON
          'correct_option' => $dto->correctOption,
      ]);

      $question->options = json_decode($question->options); // Decode for display
      return $question;
  }

    public function updateQuestion(Question $question, QuestionDTO $dto)
    {
        Log::info('Updating question in service', (array)$dto);

        $question->update([
            'quiz_id' => $dto->quizId,
            'question_text' => $dto->questionText,
            'options' => json_encode($dto->options), // Store options as JSON
            'correct_option' => $dto->correctOption,
        ]);

        $question->options = json_decode($question->options);
        return $question;
    }

    public function deleteQuestion(Question $question)
    {
        Log::info('Deleting question with ID: ' . $question->id);

        $question->delete();
        return response()->json([
            'message' => 'Question deleted successfully',
        ], 200);
    }
}
