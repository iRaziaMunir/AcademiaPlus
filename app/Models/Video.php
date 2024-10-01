<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_attempt_id',
        'video_url',
    ];

    public function attempt()
    {
        return $this->belongsTo(QuizAttempt::class);
    }
}
