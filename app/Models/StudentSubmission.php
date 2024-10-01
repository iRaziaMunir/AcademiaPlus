<?php

// app/Models/StudentSubmission.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class StudentSubmission extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'cv_file',
        'status',
    ];

    protected $hidden = ['created_at', 'updated_at', 'token', 'student_id'];
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

//     public function user()
// {
//     return $this->hasOne(User::class, 'student_id');
// }
}

