<?php

namespace App\DTOs;

class QuizDTO
{
    public string $title;
    public ?string $description;
    public ?string $scheduled_at;
    public ?string $expires_at;

    public function __construct(string $title, ?string $description, ?string $scheduled_at, ?string $expires_at)
    {
        $this->title = $title;
        $this->description = $description;
        $this->scheduled_at = $scheduled_at;
        $this->expires_at = $expires_at;
    }
}
