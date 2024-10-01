<?php
namespace App\DTOs;

class QuestionDTO
{
    public int $quizId;
    public string $questionText;
    public array $options;
    public string $correctOption;

    public function __construct(int $quizId, string $questionText, array $options, string $correctOption)
    {
        $this->quizId = $quizId;
        $this->questionText = $questionText;
        $this->options = $options;
        $this->correctOption = $correctOption;
    }
}
