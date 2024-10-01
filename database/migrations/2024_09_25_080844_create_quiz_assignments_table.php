<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  
    public function up()
{
    Schema::create('quiz_assignments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('quiz_id')->constrained('quizzes')->onDelete('cascade');
        $table->foreignId('student_id')->constrained('users')->onDelete('cascade');  // Assuming students are in the users table
        $table->timestamp('assigned_at');
        $table->timestamp('due_at');
        $table->enum('status', ['assigned', 'completed', 'expired'])->default('assigned');
        $table->timestamps();
    });
}

    public function down()
    {
        Schema::dropIfExists('quiz_assignments');
    }
};
