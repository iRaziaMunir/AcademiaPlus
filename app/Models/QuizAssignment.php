<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_id',
        'student_id',
        'assigned_at',
        'due_at',
        'status',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }
}
