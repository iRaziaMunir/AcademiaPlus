<?php

namespace App\Services;

use App\DTOs\QuizDTO;
use App\Models\Quiz;
use Illuminate\Support\Facades\Log;

class QuizService
{
    public function createQuiz(QuizDTO $dto)
    {
        Log::info('Creating quiz in service', (array)$dto);
        
        $quiz = Quiz::create([
            'title' => $dto->title,
            'description' => $dto->description,
            'scheduled_at' => $dto->scheduled_at,
            'expires_at' => $dto->expires_at,
        ]);

        return $quiz;
    }

    public function getQuizzes()
    {
        Log::info('Fetching all quizzes with questions');
        
        return Quiz::with('questions')->get();
    }

    public function getQuizWithQuestions(int $quizId)
    {
        Log::info('Fetching quiz with questions for ID: ' . $quizId);

        return Quiz::with('questions')->find($quizId);
    }

    public function updateQuiz(QuizDTO $dto, $id)
    {
        Log::info('Updating quiz for ID: ' . $id, (array)$dto);
        
        $quiz = Quiz::find($id);

        if ($quiz) {
            $quiz->update([
                'title' => $dto->title,
                'description' => $dto->description,
                'scheduled_at' => $dto->scheduled_at,
                'expires_at' => $dto->expires_at,
            ]);
        }

        return $quiz;
    }

    public function deleteQuiz($id)
    {
        Log::info('Deleting quiz with ID: ' . $id);
        
        $quiz = Quiz::find($id);

        if ($quiz) {
            $quiz->delete();
        }

        return $quiz;
    }
}
