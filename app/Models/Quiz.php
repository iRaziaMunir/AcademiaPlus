<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'scheduled_at',
        'expires_at',
    ];

    protected $hidden = ['created_at', 'updated_at'];

    public function assignments()
    {
        return $this->hasMany(QuizAssignment::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
