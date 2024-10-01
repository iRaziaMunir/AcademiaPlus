<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAttemptAnswer extends Model
{
    protected $fillable = ['attempt_id', 'question_id', 'selected_option', 'is_correct'];

    protected $hidden = ['created_at', 'updated_at'];
    public function quizAttempt()
    {
        return $this->belongsTo(QuizAttempt::class, 'attempt_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
