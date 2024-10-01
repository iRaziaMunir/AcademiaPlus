<?php

namespace App\Services;

use App\DTOs\QuizAttemptDTO;
use App\Models\QuizAttempt;
use App\Models\QuizAttemptAnswer;
use App\Models\Question;
use Illuminate\Support\Facades\Log;

class QuizAttemptService
{
    public function createAttempt(QuizAttemptDTO $dto)
    {
        try {
            Log::info('Starting quiz attempt creation', ['assignment_id' => $dto->assignmentId, 'student_id' => $dto->studentId]);

            // Create a new quiz attempt
            $attempt = QuizAttempt::create([
                'assignment_id' => $dto->assignmentId,
                'student_id' => $dto->studentId,
                'status' => 'in-progress'
            ]);

            $totalScore = 0;

            foreach ($dto->answers as $answerDTO) {
                // Find the related question
                $question = Question::findOrFail($answerDTO->questionId);
                $isCorrect = $answerDTO->selectedOption === $question->correct_option;

                if ($isCorrect) {
                    $totalScore += 1;
                }

                // Save the student's answer
                QuizAttemptAnswer::create([
                    'attempt_id' => $attempt->id,
                    'question_id' => $answerDTO->questionId,
                    'selected_option' => $answerDTO->selectedOption,
                    'is_correct' => $isCorrect
                ]);
            }

            // Update the attempt with the score and mark it as completed
            $attempt->update([
                'score' => $totalScore,
                'status' => 'completed'
            ]);

            Log::info('Quiz attempt completed', ['attempt_id' => $attempt->id, 'total_score' => $totalScore]);

            return $attempt;
        } catch (\Exception $e) {
            Log::error('Failed to create quiz attempt', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
