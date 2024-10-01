<?php

namespace App\Services;

use App\DTOs\QuizAssignmentDTO;
use App\Models\QuizAssignment;
use Illuminate\Support\Facades\Log;

class QuizAssignmentService
{
    public function assignQuiz(QuizAssignmentDTO $dto)
    {
        Log::info('Assigning quiz to student', (array) $dto);

        return QuizAssignment::create([
            'quiz_id' => $dto->quizId,
            'student_id' => $dto->studentId,
            'assigned_at'=> $dto->assignedAt ,
            'due_at'=> $dto->dueAt ,
            'status'=> $dto->status 
        ]);
    }
}
