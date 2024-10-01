<?php

// app/Models/Question.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'question_text',
        'options',
        'correct_option',
    ];

    protected $casts = [
        'options' => 'array',  // To cast the JSON options as an array
    ];
    protected $hidden = ['created_at', 'updated_at'];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
