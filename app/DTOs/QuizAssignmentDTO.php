<?php

namespace App\DTOs;
use DateTimeInterface ;
class QuizAssignmentDTO
{
    public int $quizId;
    public int $studentId;
    public ?DateTimeInterface  $assignedAt;
    public ?DateTimeInterface  $dueAt;
    public ?string $status;

    public function __construct(int $quizId, int $studentId, ?DateTimeInterface  $assignedAt, ?DateTimeInterface  $dueAt, ?string $status)
    {
        $this->quizId = $quizId;
        $this->studentId = $studentId;
        $this->assignedAt = $assignedAt;
        $this->dueAt = $dueAt;
        $this->status = $status;
    }
}
