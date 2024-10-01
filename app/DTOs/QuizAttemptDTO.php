<?php

namespace App\DTOs;

class QuizAttemptDTO
{
    public int $assignmentId;
    public int $studentId;
    public array $answers; // An array of AnswerDTOs

    public function __construct(int $assignmentId, int $studentId, array $answers)
    {
        $this->assignmentId = $assignmentId;
        $this->studentId = $studentId;
        $this->answers = $answers;
    }
}

class AnswerDTO
{
    public int $questionId;
    public string $selectedOption;

    public function __construct(int $questionId, string $selectedOption)
    {
        $this->questionId = $questionId;
        $this->selectedOption = $selectedOption;
    }
}
