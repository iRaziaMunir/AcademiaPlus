<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'student_id',
        'score',
        'status',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function assignment()
    {
        return $this->belongsTo(QuizAssignment::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function answers()
{
    return $this->hasMany(QuizAttemptAnswer::class, 'attempt_id');
}
}
